<?php

class urlPDOSessionStorage extends sfPDOSessionStorage {
	public function initialize($options = null) {
		// Get session id from URL
		if ($sid = sfContext::getInstance()->getRequest()->getParameter('sid')) {
			session_id($sid);
		}

		parent::initialize($options);
	}
}
