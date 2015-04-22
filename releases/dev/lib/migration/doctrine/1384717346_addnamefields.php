<?php

class Addnamefields extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
  ADD first_name VARCHAR(255) NULL DEFAULT NULL AFTER student_id,
  ADD last_name VARCHAR(255) NULL DEFAULT NULL AFTER first_name
;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
 DROP first_name,
 DROP last_name
;
      ");
  }
}
