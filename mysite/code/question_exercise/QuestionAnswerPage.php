<?php

class QuestionAnswerPage extends Page
{

    private static $db = array(
        'ExerciseID' => 'Int(5)',
    );


    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $field = DropdownField::create('ExerciseID', 'Exercise', QuestionExercise::get()->filter('ClassName', 'QuestionExercise')->map('ID', 'Title'))
            ->setEmptyString('(Select Question)');
        $fields->addFieldToTab('Root.Config', $field);

        return $fields;
    }

}

class QuestionAnswerPage_Controller extends ContentController
{
    public function index()
    {
        if (Director::is_ajax()) {
            return $this->renderWith("QuestionAnswerPage_ajax");
        } else {
            return $this->render();
        }
    }

    public function exercise_result()
    {
        $questions = Question::get()->filter('QuestionExerciseID', $this->ExerciseID);
        $question_count = $questions->count();
        $correct = 0;

        foreach ($questions as $question) {
            $answer_record = QuestionTest::get()
                ->filter('ExerciseID', $this->ExerciseID)
                ->filter('RelatedMemberID', Member::currentUserID())
                ->filter('QuestionID', $question->ID)->first();

            $correct_answer = $question->correct_answer;
            $answer_given = $answer_record->answer_given;

            if($correct_answer == $answer_given){
                $correct++;
            }
        }

        return "You got " . $correct . " out of " . $question_count . " correct.";


    }

}