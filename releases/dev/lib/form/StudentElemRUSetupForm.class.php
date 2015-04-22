<?php

/**
 * Student ID form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentElemRUSetupForm extends BaseForm {
	public function setup() {
		$gDChoices = Doctrine::getTable('ScaleValue')
			->createQuery('v')
			->select('v.value, v.description')
			->leftJoin('v.Scale s')
			->where('s.description = ?', 'Gender')
			->orderBy('v.value')
			->execute();
		$gChoices = array();
		foreach ($gDChoices as $choice) {
			$gChoices[$choice['value']] = $choice['description'];
		}

		$this->setWidgets(array(
            'gender'   => new sfWidgetFormSelectRadio(array(
                'label'=>'Gender',
                'choices'=>$gChoices
            ), array(
            )),
            'age'   => new sfWidgetFormInputText(array(
                'label'=>'Age'
            ), array(
                'pattern' => '\d*',
            )),
            'grade'   => new sfWidgetFormInputText(array(
                'label'=>'Grade'
            ), array(
                'pattern' => '\d*',
            )),
		));

		$this->setValidators(array(
			'gender' => new sfValidatorInteger(array(
                'required' => false,
			), array(
			)),
			'age' => new sfValidatorInteger(array(
				'min' => 1,
				'max' => 99,
				'required' => true
			), array(
				'required' => 'You must enter your age before clicking the NEXT arrow.',
				'min' => 'Please enter your age.',
				'max' => 'Please enter your age.',
				'invalid' => 'Please enter a number.',
			)),
			'grade' => new sfValidatorInteger(array(
				'min' => 1,
				'max' => 99,
				'required' => true
			), array(
				'required' => 'You must enter your grade before clicking the NEXT arrow.',
				'min' => 'Please enter your grade.',
				'max' => 'Please enter your grade.',
				'invalid' => 'Please enter a number.',
			)),
		));

		$this->widgetSchema->setNameFormat('ru[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}
}
