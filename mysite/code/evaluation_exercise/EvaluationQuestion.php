<?php

class EvaluationQuestion extends Page
{

    private static $db = array(
        'multiple_answer_allowed' => 'Boolean'
    );

    private static $has_one = array(
        'Evaluation' => 'Evaluation'
    );
    private static $has_many = array(
        'EvaluationQuestionChoices' => 'EvaluationQuestionChoice'
    );

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Choices', CheckboxField::create('multiple_answer_allowed', 'Mulitple answers allowed'));
        $fields->addFieldToTab('Root.Choices', GridField::create(
            'EvaluationQuestionChoice',
            'EvaluationQuestionChoices',
            $this->EvaluationQuestionChoices(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }

}

class EvaluationQuestion_Controller extends ContentController
{

    public function evaluationQuestionChoice()
    {
        return EvaluationQuestionChoice::get();

    }
}