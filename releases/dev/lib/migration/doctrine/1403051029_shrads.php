<?php

class Shrads extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE school
  ADD shrads_id BIGINT NULL AFTER district_id,
  ADD INDEX (shrads_id);
      ");

      $conn->execute("
ALTER TABLE student
  ADD ru_sent DATETIME NULL AFTER ru_complete,
  ADD mo_sent DATETIME NULL AFTER mo_complete,
  ADD elem_ru_sent DATETIME NULL AFTER elem_ru_complete,
  ADD elem_mo_sent DATETIME NULL AFTER elem_mo_complete,
  ADD INDEX(ru_sent),
  ADD INDEX(mo_sent),
  ADD INDEX(elem_ru_sent),
  ADD INDEX(elem_mo_sent);
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE student
 DROP ru_sent,
 DROP mo_sent,
 DROP elem_ru_sent,
 DROP elem_mo_sent;
      ");

      $conn->execute("
ALTER TABLE school
 DROP shrads_id;
      ");
  }
}
