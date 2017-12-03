<?php


class ResourceList extends Page
{

    private static $has_many = array(
        'ResourceItems' => 'ResourceItem',
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $GridFields = GridField::create('ResourceItems', 'ResourceItem', $this->ResourceItems(), GridFieldConfig_RecordEditor::create());
        $fields->addFieldToTab('Root.Resources', $GridFields );

        return $fields;
    }

}

class ResourceList_Controller extends ContentController
{


}