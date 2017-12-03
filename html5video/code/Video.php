<?php

/**
 * Class Video.
 */
class Video extends Page
{
    /**
     * @var array
     */
    private static $db = array(
        'Time' => 'Varchar(100)',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'MP4Video' => 'File',
        'OggVideo' => 'File',
        'WebMVideo' => 'File',
        'Image' => 'Image',
    );

    /**
     * @var string
     */
    private static $singular_name = 'HTML5 Video';

    /**
     * @var string
     */
    private static $plural_name = 'HTML5 Vidoes';

    /**
     * @var string
     */
    private static $description = 'Single Video Detail Page';

    /**
     * Sets the ShowInMenus field to false.
     */
    public function populateDefaults() {
        $this->ShowInMenus = 0;
        parent::populateDefaults();
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Title')->setTitle('Video Title');
        $fields->dataFieldByName('Content')->setTitle('Video Description');

        $fields->insertBefore(
            TextField::create('Time', 'Video Duration')
                ->setDescription('ex. mm:ss'),
            'Content'
        );

        // poster
        $PosterField = UploadField::create('Image', 'Poster Image')
            ->setFolderName('Uploads/Video/Images')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setDescription('Preview image for the video.')
        ;
        $PosterField->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        $PosterField->getValidator()->setAllowedMaxFileSize(VIDEO_IMAGE_FILE_SIZE_LIMIT);

        $fields->insertBefore(
            $PosterField,
            'Content'
        );

        // mp4 upload
        if (class_exists('ChunkedUploadField')) {
            $MP4Field = ChunkedUploadField::create('MP4Video');
        } else {
            $MP4Field = new UploadField('MP4Video');
        }
        $MP4Field
            ->setTitle('MP4 Video')
            ->setFolderName('Uploads/Video/MP4Video')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setDescription('Required. Format compatible with most browsers.')
        ;
        $MP4Field->getValidator()->setAllowedExtensions(array('mp4', 'm4v'));
        $MP4Field->getValidator()->setAllowedMaxFileSize(VIDEO_FILE_SIZE_LIMIT);

        // ogg upload
        if (class_exists('ChunkedUploadField')) {
            $OggField = ChunkedUploadField::create('OggVideo');
        } else {
            $OggField = UploadField::create('OggVideo');
        }
        $OggField
            ->setTitle('Ogg Video')
            ->setFolderName('Uploads/Video/OggVideo')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setDescription('Optional. Format compatible with FireFox.')
        ;
        $OggField->getValidator()->setAllowedExtensions(array('ogv', 'ogg'));
        $OggField->getValidator()->setAllowedMaxFileSize(VIDEO_FILE_SIZE_LIMIT);

        // webm upload
        if (class_exists('ChunkedUploadField')) {
            $WebMField = ChunkedUploadField::create('WebMVideo');
        } else {
            $WebMField = UploadField::create('WebMVideo');
        }
        $WebMField
            ->setTitle('WebM Video')
            ->setFolderName('Uploads/Video/WebMVideo')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setDescription('Optional. Format compatible with Chrome.')
        ;
        $WebMField->getValidator()->setAllowedExtensions(array('webm'));
        $WebMField->getValidator()->setAllowedMaxFileSize(VIDEO_FILE_SIZE_LIMIT);

        $fields->addFieldsToTab('Root.Video', array(
            $MP4Field,
            $WebMField,
            $OggField,
        ));

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * This function allows the validation of record data
     * on Save.
     *
     * @return ValidationResult
     */
    public function getCMSValidator() {
 		return new RequiredFields(array('MP4Video'));
    }

    /**
     * @return DataList|bool
     */
    public function getRelatedVideos()
    {
        if ($this->Parent() && $this->Parent()->ClassName == 'VideoGroup') {
            return $this->Parent()->getVideoList()->exclude('ID', $this->ID);
        }

        return false;
    }
}

class Video_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();

        Requirements::css(VIDEO_DIR . '/thirdparty/video-js/video-js.min.css');
        Requirements::javascript(VIDEO_DIR . '/thirdparty/video-js/video.min.js');
    }
}
