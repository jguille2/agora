<?php

/**
 * This function is called internally by the core whenever the module is
 * loaded.  It adds in the information
 */
function AdminMessages_tables() {
    // Initialise table array
    $tables = array();

    // Get the name for the table.
    $message = DBUtil::getLimitedTablename('message');
    $tables['message'] = $message;
    $tables['message_column'] = array('mid' => 'pn_mid',
        'title' => 'pn_title',
        'content' => 'pn_content',
        'date' => 'pn_date',
        'expire' => 'pn_expire',
        'active' => 'pn_active',
        'view' => 'pn_view',
        'language' => 'pn_language');

    $tables['message_column_def'] = array('mid' => 'I PRIMARY AUTO',
        'title' => "C(100) NOTNULL DEFAULT ''",
        'content' => "XL NOTNULL",
        'date' => "I NOTNULL DEFAULT 0",
        'expire' => "I NOTNULL DEFAULT 0",
        'active' => "I NOTNULL DEFAULT 1",
        'view' => "I NOTNULL DEFAULT 1",
        'language' => "C(30) NOTNULL DEFAULT ''");


    // Return the table information
    return $tables;
}