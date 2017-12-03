<?php

class Question extends DataObject
{

    private static $db = array(
        'Question' => 'Varchar(200)',
        'answer_1' => 'Varchar(50)',
        'answer_2' => 'Varchar(50)',
        'answer_3' => 'Varchar(50)',
        'correct_answer' => 'Varchar(50)',
    );

    private static $summary_fields = array(
        'Title' => 'Title',
        'Question' => 'Question',
        'correct_answer' => 'Answer',
    );

    private static $has_one = array(
        'QuestionExercise' => 'QuestionExercise'
    );

    public function getCMSFields()
    {

        $fields = FieldList::create(

            TextField::create('Question'),
            LabelField::create('Answers'),
            TextField::create('answer_1', '1'),
            TextField::create('answer_2', '2'),
            TextField::create('answer_3', '3'),
            DropdownField::create(
                'correct_answer',
                'Correct Answer',
                array(
                    '1' => 'Answer 1',
                    '2' => 'Answer 2',
                    '3' => 'Answer 3'
                )
            )
        );

        return $fields;
    }
}

