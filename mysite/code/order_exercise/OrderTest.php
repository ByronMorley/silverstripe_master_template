<?php

class OrderTest extends DataObject
{

    private static $db = array(
        'order' => 'Int(5)'
    );
    private static $has_many = array();
    private static $has_one = array(
        'OrderSelection' => 'OrderSelection',
        'RelatedMember' => 'Member',
        'OrderExercise' => 'OrderExercise'
    );


}