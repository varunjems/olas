<?php

/**
 * landing actions.
 *
 * @package    olas
 * @subpackage landing
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class landingActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
    }

   /**
    * @param sfRequest $request A request object
    */
    public function executeStart(sfWebRequest $request)
    {
        $time  = $this->getRequest()->getParameter('time', null);
        $shradsId  = $this->getRequest()->getParameter('schoolId', null);
        $product  = $this->getRequest()->getParameter('product', null);
        $level  = $this->getRequest()->getParameter('level', null);
        $sig  = $this->getRequest()->getParameter('sig', null);

        if ($time && $shradsId && $product && $level) {
            $hmac = hash_hmac('sha256', $product.$level.$shradsId.$time, csSettings::get('survey_secret', 'd32e8eba-5f67-49b8-bf7d-96a44ffc50a4'));
            if ($sig !== $hmac) {
                // Signature is wrong
                return 'Error';
            }

            $now = time();
            if ($time < ($now - 60) || $time > ($now + 60)) {
                // Time not close enough, redirect back to SCORE page
                return 'Error';
            }

            // Get school name
            // Determine assessment name
            switch ($product) {
                case 'ru':
                    $this->assessment = 'revvingup';
                    break;

                case 'mo':
                    $this->assessment = 'movingon';
                    break;

                default:
                    // Wrong information passed, redirect back to SCORE page
                    return 'Error';
                    break;
            }

            switch ($level) {
                case 's':
                    $route = 'language_choice_sid';
                    break;

                case 'e':
                    $route = 'elem_student_signin_sid';
                    break;

                default:
                    // Wrong information passed, redirect back to SCORE page
                    return 'Error';
                    break;
            }

            $school = Doctrine::getTable('School')
                ->createQuery('s')
                ->where('s.shrads_id = ?', $shradsId)
                ->useResultCache(true, 300)
                ->fetchOne();

            if (empty($school)) {
                // Wrong information passed, redirect back to SCORE page
                return 'Error';
            }

            $this->school = $school->url_identifier;
        } else {
            // Information not passed, redirect back to SCORE page
            return 'Error';
        }

        // Redirect to appropriate survey using a valid (temporary) sid
        $this->sid = $this->generateSession();

        $this->redirect("@{$route}?assessment=".$this->assessment.'&school='.$this->school.'&sid='.$this->sid);
    }

    public function generateSession($id = -2)
    {
        if ($id == -2) {
            $x = rand(100000, 999999);
            $id = rand(100000, 999999);
        } else {
            $x = rand(1000000, 9999999);
        }
        $dt = time()-1404249000;
        $sig = md5($x.$id.$dt.sfConfig::get('app_session_secret', 'Hcocc1DfJnqiYraVRVPtF0WDICRg2dQo'));
        $sid = $x.'i'.$id.'i'.$dt.'i'.$sig;

        return $sid;
    }
}
