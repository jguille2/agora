<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/course/lib.php');

//header ("Content-Type: application/msexcel");
header('Content-type: text/csv');
header ('Content-Disposition: attachment; filename="credencials_marsupial.csv"');

$records = $DB->get_records('rcommon_user_credentials');
echo 'isbn;credential;userid'."\n";
foreach($records as $record) {
        echo $record->isbn.';'.$record->credentials.';'.$record->euserid."\n";
}
