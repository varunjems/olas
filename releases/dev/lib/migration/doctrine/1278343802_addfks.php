<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addfks extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('question', 'question_ru_page_id_question_page_id', array(
             'name' => 'question_ru_page_id_question_page_id',
             'local' => 'ru_page_id',
             'foreign' => 'id',
             'foreignTable' => 'question_page',
             ));
        $this->createForeignKey('question', 'question_mo_page_id_question_page_id', array(
             'name' => 'question_mo_page_id_question_page_id',
             'local' => 'mo_page_id',
             'foreign' => 'id',
             'foreignTable' => 'question_page',
             ));
        $this->createForeignKey('question_page', 'question_page_scale_id_scale_id', array(
             'name' => 'question_page_scale_id_scale_id',
             'local' => 'scale_id',
             'foreign' => 'id',
             'foreignTable' => 'scale',
             ));
        $this->createForeignKey('scale_value', 'scale_value_scale_id_scale_id', array(
             'name' => 'scale_value_scale_id_scale_id',
             'local' => 'scale_id',
             'foreign' => 'id',
             'foreignTable' => 'scale',
             ));
        $this->createForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_forgot_password_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_group_permission_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_group_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_remember_key_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_group_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_user_group_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_permission_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_user_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('student', 'student_school_id_school_id', array(
             'name' => 'student_school_id_school_id',
             'local' => 'school_id',
             'foreign' => 'id',
             'foreignTable' => 'school',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('student_answer', 'student_answer_question_id_question_id', array(
             'name' => 'student_answer_question_id_question_id',
             'local' => 'question_id',
             'foreign' => 'id',
             'foreignTable' => 'question',
             ));
        $this->createForeignKey('student_answer', 'student_answer_student_id_student_id', array(
             'name' => 'student_answer_student_id_student_id',
             'local' => 'student_id',
             'foreign' => 'id',
             'foreignTable' => 'student',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('question', 'question_ru_page_id_question_page_id');
        $this->dropForeignKey('question', 'question_mo_page_id_question_page_id');
        $this->dropForeignKey('question_page', 'question_page_scale_id_scale_id');
        $this->dropForeignKey('scale_value', 'scale_value_scale_id_scale_id');
        $this->dropForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id');
        $this->dropForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id');
        $this->dropForeignKey('student', 'student_school_id_school_id');
        $this->dropForeignKey('student_answer', 'student_answer_question_id_question_id');
        $this->dropForeignKey('student_answer', 'student_answer_student_id_student_id');
    }
}