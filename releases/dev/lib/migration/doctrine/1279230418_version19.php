<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version19 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('school', 'school_id', 'string', '10', array(
             'notnull' => '1',
             ));
        $this->changeColumn('school', 'district_id', 'string', '10', array(
             'notnull' => '1',
             ));
    }

    public function down()
    {

    }
}