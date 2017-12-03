<?php

class ResourceItem extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(100)'
    );


    private static $has_one = array(
        'Photo' => 'Image',
        'ResourceList' => 'ResourceList',
    );
    public function getCMSFields()
    {

        $fields = FieldList::create(
            TextField::create('Title'),
            $uploader = UploadField::create('Photo'));

        $uploader->setFolderName('project-images');
        $uploader->getValidator()->setAllowedExtensions(array(
            'png','gif','jpeg','jpg'
        ));

        return $fields;
    }
}