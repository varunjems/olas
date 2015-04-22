<?php

class scorePushTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', 'app', sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'front'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'score';
    $this->name             = 'push';
    $this->briefDescription = 'Push assessment data to SCORE';
    $this->detailedDescription = <<<EOF
The [score:push|INFO] task sends any student assessment information to SCORE
that has not yet been sent.

Call it with

  [php symfony score:push|INFO]
EOF;
  }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        // TODO: Find student records to send to SCORE and send them
        // Has a X_completed but no X_sent or X_shrads
        // AND is a school where shrads_id is set

        $conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
        $dbh = $conn->getDbh();

        // RU HS
        while (true) {
            $q = $this->baseQuery()
                ->select('s.id, s.student_id, s.first_name, s.last_name, s.ru_class_id, s.ethnicity, s.gender, s.ru_complete, s.school_id, sc.shrads_id')
                ->andWhere('s.ru_complete IS NOT NULL AND s.ru_sent IS NULL')
            ;

            $students = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

            if (empty($students)) {
                // No more students to process for RU HS
                break;
            }

            foreach ($students as $student) {
                $submission = array_merge(
                    $this->baseSubmission($student),
                    array(
                        'RawRevvingUpDataInsertTime' => (new \DateTime())->format('c'),
                        'ClassKey' => $student['ru_class_id'],
                        'GenderID' => $student['gender'],
                        'EthnicityID' => $student['ethnicity'],
                        'Date' => (new \DateTime($student['ru_complete']))->format('c'),
                    ),
                    $this->getAnswers($student['id'], 'ru')
                );

                $rec = $this->submit($submission, 'RU_HighSchool.aspx');

                $cur = Doctrine::getTable('Student')->find($student['id']);
                if (empty($rec['ErrorID']) && empty($rec['ErrorText'])) {
                    $cur->ru_sent = (new \DateTime())->format('c');
                    $cur->ru_shrads = $rec['OutputID'];
                } else {
                    $cur->shrads_error = json_encode($rec);
                }
                $cur->save();
            }
        }


        // MO HS
        while (true) {
            $q = $this->baseQuery()
                ->select('s.id, s.student_id, s.first_name, s.last_name, s.gender, s.mo_class_id, s.lesson_count, s.mo_complete, s.school_id, sc.shrads_id')
                ->andWhere('s.mo_complete IS NOT NULL AND s.mo_sent IS NULL')
            ;

            $students = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

            if (empty($students)) {
                // No more students to process for MO HS
                break;
            }

            foreach ($students as $student) {
                $submission = array_merge(
                    $this->baseSubmission($student),
                    array(
                        'RawMovingOnDataInsertTime' => (new \DateTime())->format('c'),
                        'ClassKey' => $student['mo_class_id'],
                        'Date' => (new \DateTime($student['mo_complete']))->format('c'),
                        'LessonsCompleted' => $student['lesson_count'],
                    ),
                    $this->getAnswers($student['id'], 'mo')
                );

                $rec = $this->submit($submission, 'MO_HighSchool.aspx');

                $cur = Doctrine::getTable('Student')->find($student['id']);
                if (empty($rec['ErrorID']) && empty($rec['ErrorText'])) {
                    $cur->mo_sent = (new \DateTime())->format('c');
                    $cur->mo_shrads = $rec['OutputID'];
                } else {
                    $cur->shrads_error = json_encode($rec);
                }
                $cur->save();
            }
        }


        // RU Elem
        while (true) {
            $q = $this->baseQuery()
                ->select('s.id, s.student_id, s.first_name, s.last_name, s.gender, s.elem_ru_age, s.elem_ru_grade, s.elem_ru_teacher, s.elem_ru_ethnicity, s.elem_ru_class_id, s.elem_ru_complete, s.school_id, sc.shrads_id')
                ->andWhere('s.elem_ru_complete IS NOT NULL AND s.elem_ru_sent IS NULL')
            ;

            $students = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

            if (empty($students)) {
                // No more students to process for RU Elem
                break;
            }

            foreach ($students as $student) {
                $submission = array_merge(
                    $this->baseSubmission($student),
                    array(
                        'RawRevvingUpDataInsertTime' => (new \DateTime())->format('c'),
                        'ClassKey' => $student['elem_ru_class_id'],
                        'GenderID' => $student['gender'],
                        'Age' => $student['elem_ru_age'],
                        'Grade' => $student['elem_ru_grade'],
                        'Teacher' => $student['elem_ru_teacher'],
                        'EthnicityID' => $student['elem_ru_ethnicity'],
                        'Date' => (new \DateTime($student['elem_ru_complete']))->format('c'),
                    ),
                    $this->getAnswers($student['id'], 'elem_ru')
                );

                $rec = $this->submit($submission, 'ERRU_ElementarySchool.aspx');

                $cur = Doctrine::getTable('Student')->find($student['id']);
                if (empty($rec['ErrorID']) && empty($rec['ErrorText'])) {
                    $cur->elem_ru_sent = (new \DateTime())->format('c');
                    $cur->elem_ru_shrads = $rec['OutputID'];
                } else {
                    $cur->shrads_error = json_encode($rec);
                }
                $cur->save();
            }
        }


        // MO Elem
        while (true) {
            $q = $this->baseQuery()
                ->select('s.id, s.student_id, s.first_name, s.last_name, s.gender, s.elem_mo_age, s.elem_mo_grade, s.elem_mo_teacher, s.elem_mo_ethnicity, s.elem_mo_class_id, s.elem_mo_complete, s.school_id, sc.shrads_id')
                ->andWhere('s.elem_mo_complete IS NOT NULL AND s.elem_mo_sent IS NULL')
            ;

            $students = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

            if (empty($students)) {
                // No more students to process for MO Elem
                break;
            }

            foreach ($students as $student) {
                $submission = array_merge(
                    $this->baseSubmission($student),
                    array(
                        'RawMovingOnDataInsertTime' => (new \DateTime())->format('c'),
                        'ClassKey' => $student['elem_mo_class_id'],
                        'GenderID' => $student['gender'],
                        'Age' => $student['elem_mo_age'],
                        'Grade' => $student['elem_mo_grade'],
                        'Teacher' => $student['elem_mo_teacher'],
                        'EthnicityID' => $student['elem_mo_ethnicity'],
                        'Date' => (new \DateTime($student['elem_mo_complete']))->format('c'),
                    ),
                    $this->getAnswers($student['id'], 'elem_mo')
                );

                $rec = $this->submit($submission, 'ERMO_ElementarySchool.aspx');

                $cur = Doctrine::getTable('Student')->find($student['id']);
                if (empty($rec['ErrorID']) && empty($rec['ErrorText'])) {
                    $cur->elem_mo_sent = (new \DateTime())->format('c');
                    $cur->elem_mo_shrads = $rec['OutputID'];
                } else {
                    $cur->shrads_error = json_encode($rec);
                }
                $cur->save();
            }
        }

        /*
        $qry = <<<xENDx
xENDx;

        $stmt = $dbh->prepare($qry);
        if ($stmt->execute(array())) {
            $qCol = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //$qCol[$row['id']] = $headercol++;
            }
        }
        $stmt = null;

        $student = Doctrine::getTable('Student')
            ->createQuery('s')
            ->where('s.school_id = ?', $schoolObj->getId())
            ->andWhere('s.student_id = ?', $studentNum)
            ->fetchOne();
        */
    }

    protected function submit($submission, $url)
    {
        $auth = array(csSettings::get('shrads_user'), csSettings::get('shrads_password'));
        $host = csSettings::get('shrads_endpoint');

        $client = new GuzzleHttp\Client();

        $resp = $client->post($host.'/'.$url, array(
                'auth' => $auth,
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ),
                'body' => json_encode(array($submission)),
            ));

        $body = $resp->getBody();
        $json = json_decode($body, true);

        $rec = $json[0];

        return $rec;
    }

    protected function baseQuery()
    {
        return Doctrine_Query::create()
            ->from('Student s')
            ->innerJoin('s.School sc')
            ->where('sc.shrads_id IS NOT NULL')
            ->andWhere('s.shrads_error IS NULL')
            ->orderBy('s.school_id')
            ->limit(10)
            ;
    }

    protected function getAnswers($studentId, $assessment)
    {
        $submission = array();

        $answers = Doctrine::getTable('StudentAnswer')
            ->createQuery('sa')
            ->select("sa.value, q.{$assessment}_question_number AS question_id")
            ->innerJoin('sa.Question q')
            ->where('sa.student_id = ?', $studentId)
            ->andWhere('sa.assessment = ?', $assessment)
            ->orderBy('sa.question_id')
            ->fetchArray();

        foreach ($answers as $answer) {
            $submission["A{$answer['question_id']}"] = $answer['value'];
        }

        return $submission;
    }

    protected function baseSubmission($student)
    {
        return array(
            'SchoolID' => $student['School']['shrads_id'],
            'StudentKey' => $student['student_id'],
            'FirstName' => $student['first_name'],
            'LastName' => $student['last_name'],
            'Active' => true,
        );
    }
}
