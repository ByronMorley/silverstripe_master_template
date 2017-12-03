<?php


class EvaluationAnswers extends DataObject {

    private static $db = array(
        'Text'=>'VarChar(300)',
        'Ticked'=>'Boolean'
    );

    private static $has_one = array(
        'EvaluationQuestionChoice' => 'EvaluationQuestionChoice',
        'RelatedMember' => 'Member',
    );

}