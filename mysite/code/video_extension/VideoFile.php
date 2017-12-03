<?php


class VideoFile extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(50)',
        'Content' => 'Varchar(100)',
    );

    private static $has_one = array(
        'PosterImage' => 'Image',
        'MP4Video' => 'File',
        'OggVideo' => 'File',
        'WebMVideo' => 'File'
    );

    private static $summary_fields = array(
        'ID' => 'ID',
        'Title' => 'Title',
        'Content' => 'Description',
    );

    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Title')->setTitle('Video Title');
        $fields->insertBefore(
            TextField::create('Content', 'Video Description'),
            'PosterImage'
        );

        // poster
        $PosterField = UploadField::create('PosterImage', 'Poster Image')
            ->setFolderName('Uploads/Video/Images')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setDescription('Preview image for the video.')
        ;
        $PosterField->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        $PosterField->getValidator()->setAllowedMaxFileSize(VIDEO_IMAGE_FILE_SIZE_LIMIT);


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

        return $fields;
    }

    public function getGridThumbnail() {
        if($this->Photo()->exists()) {
            return $this->Photo()->SetWidth(100);
        }
        return '(no image)';
    }
}