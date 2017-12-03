<?php

class Content extends DataObject {

    private static $db = array(
        'Title' => 'Varchar',
        'Content' => 'HTMLText',
    );

    private static $has_one = array(
        'Photo' => 'Image',
        'ModulePage' => 'ModulePage',
        'VideoFile'=> 'VideoFile'
    );

    private static $summary_fields = array(
        'ID' => 'ID',
        'Title' => 'Title',
        'Content' => 'Content',
    );

    public function getCMSFields() {

        $fields = FieldList::create(
            TextField::create('Title'),
            HtmlEditorField::create('Content'),
            $uploader = UploadField::create('Photo')
        );

        $fields->insertBefore(DropdownField::create(
            'VideoFileID',
            'Add Video File',
            VideoFile::get()->map('ID', 'Title'))
            ->setEmptyString('(Select Video)'),
            'Content'
        );

        $uploader->setFolderName('project-images');
        $uploader->getValidator()->setAllowedExtensions(array(
            'png','gif','jpeg','jpg'
        ));

        return $fields;
    }

    public function getGridThumbnail() {
        if($this->Photo()->exists()) {
            return $this->Photo()->SetWidth(100);
        }
        return '(no image)';
    }
}
