<?php

/**
 * Student ID form
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class StudentElemRUEthnicityForm extends BaseForm {
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
		$this->setWidgets(array(
			'ethnicity'   => new sfWidgetFormSelectRadio(array('label'=>'Race/Ethnicity', 'choices'=>$eChoices)),
		));

		$this->setValidators(array(
			'ethnicity' => new sfValidatorInteger(array(
				'required' => false,
			), array(
                'required' => 'You must select an option before clicking the NEXT arrow.',
			)),
		));

		$this->widgetSchema->setNameFormat('ru[%s]');

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}
}
