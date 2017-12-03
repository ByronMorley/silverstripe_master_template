<?php

class ScenarioExercise extends Page
{

    private static $db = array(
        'correct_answer' => 'varChar(25)',
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $tab = DropdownField::create(
            'correct_answer',
            'Correct answer',
            array(
                'limitation' => 'Limitation',
                'problem' => 'Problem',
            )
        );

        $fields->addFieldToTab('Root.Choices', $tab);

        return $fields;
    }


}

class ScenarioExercise_Controller extends ContentController
{


    private static $allowed_actions = array(
        'scenarioForm'
    );

    public function index()
    {
        if (Director::is_ajax()) {
            return $this->renderWith("ScenarioExercise_ajax");
        } else {
            return $this->render();
        }
    }

    function scenarioForm()
    {
        $fields = FieldList::create();

        $ExerciseID = $this->ID;
        $fields->push(HiddenField::create('exercise-id', '', $ExerciseID));
        $UserID = Member::currentUserID();
        $fields->push(HiddenField::create('user-id', '', $UserID));
        $fields->push(HiddenField::create('answer_given'));

        $actions = new FieldList(
            FormAction::create('submitTest', 'submit')->addExtraClass('no-display')
        );

        return new Form($this, 'scenarioForm', $fields, $actions);
    }

    public function submitTest($data, $form)
    {
        $field_name = "answer_given";

        $UserID = Member::currentUserID();
        $ExerciseID = $data['exercise-id'];

        $ScenarioTest = ScenarioTest::get()
            ->filter('ScenarioExerciseID', $ExerciseID)
            ->filter('RelatedMemberID', $UserID)->first();

        if (isset($ScenarioTest)) {
            $ScenarioTest->answer_given = $data[$field_name];
            $ScenarioTest->write();
        } else {
            $ScenarioObject = ScenarioTest::create();
            $ScenarioObject->answer_given = $data[$field_name];
            $ScenarioObject->ScenarioExerciseID = $ExerciseID;
            $ScenarioObject->RelatedMemberID = $UserID;
            $ScenarioObject->write();
        }
    }
}
