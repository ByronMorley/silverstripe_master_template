<?php

class EvaluationQuestionChoice extends DataObject {

    private static $db = array(
        'choice' => 'Varchar(200)',
        'extended_field' => 'Boolean',
        'textfieldonly' => 'Boolean'
    );

    private static $has_one = array(
        'EvaluationQuestion' => 'EvaluationQuestion',
    );

    public function getCMSFields()
    {

        $fields = FieldList::create(
            TextField::create('choice', 'Choice'),
            CheckboxField::create('extended_field', 'Extend field allowed'),
            CheckboxField::create('textfieldonly', 'Text only')
        );

        return $fields;
    }
}