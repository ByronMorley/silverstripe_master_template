<?php

class Page extends SiteTree
{

    public static $allowed_actions = array (
    );

    private static $db = array(
        'Transition_inc'=>'Varchar(100)',
        'Transition_dec'=>'Varchar(100)',
        'Nest'=>'Boolean',
        'Menu'=>'Boolean',
        'Menu_style'=>'Varchar(100)'
    );

    private static $has_one = array(
    );

    private static $has_many = array(

    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        /*********************************
         *          ANIMATION
         ********************************/

        $transitions = array(
            'slide-right' => 'Slide Right',
            'slide-left' => 'Slide Left',
            'fade' => 'Fade',
            'slide-down' => 'Slide Down',
            'slide-up' => 'Slide Up',
            'scale-down' => 'Scale Down',
            'scale-up' => 'Scale Up',
        );
        $fields->addFieldToTab('Root.Animation',
            DropdownField::create(
                'Transition_inc',
                'Transition Increment',
                $transitions
            )
        );
        $fields->addFieldToTab('Root.Animation',
            DropdownField::create(
                'Transition_dec',
                'Transition Decrement',
                $transitions
            )
        );

        $styles = array(
            'light-grey-style' => 'Light grey',
            'medium-grey-style' => 'Medium grey',
            'dark-grey-style' => 'Dark grey',
            'red-style' => 'Red',
        );


        $fields->addFieldToTab('Root.Animation', CheckboxField::create('Nest', 'Nest'));
        $fields->addFieldToTab('Root.Menu', CheckboxField::create( 'Menu', 'Show in menu'));
        $fields->addFieldToTab('Root.Menu', DropdownField::create(
            'Menu_style',
            'Menu style',
            $styles
        ));


        return $fields;
    }

    public function populateDefaults()
    {
        $this->Transition_inc = "silde-left";
        $this->Transition_dec = "slide-right";
        parent::populateDefaults();
    }

}
