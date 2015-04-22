<?php

class Changequestion28 extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question
   SET question = 'talking with teachers about schoolwork.'
 WHERE elem_ru_question_number = 28;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question
   SET question = 'talking with teachers about class work.'
 WHERE elem_ru_question_number = 28;
      ");
  }
}
