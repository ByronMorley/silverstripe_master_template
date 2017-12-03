<?php

class QuestionExercise extends Page
{

    private static $has_many = array(
        'Questions' => 'Question',
    );

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Questions', GridField::create(
            'Question',
            'Questions',
            $this->Questions(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}

class QuestionExercise_Controller extends ContentController
{

    private static $allowed_actions = array(
        'questionForm'
    );

    public function init()
    {
        parent::init();
    }

    public function index()
    {
        if (Director::is_ajax()) {
            return $this->renderWith("QuestionExercise_ajax");
        } else {
            return $this->render();
        }
    }

    public function get_question_test_data()
    {
        return QuestionTest::get()
            ->filter('ExerciseID', $this->ID)
            ->filter('RelatedMemberID', Member::currentUserID());
    }

    function questionForm()
    {
        $fields = FieldList::create();

        $ExerciseID = $this->ID;
        $fields->push(HiddenField::create('exercise-id', '', $ExerciseID));
        $questions = Question::get()->filter('QuestionExerciseID', $ExerciseID);

        $UserID = Member::currentUserID();
        $fields->push(HiddenField::create('user-id', '', $UserID));

        foreach ($questions as $key => $question) {

            $QuestionID = $question->ID;
            $fields->push(
                HiddenField::create('Question-' . $QuestionID)
                    ->setAttribute('id', 'form-question-' . $QuestionID)
            );
        }

        $actions = new FieldList(
            FormAction::create('submitTest', 'submit')->addExtraClass('no-display')
        );

        return new Form($this, 'questionForm', $fields, $actions);
    }

    public function messageTest()
    {
        SS_Log::log("Message Log test", SS_Log::WARN);
    }

    public function submitTest($data, $form)
    {

        $UserID = Member::currentUserID();
        $ExerciseID = $data['exercise-id'];
        $questions = Question::get()->filter('QuestionExerciseID', $ExerciseID);

        foreach ($questions as $key => $question) {

            $field_name = 'Question-' . $question->ID;

            $questionTestObject = QuestionTest::get()
                ->filter('ExerciseID', $ExerciseID)
                ->filter('RelatedMemberID', $UserID)
                ->filter('QuestionID', $question->ID)->first();

            if (isset($questionTestObject)) {

                $questionTestObject->answer_given = $data[$field_name];
                $questionTestObject->write();

            } else {
                $questionObject = QuestionTest::create();
                $questionObject->answer_given = $data[$field_name];
                $questionObject->QuestionID = $question->ID;
                $questionObject->ExerciseID = $ExerciseID;
                $questionObject->RelatedMemberID = $UserID;
                $questionObject->write();
            }
        }
    }
}