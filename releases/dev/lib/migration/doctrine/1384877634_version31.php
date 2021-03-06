<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version31 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('question', 'elem_mo_page_id', 'integer', '5', array(
             'unsigned' => '1',
             ));
        $this->addColumn('question', 'elem_mo_question_number', 'integer', '8', array(
             ));
        $this->addColumn('school', 'elem_mo_enabled', 'boolean', '25', array(
             'notnull' => '1',
             'default' => '0',
             ));
        $this->addColumn('student', 'elem_mo_age', 'integer', '1', array(
             ));
        $this->addColumn('student', 'elem_mo_grade', 'integer', '1', array(
             ));
        $this->addColumn('student', 'elem_mo_class_id', 'string', '2', array(
             ));
        $this->addColumn('student', 'elem_mo_teacher', 'string', '255', array(
             ));
        $this->addColumn('student', 'elem_mo_ethnicity', 'integer', '1', array(
             ));
        $this->addColumn('student', 'elem_mo_start', 'timestamp', '25', array(
             ));
        $this->addColumn('student', 'elem_mo_complete', 'timestamp', '25', array(
             ));
        $this->changeColumn('question_page', 'type', 'enum', '', array(
             'values' => 
             array(
              0 => 'ru',
              1 => 'mo',
              2 => 'sh_ru',
              3 => 'sh_mo',
             ),
             ));
        $this->changeColumn('student_answer', 'assessment', 'enum', '', array(
             'values' => 
             array(
              0 => 'ru',
              1 => 'mo',
              2 => 'sh_ru',
              3 => 'sh_mo',
             ),
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('question', 'elem_mo_page_id');
        $this->removeColumn('question', 'elem_mo_question_number');
        $this->removeColumn('school', 'elem_mo_enabled');
        $this->removeColumn('student', 'elem_mo_age');
        $this->removeColumn('student', 'elem_mo_grade');
        $this->removeColumn('student', 'elem_mo_class_id');
        $this->removeColumn('student', 'elem_mo_teacher');
        $this->removeColumn('student', 'elem_mo_ethnicity');
        $this->removeColumn('student', 'elem_mo_start');
        $this->removeColumn('student', 'elem_mo_complete');
    }
}