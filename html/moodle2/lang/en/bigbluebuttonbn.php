<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'bigbluebuttonbn', language 'en', branch 'MOODLE_24_STABLE'
 *
 * @package   bigbluebuttonbn
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['bbbduetimeoverstartingtime'] = 'The due time for this activity must be greater than the starting time';
$string['bbbdurationwarning'] = 'The maximum duration for this session is %duration% minutes.';
$string['bbbfinished'] = 'This activity is over.';
$string['bbbinprocess'] = 'This activity is in process.';
$string['bbbnorecordings'] = 'There is no recording yet, please come back later.';
$string['bbbnotavailableyet'] = 'Sorry, this session is not yet available.';
$string['bbbrecordwarning'] = 'This session is being recorded.';
$string['bbburl'] = 'The URL of your BigBlueButton server must end with /bigbluebutton/. (This default URL is for a BigBlueButton server provided by Blindside Networks that you can use for testing.)';
$string['bigbluebuttonbn'] = 'BigBlueButton';
$string['bigbluebuttonbn:addinstance'] = 'Add a new meeting';
$string['bigbluebuttonbnfieldset'] = 'Custom example field set';
$string['bigbluebuttonbnintro'] = 'BigBlueButton Intro';
$string['bigbluebuttonbn:join'] = 'Join a meeting';
$string['bigbluebuttonbn:moderate'] = 'Moderate a meeting';
$string['bigbluebuttonbnSalt'] = 'BigBlueButton Shared Secret';
$string['bigbluebuttonbnUrl'] = 'BigBlueButton Server URL';
$string['bigbluebuttonbnWait'] = 'User has to wait';
$string['configsecuritysalt'] = 'The security salt of your BigBlueButton server.  (This default salt is for a BigBlueButton server provided by Blindside Networks that you can use for testing.)';
$string['general_error_unable_connect'] = 'Unable to connect. Please check the url of the BigBlueButton server AND check to see if the BigBlueButton server is running.';
$string['index_confirm_end'] = 'Do you wish to end the virtual class?';
$string['index_disabled'] = 'disabled';
$string['index_enabled'] = 'enabled';
$string['index_ending'] = 'Ending the virtual classroom ... please wait';
$string['index_error_checksum'] = 'A checksum error occurred. Make sure you entered the correct salt.';
$string['index_error_forciblyended'] = 'Unable to join this meeting because it has been manually ended.';
$string['index_error_unable_display'] = 'Unable to display the meetings. Please check the url of the BigBlueButton server AND check to see if the BigBlueButton server is running.';
$string['index_heading'] = 'BigBlueButton Rooms';
$string['index_heading_actions'] = 'Actions';
$string['index_heading_group'] = 'Group';
$string['index_heading_moderator'] = 'Moderators';
$string['index_heading_name'] = 'Room';
$string['index_heading_recording'] = 'Recording';
$string['index_heading_users'] = 'Users';
$string['index_heading_viewer'] = 'Viewers';
$string['index_running'] = 'running';
$string['index_warning_adding_meeting'] = 'Unable to assign a new meeting ID.';
$string['mod_form_block_general'] = 'General settings';
$string['mod_form_block_record'] = 'Record settings';
$string['mod_form_block_schedule'] = 'Schedule for sessions';
$string['mod_form_field_availabledate'] = 'Join open';
$string['mod_form_field_description'] = 'Description of recorded session';
$string['mod_form_field_duedate'] = 'Join closed';
$string['mod_form_field_duration'] = 'Duration';
$string['mod_form_field_duration_help'] = 'Setting the duration for a meeting will establish the maximum time for a meeting to keep alive before the recording finish';
$string['mod_form_field_limitusers'] = 'Limit users';
$string['mod_form_field_limitusers_help'] = 'Maximum limit of users allowed in a meeting';
$string['mod_form_field_name'] = 'Virtual classroom name';
$string['mod_form_field_newwindow'] = 'Open BigBlueButton in a new window';
$string['mod_form_field_record'] = 'Record';
$string['mod_form_field_voicebridge'] = 'Voice bridge';
$string['mod_form_field_voicebridge_help'] = 'Voice conference number that participants enter to join the voice conference.';
$string['mod_form_field_wait'] = 'Students must wait until a moderator joins';
$string['mod_form_field_welcome'] = 'Welcome message';
$string['mod_form_field_welcome_default'] = '<br>Welcome to <b>%%CONFNAME%%</b>!<br><br>To understand how BigBlueButton works see our <a href="event:http://www.bigbluebutton.org/content/videos"><u>tutorial videos</u></a>.<br><br>To join the audio bridge click the headset icon (upper-left hand corner). <b>Please use a headset to avoid causing noise for others.</b>';
$string['mod_form_field_welcome_help'] = 'Replaces the default message setted up for the BigBlueButton server. The message can includes keywords  (%%CONFNAME%%, %%DIALNUM%%, %%CONFNUM%%) which will be substituted automatically, and also html tags like <b>...</b> or <i></i>';
$string['modulename'] = 'BigBlueButtonBN';
$string['modulename_help'] = 'BigBlueButtonBN lets you create from within Moodle links to real-time on-line classrooms using BigBlueButton, an open source web conferencing system for distance education.

Using BigBlueButtonBN you can specify for the title, description, calendar entry (which gives a date range for joining the session), groups, and details about the recording of the on-line session.

To view later recordings, add a RecordingsBN resource to this course.';
$string['modulename_link'] = 'BigBlueButtonBN/view';
$string['modulenameplural'] = 'BigBlueButtonBN';
$string['pluginadministration'] = 'BigBlueButton administration';
$string['pluginname'] = 'BigBlueButtonBN';
$string['serverhost'] = 'Server Name';
$string['view_error_no_group'] = 'There are no groups configured yet. Please set up groups before trying to join the meeting.';
$string['view_error_no_group_student'] = 'You have not been enrolled in a group. Please contact your Teacher or the Administrator.';
$string['view_error_no_group_teacher'] = 'There are no groups configured yet. Please set up groups or contact the Administrator.';
$string['view_error_unable_join'] = 'Unable to join the meeting. Please check the url of the BigBlueButton server AND check to see if the BigBlueButton server is running.';
$string['view_error_unable_join_student'] = 'Unable to connect to the BigBlueButton server. Please contact your Teacher or the Administrator.';
$string['view_error_unable_join_teacher'] = 'Unable to connect to the BigBlueButton server. Please contact the Administrator.';
$string['view_groups_selection'] = 'Select the group you want to join and confirm the action';
$string['view_groups_selection_join'] = 'Join';
$string['view_login_moderator'] = 'Logging in as moderator ...';
$string['view_login_viewer'] = 'Logging in as viewer ...';
$string['view_noguests'] = 'The BigBlueButtonBN is not open to guests';
$string['view_nojoin'] = 'You are not in a role allowed to join this session.';
$string['view_recording_list_actionbar'] = 'Toolbar';
$string['view_recording_list_actionbar_delete'] = 'Delete';
$string['view_recording_list_actionbar_hide'] = 'Hide';
$string['view_recording_list_actionbar_show'] = 'Show';
$string['view_recording_list_activity'] = 'Activity';
$string['view_recording_list_course'] = 'Course';
$string['view_recording_list_date'] = 'Date';
$string['view_recording_list_description'] = 'Description';
$string['view_recording_list_duration'] = 'Duration';
$string['view_recording_list_recording'] = 'Recording';
$string['view_wait'] = 'The virtual class has not yet started.  Waiting until a moderator joins ...';
