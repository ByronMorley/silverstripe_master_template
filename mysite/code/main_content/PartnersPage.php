<?php

class PartnersPage extends Page
{

    private static $has_many = array(
        'Partners' => 'Partner'
    );

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $config = GridFieldConfig_RelationEditor::create();
        $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
            'Title' => 'Title',
            'Content.Title' => 'Content' // Retrieve from a has-one relationship
        ));
        // Create a gridfield to hold the student relationship
        $customField = new GridField(
            'Contents', // Field name
            'Content', // Field title
            $this->Partners(), // List of all related students
            $config
        );
        // Create a tab named "Students" and add our field to it
        $fields->addFieldToTab('Root.Partners', $customField);

        return $fields;
    }
}

class PartnersPage_Controller extends ContentController
{


}
