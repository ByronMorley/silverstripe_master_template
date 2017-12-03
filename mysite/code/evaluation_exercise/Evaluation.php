<?php

class Evaluation extends Page
{

    private static $has_many = array(
        'EvaluationQuestions' => 'EvaluationQuestion',
    );
}

class Evaluation_Controller extends ContentController
{

    private static $allowed_actions = array(
        'evaluationForm'
    );


    public function has_extended_field($ChoiceID)
    {

        $choice = EvaluationQuestionChoice::get()->filter('ID', $ChoiceID)->first();

        return $choice->textfieldonly || $choice->extended_field;

    }

    public function evaluationQuestionChoice($EvaluationQuestionID)
    {

        return EvaluationQuestionChoice::get()->filter('EvaluationQuestionID', $EvaluationQuestionID);
    }

    public function evaluationForm()
    {

        $fields = FieldList::create();

        $ExerciseID = $this->ID;
        $fields->push(HiddenField::create('exercise-id', '', $ExerciseID));

        $site_tree = SiteTree::get()->filter('ParentID', $ExerciseID);


        foreach ($site_tree as $page) {

            $EvaluationQuestion = $question = EvaluationQuestion::get()->filter('ID', $page->ID)->first();
            $EvaluationQuestionID = $EvaluationQuestion->ID;


            $EvaluationQuestionChoices = EvaluationQuestionChoice::get()->filter('EvaluationQuestionID', $EvaluationQuestionID);

            foreach ($EvaluationQuestionChoices as $EvaluationQuestionChoice) {

                $ChoiceID = $EvaluationQuestionChoice->ID;

                $has_text_area = ($EvaluationQuestionChoice->extended_field || $EvaluationQuestionChoice->textfieldonly) ? true : false;

                if ($has_text_area) {
                    $fields->push(
                        HiddenField::create('choice-' . $ChoiceID . '-text')
                            ->setAttribute('id', 'form-choice-' . $ChoiceID . '-text')
                    );
                }
                $fields->push(
                    HiddenField::create('choice-' . $ChoiceID . '-choice')
                        ->setAttribute('id', 'form-choice-' . $ChoiceID . '-choice')
                        ->setValue(0)
                );

            }
        }

        $actions = new FieldList(
            FormAction::create('submitTest', 'submit')->addExtraClass('no-display')
        );

        return new Form($this, 'evaluationForm', $fields, $actions);

    }

    public function submitTest($data, $form)
    {
        $UserID = Member::currentUserID();

        foreach ($data as $name => $value) {

            $name_array = explode("-", $name);
            $id = $name_array[1];
            $type = $name_array[2];

            $EvaluationAnswer = EvaluationAnswers::get()
                ->filter('EvaluationQuestionChoiceID', $id)
                ->filter('RelatedMemberID', $UserID)->first();

            if (isset($EvaluationAnswer)) {

                if ($type == "text") {

                    $EvaluationAnswer->Text = $value;
                    $EvaluationAnswer->Ticked = 1;
                    $EvaluationAnswer->write();

                } else if ($type == "choice") {

                    $EvaluationAnswer->Ticked = $value;
                    $EvaluationAnswer->write();
                }

            } else {

                $EvaluationAnswerObject = EvaluationAnswers::create();
                $EvaluationAnswerObject->EvaluationQuestionChoiceID = $id;
                $EvaluationAnswerObject->RelatedMemberID = $UserID;

                if ($type == "text") {

                    $EvaluationAnswerObject->Text = $value;
                    $EvaluationAnswerObject->Ticked = 1;
                    $EvaluationAnswerObject->write();

                } else if ($type == "choice") {

                    $EvaluationAnswerObject->Ticked = $value;
                    $EvaluationAnswerObject->write();
                }
            }

        }
    }
}