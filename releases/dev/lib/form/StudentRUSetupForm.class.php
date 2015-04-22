<?php

/**
 * Student ID form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentRUSetupForm extends BaseForm {
	public function setup() {
		$eDChoices = Doctrine::getTable('ScaleValue')
			->createQuery('v')
			->select('v.value, v.description')
			->leftJoin('v.Scale s')
			->where('s.description = ?', 'Ethnicity')
			->orderBy('v.value')
			->execute();
		$eChoices = array();
		foreach ($eDChoices as $choice) {
			$eChoices[$choice['value']] = $choice['description'];
		}

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
			'class_id'   => new sfWidgetFormInputText(array('label'=>'Class Number')),
			'ethnicity'   => new sfWidgetFormSelectRadio(array('label'=>'Race/Ethnicity', 'choices'=>$eChoices)),
			'gender'   => new sfWidgetFormSelectRadio(array('label'=>'Gender', 'choices'=>$gChoices)),
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
			'ethnicity' => new sfValidatorInteger(array(
				'required' => false,
			), array(
			)),
			'gender' => new sfValidatorInteger(array(
				'required' => false,
			), array(
			)),
		));

		$this->widgetSchema->setNameFormat('ru[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}
}
