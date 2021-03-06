<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version25 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('question', 'question_es', 'string', '255', array(
             ));
        $this->addColumn('question_page', 'title_es', 'string', '255', array(
             ));
        $this->addColumn('question_page', 'intro_es', 'clob', '65532', array(
             ));
        $this->addColumn('question_page', 'instructions_es', 'clob', '65532', array(
             ));
        $this->addColumn('scale_value', 'description_es', 'string', '64', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('question', 'question_es');
        $this->removeColumn('question_page', 'title_es');
        $this->removeColumn('question_page', 'intro_es');
        $this->removeColumn('question_page', 'instructions_es');
        $this->removeColumn('scale_value', 'description_es');
    }
}