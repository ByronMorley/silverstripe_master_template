<?php
class OrderSelection extends DataObject {

    private static $db = array(
        'statement' => 'Varchar(200)',
        'correct_order' => 'int(5)',
    );

    private static $has_one = array(
        'OrderExercise' => 'OrderExercise'
    );

    private static $summary_fields = array(
        'statement' => 'Statement',
        'correct_order' => 'Answer',
    );

    public function getCMSFields()
    {

        $fields = FieldList::create(
            TextField::create('statement' ,'Statement' ),
            TextField::create('correct_order', 'Correct order')
        );

        return $fields;
    }
}
