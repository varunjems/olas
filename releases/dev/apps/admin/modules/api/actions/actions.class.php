<?php

/**
 * api actions.
 *
 * @package    olas
 * @subpackage api
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions
{
    /**
     * Executes school create
     *
     * @param sfWebRequest $request A request object
     * @return \sfView
     */
    public function executeCreate(sfWebRequest $request)
    {
        if (sfView::NONE == $this->checkAuth($request)) {
            return sfView::NONE;
        }

        if (!$request->getMethod() == 'POST') {
            throw new sfError404Exception('Invalid request');
        }

        // get: school shradsId, district shradsId, name, url
        // generate: schoolId, districtId (prefix with 0.)
        $json = json_decode($request->getContent(), true);
        if (empty($json)) {
            throw new sfError404Exception('Invalid content');
        }

        if (empty($json['districtShradsId'])) {
            throw new sfError404Exception('District SHRADS id not provided');
        }

        if (empty($json['shradsId'])) {
            throw new sfError404Exception('SHRADS id not provided');
        }

        if (empty($json['url'])) {
            throw new sfError404Exception('URL not provided');
        }

        if (empty($json['name'])) {
            throw new sfError404Exception('School name not provided');
        }

        $school = Doctrine::getTable('School')
            ->createQuery('s')
            ->where('s.shrads_id = ?', $json['shradsId'])
            ->fetchOne();

        if (!$school) {
            $school = new School();
        }

        $school->setName($json['name']);
        $school->setShradsId($json['shradsId']);
        $school->setSchoolId('0.'.$json['shradsId']);
        $school->setDistrictId('0.'.$json['districtShradsId']);
        $school->setUrlIdentifier($json['url']);
        $school->setRuEnabled(true);
        $school->setMoEnabled(true);
        $school->setElemRuEnabled(true);
        $school->setElemMoEnabled(true);
        $school->save();

        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode(array(
                    'created' => true,
                    'id' => $school->getId(),
                )));
    }

    /**
     * Executes school update
     *
     * @param sfWebRequest $request A request object
     * @return \sfView
     */
    public function executeUpdate(sfWebRequest $request)
    {
        if (sfView::NONE == $this->checkAuth($request)) {
            return sfView::NONE;
        }

        if (!$request->getMethod() == 'POST') {
            throw new sfError404Exception('Invalid request');
        }

        $shradsId = $request->getParameter('shradsId');
        if (!$shradsId) {
            throw new sfError404Exception('School not found');
        }

        // get: school shradsId, district shradsId, name, url
        // generate: schoolId, districtId (prefix with 0.)
        $json = json_decode($request->getContent(), true);
        if (empty($json)) {
            throw new sfError404Exception('Invalid content');
        }

        $school = Doctrine::getTable('School')
            ->createQuery('s')
            ->where('s.shrads_id = ?', $shradsId)
            ->fetchOne();

        if (!$school) {
            throw new sfError404Exception('School not found');
        }

        if (!empty($json['name'])) {
            $school->setName($json['name']);
        }
        if (!empty($json['shradsId'])) {
            $school->setShradsId($json['shradsId']);
            $school->setSchoolId('0.' . $json['shradsId']);
        }
        if (!empty($json['districtShradsId'])) {
            $school->setDistrictId('0.'.$json['districtShradsId']);
        }
        if (!empty($json['url'])) {
            $school->setUrlIdentifier($json['url']);
        }
        $school->setRuEnabled(true);
        $school->setMoEnabled(true);
        $school->setElemRuEnabled(true);
        $school->setElemMoEnabled(true);
        $school->save();

        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode(array(
            'updated' => true,
            'id' => $school->getId(),
        )));
    }


    protected function checkAuth(sfWebRequest $request)
    {
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            if ($_SERVER['PHP_AUTH_USER'] == csSettings::get('api_username')) {
                if ($_SERVER['PHP_AUTH_PW'] == csSettings::get('api_password')) {
                    return 'AUTH';
                }
            }
        }

        $this->getResponse()->setHttpHeader('WWW-Authenticate',  'Basic realm="Secure Area"');
        $this->getResponse()->setStatusCode('401');
        $this->getResponse()->sendHttpHeaders();
        return sfView::NONE;
    }
}
