<?php

class AddShradsId extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
  ADD ru_shrads BIGINT NULL AFTER ru_sent,
  ADD mo_shrads BIGINT NULL AFTER mo_sent,
  ADD elem_ru_shrads BIGINT NULL AFTER elem_ru_sent,
  ADD elem_mo_shrads BIGINT NULL AFTER elem_mo_sent;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
 DROP ru_shrads,
 DROP mo_shrads,
 DROP elem_ru_shrads,
 DROP elem_mo_shrads;
      ");
  }
}
