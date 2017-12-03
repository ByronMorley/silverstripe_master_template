<?php

class SectionVideoBlock extends Section
{
	private static $db = array();

	private static $has_one = array(
		'VideoFile' => 'VideoFile'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab("Root.Main", DropdownField::create(
			'VideoFileID',
			'Add Video File',
			VideoFile::get()->map('ID', 'Title'))
			->setEmptyString('(Select Video)')
		);
		return $fields;
	}
}