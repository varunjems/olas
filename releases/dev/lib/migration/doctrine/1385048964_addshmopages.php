<?php

class Addshmopages extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
INSERT INTO question_page
  (type, page, title, intro, instructions, scale_id, title_es, intro_es, instructions_es)
SELECT 'elem_mo' as type, page, title, intro, instructions, scale_id, title_es, intro_es, instructions_es
  FROM question_page
 WHERE type = 'elem_ru'
;
      ");

      $conn->execute("
UPDATE question q
   SET q.elem_mo_question_number = q.elem_ru_question_number,
       q.elem_mo_page_id = (
           SELECT DISTINCT qp.id FROM question_page qp
            WHERE qp.type = 'elem_mo'
              AND qp.page = (
                SELECT qp2.page FROM question_page qp2
                 WHERE qp2.type = 'elem_ru'
                   AND qp2.id = q.elem_ru_page_id
              )
       )
;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question q
   SET q.elem_mo_question_number = null,
       q.elem_mo_page_id = null
;
      ");

      $conn->execute("
DELETE FROM question_page
 WHERE type = 'elem_mo'
;
      ");
  }
}
