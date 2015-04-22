<?php

class Addshradserror extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
  ADD shrads_error TEXT NULL;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
 DROP shrads_error;
      ");
  }
}
