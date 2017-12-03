<?php
class Article extends Page {

    private static $has_one = array (
        'Presentation' => 'File'
    );


    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Attachments', $uploadFile = UploadField::create(
            'Presentation',
            'Upload File'
        ));

        $uploadFile->getValidator()->setAllowedExtensions(array('pptx'));

        return $fields;
    }

}
class Article_Controller extends ContentController {



}
