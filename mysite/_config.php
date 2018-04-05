<?php

global $project;
$project = 'mysite';


/**************************
 *       DATABASE
 *************************/

global $database;
$database = 'ss_swat';
require_once("conf/ConfigureFromEnv.php");


/**************************
 *       LOCALE
 *************************/

i18n::set_locale('en_GB');
Translatable::set_default_locale('en_GB');
Translatable::set_allowed_locales(array(
		'cy_GB',  //Welsh
		'en_GB',
	)
);

/**************************
 *     ERROR HANDLING
 *************************/

FulltextSearchable::enable(array('SiteTree'));

if (Director::isDev()) {
	// Turn on all errors
	ini_set('display_errors', 1);
	ini_set("log_errors", 1);
	error_reporting(E_ALL | E_STRICT);
	Config::inst()->update('Email', 'send_all_emails_to', "byron@rgbsoftware.co.uk");
	SS_Log::add_writer(new SS_LogFileWriter(dirname(__FILE__).'/errors.log'),SS_Log::ERR);
	SS_Log::add_writer(new SS_LogFileWriter(dirname(__FILE__).'/notice.log'),SS_Log::NOTICE);
	//Email::set_mailer(new Kinglozzer\SilverStripeMailgunner\Mailer);

}

if (Director::isTest()) {

	ini_set('display_errors', 1);
	ini_set("log_errors", 1);
	error_reporting(E_ALL | E_STRICT);
	SS_Log::add_writer(new SS_LogFileWriter(dirname(__FILE__).'/errors.log'),SS_Log::ERR);
	SS_Log::add_writer(new SS_LogFileWriter(dirname(__FILE__).'/notice.log'),SS_Log::NOTICE);
}

/**************************
 *      EXTENSIONS
 *************************/

Object::add_extension('SiteTree', 'Translatable');
Object::add_extension('SiteConfig', 'Translatable'); // 2.4 or newer only
Object::useCustomClass('MemberLoginForm', 'CustomMemberLoginForm');
Object::add_extension('Member', 'CustomMember');