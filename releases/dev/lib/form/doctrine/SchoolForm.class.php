<?php

/**
 * School form.
 *
 * @package    olas
 * @subpackage form
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id$
 */
class SchoolForm extends BaseSchoolForm
{
  public function configure()
  {
	$this->validatorSchema['url_identifier'] = new sfValidatorAnd(array(
		new sfValidatorString(array(
			'max_length' => 64,
			'required' => true
		), array(
			'required' => 'A name for the school is required.',
			'max_length' => 'The URL ending has a maximum of 64 characters.'
		)),
		new sfValidatorRegex(array(
			'pattern' => '/^[0-9a-zA-Z.-]+$/',
			'required' => true,
		), array(
			'required' => 'The URL ending is required.',
			'invalid' => 'Only alpha-numeric characters, dashes, and periods accepted.'
		))
	),array(
		'required' => true,
		'halt_on_error' => true,
	),array(
		'required' => 'The URL ending is required.',
	));

	$this->validatorSchema['name'] = new sfValidatorString(array(
		'max_length' => 255,
		'required' => true
	), array(
		'required' => 'A name for the school is required.',
		'max_length' => 'The name must be less than 256 characters.'
	));

	$this->validatorSchema['school_id'] = new sfValidatorAnd(array(
		new sfValidatorString(array(
			'max_length' => 10,
			'required' => true
		), array(
			'required' => 'The School ID is required.',
			'max_length' => 'The School ID has a maximum of 10 characters.'
		)),
		new sfValidatorRegex(array(
			'pattern' => '/^[0-9]+(\.[0-9]+)?$/',
			'required' => true,
		), array(
			'required' => 'The School ID is required.',
			'invalid' => 'Only numeric values accepted.'
		))
	),array(
		'required' => true,
		'halt_on_error' => true,
	),array(
		'required' => 'The School ID is required.',
	));

	$this->validatorSchema['district_id'] = new sfValidatorAnd(array(
		new sfValidatorString(array(
			'max_length' => 10,
			'required' => true
		), array(
			'required' => 'The District ID is required.',
			'max_length' => 'The District ID has a maximum of 10 characters.'
		)),
		new sfValidatorRegex(array(
			'pattern' => '/^[0-9]+(\.[0-9]+)?$/',
			'required' => true,
		), array(
			'required' => 'The District ID is required.',
			'invalid' => 'Only numeric values accepted.'
		))
	),array(
		'required' => true,
		'halt_on_error' => true,
	),array(
		'required' => 'The District ID is required.',
	));

	$this->validatorSchema->setPostValidator(
		new sfValidatorAnd(array(
			new sfValidatorDoctrineUnique(array('model' => 'School', 'column' => array('url_identifier'))),
			new sfValidatorDoctrineUnique(array('model' => 'School', 'column' => array('school_id', 'district_id')
			),array(
				'invalid' => 'Another school with the same School ID and District ID already exists.'
			)),
		))
	);
  }
}
