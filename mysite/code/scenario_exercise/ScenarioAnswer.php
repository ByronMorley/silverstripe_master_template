<?php

class ScenarioAnswer extends Page
{

    private static $db = array(
        'ExerciseID' => 'Int(5)',
    );

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $field = DropdownField::create('ExerciseID', 'Exercise', ScenarioExercise::get()->filter('ClassName', 'ScenarioExercise')->map('ID', 'Title'))
            ->setEmptyString('(Select Exercise)');
        $fields->addFieldToTab('Root.Config', $field);

        return $fields;
    }
}

class ScenarioAnswer_Controller extends ContentController
{

    public function index()
    {
        if (Director::is_ajax()) {
            return $this->renderWith("ScenarioAnswerPage_ajax");
        } else {
            return $this->render();
        }
    }

    public function exercise_result()
    {
        SS_Log::log("correct answer " . $this->ExerciseID, SS_Log::WARN);

        $ScenarioExercise = ScenarioExercise::get()->filter('ID', $this->ExerciseID)->first();
        $correct_answer = $ScenarioExercise->correct_answer;

        SS_Log::log("correct answer " . $correct_answer, SS_Log::WARN);

        $answer = ScenarioTest::get()
            ->filter('ScenarioExerciseID', $this->ExerciseID)
            ->filter('RelatedMemberID', Member::currentUserID());

        $answer_given = ($answer->exists()) ? $answer->first()->answer_given : "Error";


        $result = ($correct_answer == $answer_given) ? "Correct" : "Incorrect";

        return "<h2>" . $result . " : It is a " . $correct_answer . "</h2>";
    }

}
