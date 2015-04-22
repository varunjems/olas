<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version20 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeIndex('student', 'student', array(
             'fields' => 
             array(
              0 => 'school_id',
              1 => 'student_id',
              2 => 'mo_class_id',
             ),
             ));
        $this->addIndex('student', 'school_student', array(
             'fields' => 
             array(
              0 => 'school_id',
              1 => 'student_id',
             ),
             'type' => 'unique',
             ));
        $this->addIndex('student_answer', 'student_assessment_question', array(
             'fields' => 
             array(
              0 => 'student_id',
              1 => 'question_id',
             ),
             'type' => 'unique',
             ));
    }

    public function down()
    {
        $this->addIndex('student', 'student', array(
             'fields' => 
             array(
              0 => 'school_id',
              1 => 'student_id',
              2 => 'mo_class_id',
             ),
             ));
        $this->removeIndex('student', 'school_student', array(
             'fields' => 
             array(
              0 => 'school_id',
              1 => 'student_id',
             ),
             'type' => 'unique',
             ));
        $this->removeIndex('student_answer', 'student_assessment_question', array(
             'fields' => 
             array(
              0 => 'student_id',
              1 => 'question_id',
             ),
             'type' => 'unique',
             ));
    }
}