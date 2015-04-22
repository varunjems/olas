<?php

/**
 * Student ID form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentIdForm extends BaseForm {
	public function setup() {
		$this->setWidgets(array(
            'student_id'   => new sfWidgetFormInputText(array(
                'label'=>'Please enter your Student ID Number.'
            ), array(
                'required' => 'required',
                'pattern' => '\d+',
            )),
            'student_id2'   => new sfWidgetFormInputText(array(
                'label'=>'Please re-enter your Student ID Number.'
            ), array(
                'required' => 'required',
                'pattern' => '\d+',
            )),
		));

		$this->setValidators(array(
			'student_id' => new sfValidatorAnd(array(
				new sfValidatorRegex(array(
					'pattern' => '/^[0-9]{1,10}$/',
					'required' => true,
				), array(
					'required' => 'You must enter a Student ID Number before continuing.',
					'invalid' => 'Your Student ID must be numeric and cannot exceed 10 digits.',
				)),
				new sfValidatorRegex(array(
					'pattern' => '/[^0]/',
				), array(
					'invalid' => 'You entered only zeros. Please enter a Student ID Number in the correct format.',
				))
			), array(
				'required' => true,
				'halt_on_error' => true,
			), array(
				'required' => 'You must enter a Student ID Number before continuing.',
			)),
			'student_id2' => new sfValidatorPass(),
/*
			'student_id2' => new sfValidatorAnd(array(
				new sfValidatorRegex(array(
					'pattern' => '/^[0-9]{1,10}$/',
					'required' => true,
				), array(
					'required' => '',
					'invalid' => '',
				)),
				new sfValidatorRegex(array(
					'pattern' => '/[1-9]/',
				), array(
					'invalid' => '',
				))
			), array(
				'required'=>true,
			), array(
				'required' => '',
			)),
*/
		));

		$this->mergePostValidator(
			new sfValidatorCallback(array('callback' => array($this, 'checkStudentId2')))
/*
			new sfValidatorSchemaCompare('student_id', sfValidatorSchemaCompare::EQUAL, 'student_id2', array('throw_global_error'=>false), array('invalid'=>'You entered two different Student ID Numbers.'))
*/
		);

		$this->widgetSchema->setNameFormat('student[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}

	public function checkStudentId2($validator, $values) {
		if (!empty($values['student_id']) && ($values['student_id'] !== $values['student_id2'])) {
			throw new sfValidatorError($validator, 'You entered two different Student ID Numbers.');
		}

		return $values;
	}
}
