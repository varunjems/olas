<?php


class QuestionPageTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('QuestionPage');
    }
}