<?php

class Uniqueschooldistrict extends Doctrine_Migration_Base
{
  public function up()
  {
	// School + District needs to be unique
	$options = array(
		'fields' => array(
			'school_id' => array(),
			'district_id' => array()
		),
		'type' => 'unique'
	);
	$this->removeIndex('school', 'school');
	$this->addIndex('school', 'school', $options);
  }

  public function down()
  {
	$options = array(
		'fields' => array(
			'school_id' => array(),
			'district_id' => array()
		)
	);
	$this->removeIndex('school', 'school');
	$this->addIndex('school', 'school', $options);
  }
}
