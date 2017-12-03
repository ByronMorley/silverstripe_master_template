<?php

class ScenarioTest extends DataObject {

    private static $db = array(
        'answer_given' => 'Varchar(25)'
    );

    private static $has_one = array(
        'RelatedMember' => 'Member',
        'ScenarioExercise' => 'ScenarioExercise'
    );

}