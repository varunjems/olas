<?php // vim:ts=2 sw=2 et:

/**
 * main actions.
 *
 * @package    olas
 * @subpackage main
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class mainActions extends sfActions
{
  public $session_id;

  public function preExecute() {
    $assessment = $this->getRequest()->getParameter('assessment');
    $this->getResponse()->setSlot('product', $assessment);

      if (!$this->isValidSession()) {
          // TODO: Redirect to SCORE
          $this->forward404('Bad session');
      }
  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

 /**
  * Executes languageChoice action
  *
  * @param sfRequest $request A request object
  */
  public function executeLanguageChoice(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');
    $this->sid = $this->getSessionId();

    $schoolObj = $this->checkSchool($this->school, $this->assessment);
  }

 /**
  * Executes studentSignin action
  *
  * @param sfRequest $request A request object
  */
  public function executeStudentSignin(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');
    $this->page = 1;

    $schoolObj = $this->checkSchool($this->school, $this->assessment);

    $this->form = new StudentIdForm();

    if (!empty($_GET['student_id'])) {
      $request->setParameter('student', array(
        'student_id' => $_GET['student_id'],
        'student_id2' => $_GET['student_id'],
        '_csrf_token' => $this->form['_csrf_token']->getValue(),
      ));
      $request->setMethod('post');
    }

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('student'));
      if ($this->form->isValid())
      {
        $this->clearSession();
        $studentNum = $this->form->getValue('student_id');

        if (!$this->checkForTestUser($studentNum)) {
          $student = Doctrine::getTable('Student')
            ->createQuery('s')
            ->where('s.school_id = ?', $schoolObj->getId())
            ->andWhere('s.student_id = ?', $studentNum)
            ->fetchOne();

          // Check if student has already started
          if ($student) {
            $startFn = ($this->assessment=='revvingup'?'getRuStart':'getMoStart');
            if ($student->$startFn()) {
              // Check if student has already completed
              $endFn = ($this->assessment=='revvingup'?'getRuComplete':'getMoComplete');
              if ($student->$endFn()) {
                return 'CompletedError';
              } else {
                $this->setStudentId($student->getId());
                $this->signinPage = $this->generateUrl('student_signin_sid', array('sf_route'=>'student_signin_sid', 'assessment'=>$this->assessment, 'school'=>$this->school, 'sid'=>$this->getSessionId()));
                return 'StartedError';
              }
            } else {
              $this->setStudentId($student->getId());
            }
          } else {
              try {
                  $req = json_encode(
                      array(
                          'schoolId' => $schoolObj->getShradsId(),
                          'product' => ($this->assessment == 'revvingup' ? 'ru' : 'mo'),
                          'level' => 's',
                          'user' => $studentNum,
                      )
                  );

                  $client = new \GuzzleHttp\Client();
                  /* @var $res \GuzzleHttp\Message\ResponseInterface */
                  $res = $client->post(
                      csSettings::get('score_endpoint').'/api/licence',
                      array(
                          'auth' => array(csSettings::get('score_user'), csSettings::get('score_password')),
                          'headers' => array(
                              'Content-Type' => 'application/json',
                              'Accept' => 'application/json',
                          ),
                          'body' => $req,
                          'connect_timeout' => 10,
                          'timeout' => 10,
                      )
                  );

                  $json = $res->json();

                  if (!empty($json['success'])) {
                      // Used a licence, just pass through
                  } elseif (!empty($json['code']) && $json['code'] == '422') {
                      return 'NoLicenceError';
                  } else {
                      $this->errorMessage = json_encode($json);
                      return 'OtherLicenceError';
                  }
              } catch (\GuzzleHttp\Exception\RequestException $e) {
                  $res = $e->getResponse();
                  if ($res && $res->getStatusCode() == '422') {
                      // Not enough licences available
                      return 'NoLicenceError';
                  }

                  // 5xx, 4xx, or networking error
                  $this->errorMessage = $e->getMessage();
                  return 'OtherLicenceError';
              } catch (\Exception $e) {
                  // other error
                  $this->errorMessage = $e->getMessage();
                  return 'OtherLicenceError';
              }


            $student = new Student();
            $student->setSchool($schoolObj);
            $student->setStudentId($studentNum);
            $student->save();
            $this->setStudentId($student->getId());
          }
        }

        $this->redirect('@student_name?assessment='.$this->assessment.'&school='.$this->school.'&sid='.$this->getSessionId());
      }
      else if (!empty($_GET['student_id'])) {
        $this->redirect('@student_signin_sid?assessment='.$this->assessment.'&school='.$this->school.'&sid='.$this->getSessionId());
      }
      else if (($request->getParameter('started', 'NO') == 'OK') || ($request->getParameter('started', 'NO') == 'Aceptar'))
      {
        $student_id = $this->getStudentId();
        $student = Doctrine::getTable('Student')->find($student_id);

        $lastAnswer = Doctrine::getTable('StudentAnswer')
          ->createQuery('a')
          ->select('a.id, q.id as q_id, qp.page AS page')
          ->leftJoin('a.Question q')
          ->leftJoin('q.'.($this->assessment=='revvingup'?'RU':'MO').'Page qp')
          ->where('a.student_id = ?', $student->getId())
          ->andWhere('a.assessment = ?', ($this->assessment=='revvingup'?'ru':'mo'))
          ->orderBy('q.'.($this->assessment=='revvingup'?'ru':'mo').'_question_number DESC')
          ->limit(1)
          ->fetchArray();

        if (!empty($lastAnswer) && count($lastAnswer) == 1)
        {
          $nextPage = $lastAnswer[0]['page']+1;
          if ($nextPage < 3)
          {
            $nextPage = 3;
          }
        }
        else
        {
          $nextPage = 3;
        }

        $this->redirect('@question_page?assessment='.$this->assessment.'&school='.$this->school.'&page='.$nextPage.'&sid='.$this->getSessionId());
      }
    }
  }

 /**
  * Executes studentName action
  *
  * @param sfRequest $request A request object
  */
  public function executeStudentName(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');
    $this->page = 1;

    $schoolObj = $this->checkSchool($this->school, $this->assessment);

    if (!$this->isTestUser()
        && (!$request->getParameter('sid')
            || !$this->getStudentId()))
    {
      $this->redirect('@student_signin?assessment='.$this->assessment.'&school='.$this->school);
    }

    $this->form = new StudentNameForm();

    if (!$this->isTestUser())
    {
      $student_id = $this->getStudentId();
      $student = Doctrine::getTable('Student')->find($student_id);

      $this->form->setDefault('first_name', $student->getFirstName());
      $this->form->setDefault('last_name', $student->getLastName());
    }

    $this->allow_skip_name = false;
    if ($request->isMethod('post'))
    {
      $formData = $request->getParameter('student_name');
      $this->form->bind($formData);
      if ($this->form->isValid())
      {
        if (! $this->isTestUser())
        {
          $student->setFirstName($this->form->getValue('first_name'));
          $student->setLastName($this->form->getValue('last_name'));
          $student->save();
        }

        $this->redirect('@student_setup?assessment='.$this->assessment.'&school='.$this->school.'&sid='.$this->getSessionId());
      } else {
      }
    }
  }

 /**
  * Executes studentRUSetup action
  *
  * @param sfRequest $request A request object
  */
  public function executeStudentRUSetup(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');
    $this->page = 2;

    $schoolObj = $this->checkSchool($this->school, $this->assessment);

    if (!$this->isTestUser()
        && (!$request->getParameter('sid')
            || !$this->getStudentId()))
    {
      $this->redirect('@student_signin?assessment='.$this->assessment.'&school='.$this->school);
    }

    $this->form = new StudentRUSetupForm();

    if (!$this->isTestUser())
    {
      $student_id = $this->getStudentId();
      $student = Doctrine::getTable('Student')->find($student_id);

      $this->form->setDefault('class_id', $student->getRuClassId());
      $this->form->setDefault('ethnicity', $student->getEthnicity());
      $this->form->setDefault('gender', $student->getGender());
    }

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('ru'));
      if ($this->form->isValid())
      {
        if (! $this->isTestUser())
        {
          $student->setRuClassId($this->form->getValue('class_id'));
          $student->setEthnicity($this->form->getValue('ethnicity'));
          $student->setGender($this->form->getValue('gender'));
          $student->setRuStart(gmdate('Y-m-d H:i:s'));
          $student->save();
        }

        $this->redirect('@question_page?assessment='.$this->assessment.'&school='.$this->school.'&page=3&sid='.$this->getSessionId());
      }
    }
  }

 /**
  * Executes studentMOSetup action
  *
  * @param sfRequest $request A request object
  */
  public function executeStudentMOSetup(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');
    $this->page = 2;

    $schoolObj = $this->checkSchool($this->school, $this->assessment);

    if (!$this->isTestUser()
        && (!$request->getParameter('sid')
            || !$this->getStudentId()))
    {
      $this->redirect('@student_signin?assessment='.$this->assessment.'&school='.$this->school);
    }

    if (! $this->isTestUser())
    {
      $student_id = $this->getStudentId();
      $student = Doctrine::getTable('Student')->find($student_id);
    }

    $this->form = new StudentMOSetupForm();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('mo'));
      if ($this->form->isValid())
      {
        if (! $this->isTestUser())
        {
          $student->setMoClassId($this->form->getValue('class_id'));
          $student->setLessonCount($this->form->getValue('lessons'));
          $student->setMoStart(gmdate('Y-m-d H:i:s'));
          $student->save();
        }

        $this->redirect('@question_page?assessment='.$this->assessment.'&school='.$this->school.'&page=3&sid='.$this->getSessionId());
      }
    }

    if (! $this->isTestUser())
    {
      $this->form->setDefault('class_id', $student->getMoClassId());
      $this->form->setDefault('lessons', $student->getLessonCount());
    }
  }

 /**
  * Executes page action
  *
  * @param sfRequest $request A request object
  */
  public function executePage(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');
    $this->page = $request->getParameter('page');

    $schoolObj = $this->checkSchool($this->school, $this->assessment);

    if (!$this->isTestUser()
        && (!$request->getParameter('sid')
            || !$this->getStudentId()))
    {
      $this->redirect('@student_signin?assessment='.$this->assessment.'&school='.$this->school);
    }

    $studentId = $this->getStudentId();

    $aType = ($this->assessment=='revvingup'?'ru':'mo');
    $this->qPage = Doctrine::getTable('QuestionPage')
      ->createQuery('q')
      ->where('q.page = ?', $this->page)
      ->andWhere('q.type = ?', $aType)
      ->useResultCache(true, 3600)
      ->fetchOne();

    $this->scaleValues = Doctrine::getTable('ScaleValue')
      ->createQuery('s')
      ->select('s.description, s.description_es, s.value')
      ->where('s.scale_id = ?', $this->qPage->scale_id)
      ->orderBy('s.value ASC')
      ->useResultCache(true, 3600)
      ->fetchArray();

    $this->questions = Doctrine::getTable('Question')
      ->createQuery('q')
      ->select("q.id, q.question, q.question_es, q.{$aType}_question_number AS question_number, NULL AS answer")
      ->where("q.{$aType}_page_id = ?", $this->qPage->id)
      ->orderBy("q.{$aType}_question_number ASC")
      ->useResultCache(true, 3600)
      ->fetchArray();

    if (!$this->isTestUser())
    {
      $qIds = array();
      foreach ($this->questions as $q) {
        $qIds[] = $q['id'];
      }

      $answers = Doctrine::getTable('StudentAnswer')
        ->createQuery('a')
        ->select('a.id, a.question_id, a.value AS answer')
        ->where('a.student_id = ?', $studentId)
        ->andWhereIn('a.question_id', $qIds)
        ->andWhere('a.assessment = ?', $aType)
        ->fetchArray();

      foreach ($answers as $a) {
        foreach ($this->questions as $key=>$value) {
          if ($this->questions[$key]['id'] == $a['question_id']) {
            $this->questions[$key]['answer'] = $a['answer'];
            break;
          }
        }
      }
    }

    $this->missingItem = 0;
    if ($request->isMethod('post'))
    {
      $conn = Doctrine::getTable('StudentAnswer')->getConnection();
      $conn->beginTransaction();
      if (! $this->isTestUser())
      {
        foreach ($this->questions as $key=>$question)
        {
          $answer = Doctrine::getTable('StudentAnswer')
            ->createQuery('a')
            ->where('a.student_id = ?', $studentId)
            ->andWhere('a.question_id = ?', $question['id'])
            ->andWhere('a.assessment = ?', $aType)
            ->fetchOne();

          if (!$answer)
          {
            $answer = new StudentAnswer();
            $answer->setStudentId($studentId);
            $answer->setQuestionId($question['id']);
            $answer->setAssessment($aType);
          }

          $this->questions[$key]['answer'] = !empty($_POST['q_'.$question['question_number']])?$_POST['q_'.$question['question_number']]:NULL;
          $answer->setValue($this->questions[$key]['answer']);
          $answer->save();

          if (null == $this->questions[$key]['answer'])
          {
            $this->missingItem++;
          }
        }
      }
      else
      {
        foreach ($this->questions as $key=>$question)
        {
          $this->questions[$key]['answer'] = !empty($_POST['q_'.$question['question_number']])?$_POST['q_'.$question['question_number']]:NULL;

          if (null == $this->questions[$key]['answer'])
          {
            $this->missingItem++;
          }
        }
      }
      $conn->commit();

      $nextPage = $this->page;
      $button = $request->getParameter('SButton');
      if (!$this->missingItem || !empty($_POST['missingok']) || ($button == 'Previous' || $button == 'Anterior'))
      {
        if ($button == 'Previous' || $button == 'Anterior')
        {
          $nextPage -= 1;
          $this->redirect('@question_page?assessment='.$this->assessment.'&school='.$this->school.'&page='.$nextPage.'&sid='.$this->getSessionId());
        }
        else
        {
          $nextPage += 1;
          $this->redirect('@question_page?assessment='.$this->assessment.'&school='.$this->school.'&page='.$nextPage.'&sid='.$this->getSessionId());
        }
      }
    }

    $this->prevButton = true;
    $this->nextButton = true;
    $this->finishButton = false;
    if ($this->page < 3)
    {
      $this->prevButton = false;
    }
    if ($this->page > 16)
    {
      $this->nextButton = false;
      $this->finishButton = true;
    }
  }

 /**
  * Executes completed action
  *
  * @param sfRequest $request A request object
  */
  public function executeCompleted(sfWebRequest $request)
  {
    $this->assessment = $request->getParameter('assessment');
    $this->school = $request->getParameter('school');

    $endFn = ($this->assessment=='revvingup'?'setRuComplete':'setMoComplete');

    if (!$this->isTestUser())
    {
      $student_id = $this->getStudentId();
      $student = Doctrine::getTable('Student')->find($student_id);
      $student->$endFn(gmdate('Y-m-d H:i:s'));
      $student->save();
    }

    $this->regenerateSession();
    $this->sid = $this->getSessionId();
  }





  protected function checkSchool($school_id, $assessment)
  {
//    $school = Doctrine::getTable('School')
//      ->findOneByUrlIdentifier($school_id);
    $school = Doctrine::getTable('School')
      ->createQuery('s')
      ->where('s.url_identifier = ?', $school_id)
      ->useResultCache(true, 300)
      ->fetchOne();

    if (!$school)
    {
      $this->forward('main', 'noSuchSchool');
    }

    if ($assessment == 'revvingup' && !$school->ru_enabled)
    {
      $this->forward('main', 'ruDisabled');
    }

    if ($assessment == 'movingon' && !$school->mo_enabled)
    {
      $this->forward('main', 'moDisabled');
    }

    return $school;
  }

 /**
  * Test for test user id
  *
  */
  protected function checkForTestUser($studentId = null)
  {
    // Note the ID "1111111111" is a dummy id to not save data
    if ('1111111111' === $studentId)
    {
      $this->setStudentId(-1);
    }

    return $this->isTestUser();
  }

 /**
  * Determine if the user is the test user
  *
  */
  protected function isTestUser()
  {
    return ($this->getStudentId() == -1);
  }

 /**
  * Executes ruDisabled action
  *
  * @param sfRequest $request A request object
  */
  public function executeRuDisabled(sfWebRequest $request)
  {
  }

 /**
  * Executes moDisabled action
  *
  * @param sfRequest $request A request object
  */
  public function executeMoDisabled(sfWebRequest $request)
  {
  }

  public function executeNoSuchSchool(sfWebRequest $request)
  {
    $this->school = $request->getParameter('school');
  }



  public function setStudentId($studentId)
  {
    $this->regenerateSession($studentId);
  }

  public function getStudentId()
  {
    $sid = $this->getSessionId();
    if (strpos($sid, 'i') !== false) {
      list($x, $id, $dt, $sig) = explode('i', $sid, 4);
      if ($sig == md5($x.$id.$dt.sfConfig::get('app_session_secret', 'Hcocc1DfJnqiYraVRVPtF0WDICRg2dQo'))) {
        if (($dt+1404249000) < (time() - 86400)) {
          return false;
        }

        if ($x < 1000000) {
          return false;
        }

        return $id;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

    public function isValidSession()
    {
        $sid = $this->getSessionId();
        if (strpos($sid, 'i') !== false) {
            list($x, $id, $dt, $sig) = explode('i', $sid, 4);
            if ($sig == md5($x.$id.$dt.sfConfig::get('app_session_secret', 'Hcocc1DfJnqiYraVRVPtF0WDICRg2dQo'))) {
                if (($dt+1404249000) < (time() - 86400)) {
                    return false;
                }

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

  public function clearSession()
  {
  }

  public function regenerateSession($id = -2)
  {
    $this->clearSession();
    if ($id == -2) {
      $x = rand(100000, 999999);
      $id = rand(100000, 999999);
    } else {
      $x = rand(1000000, 9999999);
    }
    $dt = time()-1404249000;
    $sig = md5($x.$id.$dt.sfConfig::get('app_session_secret', 'Hcocc1DfJnqiYraVRVPtF0WDICRg2dQo'));
    $this->setSessionId($x.'i'.$id.'i'.$dt.'i'.$sig);
  }

  public function getSessionId()
  {
    if (!empty($this->session_id))
    {
      return $this->session_id;
    }
    else
    {
      $sid = $this->getRequest()->getParameter('sid', false);
      $this->session_id = $sid;
      return $sid;
    }
  }

  public function setSessionId($sid)
  {
    $this->session_id = $sid;
  }

/*
  public function setStudentId($studentId)
  {
    $this->getUser()->setAttribute('student_id', $studentId);
  }

  public function getStudentId()
  {
    return $this->getUser()->getAttribute('student_id', false);
  }

  public function clearSession()
  {
    $this->getUser()->getAttributeHolder()->clear();
  }

  public function regenerateSession()
  {
    $this->clearSession();
    $this->getUser()->regenerateSession();
  }

  public function getSessionId()
  {
    return session_id();
  }
*/
}
