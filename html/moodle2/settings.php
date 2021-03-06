<?php
require_once(dirname(__FILE__) . '/local/agora/lib.php');

get_debug();

// Force general preferences. Prevailes over database params.
$CFG->isagora = 1;
//$CFG->iseoi = false;  /* Set in database */
$CFG->isportal = false;
$CFG->center = array_key_exists('clientCode', $school_info) ? $school_info['clientCode'] : $school_info['id_moodle2'];

// The following line calculates correctly the diskPercent (uploading files will be disabled when diskPercent >= 100)
$CFG->diskPercent = array_key_exists('diskPercent_moodle2', $school_info) ? $school_info['diskPercent_moodle2'] : 0;
$CFG->userquota = 0;  // To avoid the private files area

$CFG->legacyfilesinnewcourses=0;
$CFG->updateautocheck = 0;
$CFG->disableupdatenotifications=1;

//Preconfiguration setting
$CFG->alternateloginurl='';
$CFG->mymoodleredirect=0;
$CFG->enablestats=0;
$CFG->themedesignermode=0;
//$CFG->loginhttps=0;  /* Database param, to change if there is some problem */

//Authentication
$CFG->recaptchapublickey='6LcgQgsAAAAAAMZKqiYEDAhniHIY0hXC-MMVM6Rs';
$CFG->recaptchaprivatekey='6LcgQgsAAAAAAMAOLB0yfxPACo0e60sKD5ksV_hP';

//Mail
$CFG->smtpmaxbulk = 20;
//$CFG->noreplyaddress = "noreply@agora.xtec.cat";
$CFG->digestmailtime = 1;
$CFG->mailheader = '[Àgora]';

//Cleanup
$CFG->disablegradehistory = 1;
$CFG->loglifetime = 365;

//Rules
$CFG->forceloginforprofiles = 1;
$CFG->opentogoogle = 0;

//Ajax & Javascript
$CFG->enableajax = 1;
$CFG->disablecourseajax = 0;

//Backups
$CFG->backup_auto_active = 0;

//Session information
$CFG->dbsessions=false;
$CFG->sessiontimeout=3600;
//$CFG->sessioncookie = $CFG->center;

//$CFG->enable_hour_restrictions = 1;   /* Set in database */
// This param (hour_restrictions) can be serialized. This is useful for setting it in database
// Values for days: 0 = sunday, 1 = monday, ..., 6 = saturday
$CFG->hour_restrictions = array(array('start' => '9:00', 'end' => '13:59', 'days' => '1|2|3|4|5'),
                                array('start' => '15:00', 'end' => '16:59', 'days' => '1|2|3|4|5'));

// These variable define DEFAULT block variables for new courses
$CFG->defaultblocks_override = ':calendar_month,participants,activity_modules';

//Mail information
//$CFG->apligestmail = 1;  		/* Set in database */
//$CFG->apligestlog = 0;		/* Set in database */
//$CFG->apligestlogdebug = 0;		/* Set in database */
$CFG->apligestlogpath = $CFG->dataroot.'/repository/files/mailsender.log';
$CFG->apligestenv = $agora['server']['enviroment'];
$CFG->apligestaplic = 'AGORA';

// Only allow some of the languages
$CFG->langlist = 'ca,en,es,fr,de';

// Àtria-marsupial information
//$CFG->center = '08929684';
$CFG->atriaUsername = $agora['atria']['username'];
$CFG->atriaPassword = $agora['atria']['password'];
$CFG->atriaEmpresa = $CFG->atriaUsername;
$CFG->atriaEvaType = $agora['atria']['evatype'];

///////////////////////////
////dades preproduccio
//$CFG->atriaWSUrl = 'http://212.92.50.138/_layouts/Renacimiento/WebServices/WS_IdentEVA.wsdl';
//$CFG->atriaWSUrlPublisher = 'http://212.92.50.138/_layouts/Renacimiento/WebServices/WS_PublisherData.wsdl';
//$CFG->atriaFormUrl = 'http://212.92.50.138/_layouts/Renacimiento/LoginPageExt.aspx';

/////////////////////////
//dades produccio
$CFG->atriaWSUrl = 'https://www.atria.cat/_layouts/Renacimiento/WebServices/WS_IdentEVA.wsdl';
$CFG->atriaWSUrlPublisher = 'https://www.atria.cat/_layouts/Renacimiento/WebServices/WS_PublisherData.wsdl';
$CFG->atriaFormUrl = 'https://www.atria.cat/_layouts/Renacimiento/LoginPageExt.aspx';

//$CFG->atriaWSUrl = 'http://www.atria.cat/_layouts/Renacimiento/WebServices/WS_IdentEVA.wsdl';
//$CFG->atriaWSUrlPublisher = 'http://www.atria.cat/_layouts/Renacimiento/WebServices/WS_PublisherDatax.wsdl';
//$CFG->atriaFormUrl = 'http://www.atria.cat/_layouts/Renacimiento/LoginPageExt.aspx';

$CFG->noreplyaddress = 'noreply@agora.xtec.cat';

if (isset($agora['server']['enviroment'])){
    $CFG->eoicampus_wsdl_path = INSTALL_BASE. 'html/moodle2/mod/eoicampus/action/wsdl/EOICampusWS_generat-ESB-'.$agora['server']['enviroment'].'.wsdl';
}

// Path of the cacheconfig.php file, to have only one MUC file for Àgora (instead of having one for each site in moodledata/usuX/muc/config.php).
// This folder has to exists and to be writable
$CFG->altcacheconfigpath = $agora['server']['root'].'html/moodle2/local/agora/muc/';

$CFG->timezone = 99; // Changed by default to Server's local time
$CFG->cronremotepassword = '';  // changed to avoid schools change it
$CFG->cronclionly = 0; // changed to avoid schools change it


//Here is where the cronlogs will be stored
//$CFG->savecronlog = 1;  // This parámeter is saved on database to save cronlogs
if(isset($agora['moodle']['username']) && !empty($agora['moodle']['username'])){
	$CFG->usu1repofiles  = INSTALL_BASE . $agora['moodle2']['datadir'] . $agora['moodle']['username'] . '1/repository/files';
}
