<?php

/**
 * Student ID form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentElemRUClassForm extends BaseForm {
	public function setup() {
		$this->setWidgets(array(
            'class_id'   => new sfWidgetFormInputText(array(
                'label'=>'Class Number'
            ), array(
                'required' => 'required',
                'pattern' => '\d*',
                'class' => 'number',
            )),
            'teacher'   => new sfWidgetFormInputText(array(
                'label'=>"Teacher's Name"
            ), array(
                'required' => 'required',
                'pattern' => '.{2,36}',
            )),
		));

		$this->setValidators(array(
			'class_id' => new sfValidatorInteger(array(
				'min' => 1,
				'max' => 99,
				'required' => true
			), array(
                'required' => 'You must enter a class number before clicking the NEXT arrow.',
				'min' => 'Please enter a number between 1 and 99.',
				'max' => 'Please enter a number between 1 and 99.',
				'invalid' => 'Please enter a number between 1 and 99.',
			)),
			'teacher' => new sfValidatorString(array(
				'required' => true,
			), array(
                'required' => "You must enter your teacher's name before clicking the NEXT arrow.",
			)),
		));

		$this->widgetSchema->setNameFormat('ru[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}
}
