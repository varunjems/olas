<?php

class Updateelemquestions extends Doctrine_Migration_Base
{
  public function up()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
ALTER TABLE question
  ADD old_elem_ru_qp BIGINT(20) UNSIGNED NULL DEFAULT NULL
      COMMENT 'Original elem question pages' AFTER elem_ru_question_number,
  ADD old_elem_ru_qn BIGINT(20) NULL DEFAULT NULL
      COMMENT 'Original elem question numbers' AFTER old_elem_ru_qp
;
      ");
      $conn->execute("
UPDATE question
   SET old_elem_ru_qn = elem_ru_question_number,
       old_elem_ru_qp = elem_ru_page_id,
       elem_ru_question_number = NULL,
       elem_ru_page_id = NULL
 WHERE old_elem_ru_qn IS NULL
   AND elem_ru_question_number IS NOT NULL;
      ");
      $conn->execute("
UPDATE question, 
       (
                  SELECT 1 AS new_id,    1 AS old_id
        UNION ALL SELECT 2,    2
        UNION ALL SELECT 3,    3
        UNION ALL SELECT 4,    4
        UNION ALL SELECT 5,    5
        UNION ALL SELECT 6,    6
        UNION ALL SELECT 7,    8
        UNION ALL SELECT 8,    9
        UNION ALL SELECT 9,   14
        UNION ALL SELECT 10,  15
        UNION ALL SELECT 11,  19
        UNION ALL SELECT 12,  21
        UNION ALL SELECT 13,  23
        UNION ALL SELECT 14,  28
        UNION ALL SELECT 15,  29
        UNION ALL SELECT 16,  30
        UNION ALL SELECT 17,  31
        UNION ALL SELECT 18,  32
        UNION ALL SELECT 19,  43
        UNION ALL SELECT 20,  45
        UNION ALL SELECT 21,  46
        UNION ALL SELECT 22,  49
        UNION ALL SELECT 23,  36
        UNION ALL SELECT 24,  39
        UNION ALL SELECT 25,  40
        UNION ALL SELECT 26,  41
        UNION ALL SELECT 27,  54
        UNION ALL SELECT 28,  57
        UNION ALL SELECT 29,  59
        UNION ALL SELECT 30,  60
        UNION ALL SELECT 31,  61
        UNION ALL SELECT 32,  62
        UNION ALL SELECT 33,  63
        UNION ALL SELECT 34,  65
        UNION ALL SELECT 35,  66
        UNION ALL SELECT 36,  70
        UNION ALL SELECT 37,  82
        UNION ALL SELECT 38,  83
        UNION ALL SELECT 39,  86
        UNION ALL SELECT 40,  87
        UNION ALL SELECT 41,  95
        UNION ALL SELECT 42,  97
        UNION ALL SELECT 43,  99
        UNION ALL SELECT 44, 100
        UNION ALL SELECT 45, 103
        UNION ALL SELECT 46, 104
        UNION ALL SELECT 47, 107
        UNION ALL SELECT 48, 112
        UNION ALL SELECT 49, 114
        UNION ALL SELECT 50, 115
        UNION ALL SELECT 51, 118
        UNION ALL SELECT 52, 119
        UNION ALL SELECT 53, 120
        UNION ALL SELECT 54, 122
        UNION ALL SELECT 55, 123
       ) AS qtbl
   SET question.elem_ru_question_number = qtbl.new_id,
       question.elem_ru_page_id = question.old_elem_ru_qp
 WHERE question.old_elem_ru_qn = qtbl.old_id
;
      ");
  }

  public function down()
  {
      $conn = Doctrine_Manager::getInstance()->getCurrentConnection();

      $conn->execute("
UPDATE question
   SET elem_ru_question_number = old_elem_ru_qn,
       elem_ru_page_id = old_elem_ru_qp
 WHERE old_elem_ru_qn IS NOT NULL
;
      ");
      $conn->execute("
ALTER TABLE question
 DROP old_elem_ru_qp,
 DROP old_elem_ru_qn
;
      ");
  }
}
