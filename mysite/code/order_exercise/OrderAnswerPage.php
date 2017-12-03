<?php

class OrderAnswerPage extends Page
{

    private static $db = array(
        'ExerciseID' => 'Int(5)',
    );


    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $field = DropdownField::create('ExerciseID', 'Exercise', OrderExercise::get()->filter('ClassName', 'OrderExercise')->map('ID', 'Title'))
            ->setEmptyString('(Select Exercise)');
        $fields->addFieldToTab('Root.Config', $field);

        return $fields;
    }

}

class OrderAnswerPage_Controller extends ContentController
{
    public function index()
    {
        if (Director::is_ajax()) {
            return $this->renderWith("OrderAnswerPage_ajax");
        } else {
            return $this->render();
        }
    }

    public function exercise_result()
    {
        $orderSelections = OrderSelection::get()->filter('OrderExerciseID', $this->ExerciseID);
        $orderSelections_count = $orderSelections->count();
        $correct = 0;

        foreach ($orderSelections as $orderSelection) {

            $answer_record = OrderTest::get()
                ->filter('OrderExerciseID', $this->ExerciseID)
                ->filter('RelatedMemberID', Member::currentUserID())
                ->filter('OrderSelectionID', $orderSelection->ID)->first();

            $correct_answer = $orderSelection->correct_order;
            $answer_given = $answer_record->order;

            if($correct_answer == $answer_given){
                $correct++;
            }
        }

        return "You got " . $correct . " out of " . $orderSelections_count . " correct.";
    }
}