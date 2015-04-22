<?php

/**
 * Student ID form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentMOSetupForm extends BaseForm {
	public function setup() {
		$this->setWidgets(array(
			'class_id'   => new sfWidgetFormInputText(array('label'=>'Class Number')),
			'lessons'   => new sfWidgetFormInputText(array('label'=>'Number of Success Highways Lessons Completed')),
		));

		$this->setValidators(array(
			'class_id' => new sfValidatorInteger(array(
				'min' => 1,
				'max' => 99,
				'required' => true
			), array(
				'required' => 'You must enter a Class Number before proceeding.',
				'min' => 'Please enter a number between 1 and 99.',
				'max' => 'Please enter a number between 1 and 99.',
				'invalid' => 'Please enter a number between 1 and 99.',
			)),
			'lessons' => new sfValidatorInteger(array(
				'min' => 0,
				'max' => 15,
				'required' => true,
			), array(
				'required' => 'Please enter the number of Success Highways lessons completed before proceeding.',
				'min' => 'Please enter a number between 0 and 15.',
				'max' => 'Please enter a number between 0 and 15.',
				'invalid' => 'Please enter a number between 0 and 15.',
			)),
		));

		$this->widgetSchema->setNameFormat('mo[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}
}
