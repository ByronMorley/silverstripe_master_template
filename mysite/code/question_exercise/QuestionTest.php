<?php

class QuestionTest extends DataObject {

    private static $db = array(
        'answer_given'=>'Varchar(100)'
    );
    private static $has_many = array(

    );
    private static $has_one = array(
        'Question'=> 'Question',
        'RelatedMember' => 'Member',
        'Exercise' => 'Exercise'
    );


}