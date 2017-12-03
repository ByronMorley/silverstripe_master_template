<?php

class Partner extends DataObject
{

    private static $db = array(
        'Title' => 'Varchar',
        'Content' => 'HTMLText',
    );

    private static $has_one = array(
        'Logo' => 'Image',
        'PartnersPage' => 'PartnersPage'
    );

    public function getCMSFields()
    {

        $fields = FieldList::create(
            TextField::create('Title'),
            HtmlEditorField::create('Content'),
            $uploader = UploadField::create('Logo')
        );

        $uploader->setFolderName('project-images');
        $uploader->getValidator()->setAllowedExtensions(array(
            'png','gif','jpeg','jpg'
        ));

        return $fields;
    }


}