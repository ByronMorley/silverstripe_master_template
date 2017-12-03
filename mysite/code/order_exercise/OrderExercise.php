<?php

class OrderExercise extends Page
{

    private static $has_many = array(
        'OrderSelections' => 'OrderSelection',
    );

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Selections', GridField::create(
            'OrderSelection',
            'OrderSelections',
            $this->OrderSelections(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }

}

class OrderExercise_Controller extends ContentController
{

    private static $allowed_actions = array(
        'orderForm'
    );

    public function index()
    {
        if (Director::is_ajax()) {
            return $this->renderWith("OrderExercise_ajax");
        } else {
            return $this->render();
        }
    }

    public function get_order_test_data()
    {
        return OrderTest::get()
            ->filter('OrderExerciseID', $this->ID)
            ->filter('RelatedMemberID', Member::currentUserID());
    }

    public function saved_selection_data()
    {

        $ExerciseID = $this->ID;
        $orderSelections = OrderSelection::get()->filter('OrderExerciseID', $ExerciseID);

        $saved_order = new ArrayList;

        $OrderTests = OrderTest::get()
            ->filter('OrderExerciseID', $this->ID)
            ->filter('RelatedMemberID', Member::currentUserID())
            ->sort('order', 'ASC');

        $index = 0;

        while ($orderSelections->count() > ($saved_order->count())) {
            foreach ($orderSelections as $orderSelection) {
                if ($orderSelection->ID == $OrderTests[$index]->OrderSelectionID) {
                    $saved_order->push($orderSelection);
                    $index++;
                    break;
                }
            }
        };

        return $saved_order;
    }

    public function check_for_save_data()
    {

        $save_count = OrderTest::get()
            ->filter('OrderExerciseID', $this->ID)
            ->filter('RelatedMemberID', Member::currentUserID())->count();

        $selection_count = OrderSelection::get()
            ->filter('OrderExerciseID', $this->ID)->count();

        if ($selection_count == $save_count) {
            return true;
        }

        return false;
    }

    function orderForm()
    {
        $fields = FieldList::create();

        $ExerciseID = $this->ID;
        $fields->push(HiddenField::create('exercise-id', '', $ExerciseID));
        $orderSelections = OrderSelection::get()->filter('OrderExerciseID', $ExerciseID);

        $UserID = Member::currentUserID();
        $fields->push(HiddenField::create('user-id', '', $UserID));

        foreach ($orderSelections as $key => $orderSelection) {

            $QuestionID = $orderSelection->ID;
            $fields->push(
                HiddenField::create('selection-' . $QuestionID)
                    ->setAttribute('id', 'form-selection-' . $QuestionID)
            );
        }

        $actions = new FieldList(
            FormAction::create('submitTest', 'submit')->addExtraClass('no-display')
        );

        return new Form($this, 'orderForm', $fields, $actions);
    }

    public function submitTest($data, $form)
    {
        SS_Log::log("Submit Order form", SS_Log::WARN);
        $UserID = Member::currentUserID();
        $ExerciseID = $data['exercise-id'];
        $orderSelections = OrderSelection::get()->filter('OrderExerciseID', $ExerciseID);

        foreach ($orderSelections as $key => $orderSelection) {

            $field_name = 'selection-' . $orderSelection->ID;

            $questionTestObject = OrderTest::get()
                ->filter('OrderExerciseID', $ExerciseID)
                ->filter('RelatedMemberID', $UserID)
                ->filter('OrderSelectionID', $orderSelection->ID)->first();

            if (isset($questionTestObject)) {

                $questionTestObject->order = $data[$field_name];
                $questionTestObject->write();

            } else {
                $questionObject = OrderTest::create();
                $questionObject->order = $data[$field_name];
                $questionObject->OrderSelectionID = $orderSelection->ID;
                $questionObject->OrderExerciseID = $ExerciseID;
                $questionObject->RelatedMemberID = $UserID;
                $questionObject->write();
            }
        }
    }
}
