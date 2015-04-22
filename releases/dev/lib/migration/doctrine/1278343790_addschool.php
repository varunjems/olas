<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addschool extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('school', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'unsigned' => true,
              'autoincrement' => true,
              'length' => 5,
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'school_id' => 
             array(
              'type' => 'string',
              'length' => 10,
             ),
             'district_id' => 
             array(
              'type' => 'string',
              'length' => 10,
             ),
             'url_identifier' => 
             array(
              'type' => 'string',
              'length' => 64,
             ),
             'ru_enabled' => 
             array(
              'type' => 'boolean',
              'notnull' => true,
              'default' => 1,
              'length' => 25,
             ),
             'mo_enabled' => 
             array(
              'type' => 'boolean',
              'notnull' => true,
              'default' => 1,
              'length' => 25,
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
              'url' => 
              array(
              'fields' => 'url_identifier',
              'type' => 'unique',
              ),
              'name' => 
              array(
              'fields' => 'name',
              ),
              'school' => 
              array(
              'fields' => 
              array(
               0 => 'school_id',
               1 => 'district_id',
              ),
              ),
              'district_id' => 
              array(
              'fields' => 'district_id',
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_bin',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('school');
    }
}