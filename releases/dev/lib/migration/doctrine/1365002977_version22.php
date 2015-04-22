<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version22 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('school', 'elem_ru_enabled', 'boolean', '25', array(
             'notnull' => '1',
             'default' => '0',
             ));
        $this->addColumn('student', 'elem_ru_age', 'integer', '1', array(
             ));
        $this->addColumn('student', 'elem_ru_grade', 'integer', '1', array(
             ));
        $this->addColumn('student', 'elem_ru_class_id', 'string', '2', array(
             ));
        $this->addColumn('student', 'elem_ru_teacher', 'string', '255', array(
             ));
        $this->addColumn('student', 'elem_ru_ethnicity', 'integer', '1', array(
             ));
        $this->addColumn('student', 'elem_ru_start', 'timestamp', '25', array(
             ));
        $this->addColumn('student', 'elem_ru_complete', 'timestamp', '25', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('school', 'elem_ru_enabled');
        $this->removeColumn('student', 'elem_ru_age');
        $this->removeColumn('student', 'elem_ru_grade');
        $this->removeColumn('student', 'elem_ru_class_id');
        $this->removeColumn('student', 'elem_ru_teacher');
        $this->removeColumn('student', 'elem_ru_ethnicity');
        $this->removeColumn('student', 'elem_ru_start');
        $this->removeColumn('student', 'elem_ru_complete');
    }
}