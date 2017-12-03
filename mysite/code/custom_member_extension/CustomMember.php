<?php

class CustomMember extends DataExtension
{

    private static $db = array(
        'Title' => 'Varchar',
        'Organisation' => 'Varchar',
        'Occupation' => 'Varchar',
        'Reason' => 'Varchar',
    );

    private static $has_one = array(
        'RelatedMember' => 'Member',
    );

    /*static $has_many = array(
        'Exercises' => 'Exercise',
    );*/

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $this->extend('updateCMSFields', $fields);
        return $fields;
    }


    public function get_correct_answer($Question, $ans)
    {

        $answer = "answer_" . $ans;
        $answer_given = Question::get()->filter('ID', $Question->ID)->first()->$answer;

        return isset($answer_given) ? $answer_given : "none";
    }

    public function get_order_stats($name, $ExerciseID)
    {

        $Selections = OrderSelection::get()
            ->filter('OrderExerciseID', $ExerciseID)
            ->sort('correct_order', 'ASC');
        $Tab = Tab::create($name);
        $Tab->push(HeaderField::create("Correct Order")->addExtraClass('col-xs-6'));
        $Tab->push(HeaderField::create("Arranged Order")->addExtraClass('col-xs-6'));

        foreach ($Selections as $index => $Selection) {

            $num = $index + 1;
            $user_selection = OrderTest::get()
                ->filter('OrderExerciseID', $ExerciseID)
                ->filter('RelatedMemberID', $this->owner->ID)
                ->filter('order', $num)
                ->first();

            $statement = OrderSelection::get()->filter('ID', $user_selection->OrderSelectionID)->first()->statement;

            $Tab->push(LabelField::create($num)->addExtraClass('col-xs-1 next-line'));
            $Tab->push(LabelField::create($Selection->statement)->addExtraClass('col-xs-5'));
            $Tab->push(LabelField::create($num)->addExtraClass('col-xs-1'));
            $Tab->push(LabelField::create($statement)->addExtraClass('col-xs-5'));

        }

        $Tab->push(HeaderField::create("Score")->addExtraClass('center-align score next-line'));
        $Tab->push(HeaderField::create($this->get_order_score($ExerciseID))->addExtraClass('center-align next-line'));

        return $Tab;
    }

    public function get_order_score($ExerciseID)
    {

        $Selections = OrderSelection::get()->filter('OrderExerciseID', $ExerciseID)->sort('correct_order', 'ASC');
        $count = 0;

        foreach ($Selections as $index => $Selection) {

            $correct_order = $Selection->correct_order;
            $answer = OrderTest::get()
                ->filter('OrderExerciseID', $ExerciseID)
                ->filter('OrderSelectionID', $Selection->ID)
                ->filter('RelatedMemberID', $this->owner->ID)
                ->first()
                ->order;

            if ($answer == $correct_order) {
                $count++;
            }
        }

        return $count . " out of " . $Selections->count();
    }

    public function get_question_stats($name, $ExerciseID)
    {

        $Questions = Question::get()->filter('QuestionExerciseID', $ExerciseID);
        $Tab = Tab::create($name);

        //Setup Heading

        $Tab->push(HeaderField::create("No.")->addExtraClass('col-xs-1'));
        $Tab->push(HeaderField::create("Question")->addExtraClass('col-xs-7'));
        $Tab->push(HeaderField::create("Answer")->addExtraClass('col-xs-2'));
        $Tab->push(HeaderField::create("Answer given")->addExtraClass('col-xs-2'));


        SS_Log::log("ID " . $this->owner->ID, SS_Log::WARN);

        foreach ($Questions as $index => $Question) {
            $answer = QuestionTest::get()
                ->filter('ExerciseID', $ExerciseID)
                ->filter('QuestionID', $Question->ID)
                ->filter('RelatedMemberID', $this->owner->ID)
                ->first()
                ->answer_given;

            $Tab->push(LabelField::create($index + 1)->addExtraClass('col-xs-1 next-line'));
            $Tab->push(LabelField::create($Question->Question)->addExtraClass('col-xs-7'));
            $Tab->push(LabelField::create($this->get_correct_answer($Question, $Question->correct_answer))->addExtraClass('col-xs-2'));
            $Tab->push(LabelField::create($this->get_correct_answer($Question, $answer))->addExtraClass('col-xs-2'));
        }

        $Tab->push(HeaderField::create("Score")->addExtraClass('center-align score next-line'));
        $Tab->push(HeaderField::create($this->get_question_score($ExerciseID))->addExtraClass('center-align next-line'));

        return $Tab;
    }

    public function get_question_score($ExerciseID)
    {

        $Questions = Question::get()->filter('QuestionExerciseID', $ExerciseID);
        $count = 0;
        foreach ($Questions as $index => $Question) {

            $correct_answer = $Question->correct_answer;
            $answer = QuestionTest::get()
                ->filter('ExerciseID', $ExerciseID)
                ->filter('QuestionID', $Question->ID)
                ->filter('RelatedMemberID', $this->owner->ID)
                ->first()
                ->answer_given;

            if ($answer == $correct_answer) {
                $count++;
            }
        }

        return $count . " out of " . $Questions->count();
    }

    public function get_scenario_stats($name, $locale)
    {

        $SiteTree = SiteTree::get()->filter('ClassName', "ScenarioExercise")->filter('Locale', $locale);
        $Tab = Tab::create($name);

        $Tab->push(HeaderField::create("No.")->addExtraClass('col-xs-1'));
        $Tab->push(HeaderField::create("Question")->addExtraClass('col-xs-7'));
        $Tab->push(HeaderField::create("Answer")->addExtraClass('col-xs-2'));
        $Tab->push(HeaderField::create("Answer given")->addExtraClass('col-xs-2'));

        $count = 0;

        foreach ($SiteTree as $index => $Page) {

            $correct = ScenarioExercise::get()->filter('ID', $Page->ID);

            $correct_answer = ($correct->exists()) ? $correct->first()->correct_answer : "Error";

            $answer = ScenarioTest::get()
                ->filter('RelatedMemberID', $this->owner->ID)
                ->filter('ScenarioExerciseID', $Page->ID);

            $answer_given = ($answer->exists()) ? $answer->first()->answer_given : "none";

            $Tab->push(LabelField::create($index + 1)->addExtraClass('col-xs-1 next-line'));
            $Tab->push(LabelField::create($Page->Content)->addExtraClass('col-xs-7'));
            $Tab->push(LabelField::create($correct_answer)->addExtraClass('col-xs-2'));
            $Tab->push(LabelField::create($answer_given)->addExtraClass('col-xs-2'));

            if ($answer_given == $correct_answer) {
                $count++;
            }

        }
        $Tab->push(HeaderField::create("Score")->addExtraClass('center-align score next-line'));
        $Tab->push(HeaderField::create($count . " out of " . $SiteTree->count())->addExtraClass('center-align next-line'));

        return $Tab;

    }

    public function updateCMSFields(FieldList $fields)
    {

        $TabSetEng = Tabset::create("Exercises");
        $TabSetEng->push($this->get_question_stats("Exercise 1", 33));
        $TabSetEng->push($this->get_question_stats("Exercise 2", 38));
        $TabSetEng->push($this->get_question_stats("Exercise 3", 43));
        $TabSetEng->push($this->get_order_stats("Exercise 4", 48));
        $TabSetEng->push($this->get_order_stats("Exercise 5", 52));
        $TabSetEng->push($this->get_order_stats("Exercise 6", 55));
        $TabSetEng->push($this->get_scenario_stats("Exercise 7", "en_GB"));

        $fields->findOrMakeTab('Root.English Statistics', $TabSetEng);

        $TabSetCym = Tabset::create("Exercises");
        $TabSetCym->push($this->get_question_stats("Exercise 1", 97));
        $TabSetCym->push($this->get_question_stats("Exercise 2", 102));
        $TabSetCym->push($this->get_question_stats("Exercise 3", 107));
        $TabSetCym->push($this->get_order_stats("Exercise 4", 111));
        $TabSetCym->push($this->get_order_stats("Exercise 5", 115));
        $TabSetCym->push($this->get_order_stats("Exercise 6", 118));
        $TabSetCym->push($this->get_scenario_stats("Exercise 7", "cy_GB"));

        $fields->findOrMakeTab('Root.Welsh Statistics', $TabSetCym);
        $fields->removeByName('DateFormat');
        $fields->removeByName('TimeFormat');

    }

}




