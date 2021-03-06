<?php

class IWmoodle_Api_User extends Zikula_AbstractApi {

    public function connectExtDB($args) {
        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)
            && !SecurityUtil::checkPermission('IWmoodle::', "::", ACCESS_READ)) {
            return false;
        }

        global $ZConfig;
        $user = $ZConfig['DBInfo']['databases']['moodle2']['user'];
        $databaseName = $ZConfig['DBInfo']['databases']['moodle2']['dbname'];
        $userpwd = $ZConfig['DBInfo']['databases']['moodle2']['password'];

        $connect = oci_pconnect($user, $userpwd, $databaseName);

        if (!$connect) {
            return LogUtil::registerError($this->__f('connectExtDB: No s\'ha pogut connectar al servei <strong>%s</strong>. Paràmetres de depuració: host: %s, dbname: %s, user: %s', array($serviceName, $host, $databaseName, $user)));
        }

        return $connect;
    }

    /**
     * Get the courses where a user is pre-enroled
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	id of the user
     * @return:	An array with the courses where the user is pre-enroled
     */
    public function getallpre_ins($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $pntable = DBUtil::getTables();
        $c = $pntable['IWmoodle_column'];
        $where = "$c[uid] = $user";
        // get the objects from the db
        $items = DBUtil::selectObjectArray('IWmoodle', $where);
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError($this->__('Error! Could not load items.'));
        }
        // Return the items
        return $items;
    }

    /**
     * Delete the pre-inscription of an user
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	args   Array with the id of the course, the role and the id of the user
     * @return:	True if successfull or false in other cases
     */
    public function delete_pre($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        // Argument check 
        if (!isset($args['mid']) || !is_numeric($args['mid'])) {
            return LogUtil::registerError($this->__('Error! Could not do what you wanted. Please check your input.'));
        }
        // Delete item
        if (!DBUtil::deleteObjectByID('IWmoodle', $args['mid'], 'mid')) {
            return LogUtil::registerError($this->__('Error! Sorry! Deletion attempt failed.'));
        }
        // Success
        return true;
    }

    /**
     * Check if a user is enroled in a Moodle course with the same role
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	args   Array with the id of the course
     * @return:	Returns true if the user is enroled into the course with the same role or false in other cases
     */
    public function is_enroled($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $prefix = ModUtil::getVar('IWmoodle', 'dbprefix');
        $connect = ModUtil::apiFunc('IWmoodle', 'user', 'connectExtDB');
        if (!$connect) {
            return LogUtil::registerError($this->__('The connection to Moodle database has failed.'));
        }
        $sql = "SELECT count(*) 
			FROM $prefix" . "role_assignments,$prefix" . "context 
			WHERE $prefix" . "role_assignments.userid=$user
			AND $prefix" . "role_assignments.roleid=$role
			AND $prefix" . "role_assignments.contextid=$prefix" . "context.id
			AND $prefix" . "context.instanceid=$course";
        $results = oci_parse($connect, $sql);
        $r = oci_execute($results);
        if (!$r) {
            oci_close($connect);
            return LogUtil::registerError($this->__('Error! Could not load items.'));
        }
        $array = oci_fetch_row($results);
        $num = $array[0];
        oci_close($connect);
        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if a user is a Moodle user
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	args   Array with the id of the course, the role and the id of the user
     * @return:	True if is a Moodle user or false in other cases
     */
    public function is_user($args) {
        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $prefix = ModUtil::getVar('IWmoodle', 'dbprefix');
        $connect = ModUtil::apiFunc('IWmoodle', 'user', 'connectExtDB');
        if (!$connect) {
            return LogUtil::registerError($this->__('The connection to Moodle database has failed.'));
        }
        $sql = "SELECT COUNT(*)
			FROM $prefix" . "user
			WHERE username='$user'";

        $results = oci_parse($connect, $sql);
        $r = oci_execute($results);
        if (!$results) {
            return false;
        }
        $array = oci_fetch_row($results);
        $num = $array[0];
        oci_close($connect);
        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the information of a course
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	id of the course and role informations of the course
     * @return:	An array with the information of the course and the role
     */
    public function getcourse($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $connect = ModUtil::apiFunc('IWmoodle', 'user', 'connectExtDB');
        if (!$connect) {
            return LogUtil::registerError($this->__('The connection to Moodle database has failed.'));
        }
        $prefix = ModUtil::getVar('IWmoodle', 'dbprefix');
        if (!isset($role)) {
            $sql = "SELECT fullname, visible, to_char(summary) as summary
				FROM $prefix" . "course
				WHERE $prefix" . "course.id = $args[courseid]";
        } else {
            $sql = "SELECT fullname, visible, to_char(summary) as summary, name, $prefix" . "course.id
				FROM $prefix" . "course, $prefix" . "role
				WHERE $prefix" . "course.id = $courseid
				AND $prefix" . "role.id = $role";
        }
        $results = oci_parse($connect, $sql);
        $r = oci_execute($results);
        if (!$r) {
            oci_close($connect);
            return LogUtil::registerError($this->__('Error! Could not load items.'));
        }

        $array = oci_fetch_array($results);
        $registre = array('fullname' => $array[0],
            'visible' => $array[1],
            'summary' => $array['SUMMARY']);

        if (isset($role)) {
            $registre = array('rolename' => $array[3],
                'id' => $array[4]);
        }
        oci_close($connect);
        // Return and array with values
        return $registre;
    }

    /**
     * Get the identity and other information of a user in Moodle tables
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	id of the user in the intranet
     * @return:	The id of the user in Moodle
     */
    public function getuserMDuid($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $connect = ModUtil::apiFunc('IWmoodle', 'user', 'connectExtDB');
        if (!$connect) {
            return LogUtil::registerError($this->__('The connection to Moodle database has failed.'));
        }
        $prefix = ModUtil::getVar('IWmoodle', 'dbprefix');
        $sql = "SELECT id, password, auth, mnethostid
			FROM $prefix" . "user
			WHERE username='$username'";

        $results = oci_parse($connect, $sql);
        $r = oci_execute($results);
        if (!$r) {
            oci_close($connect);
            return LogUtil::registerError($this->__('Error! Could not load items.'));
        }
        $array = oci_fetch_row($results);
        $registre = array('id' => $array[0],
            'password' => $array[1],
            'auth' => $array[2],
            'mnethostid' => $array[3]);
        oci_close($connect);
        // Return and array with values
        return $registre;
    }

    /**
     * Get the courses of Moodle where the user is enroled
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	id of the user in the intranet
     * @return:	And array with the courses where the user is registered
     */
    public function getusercourses($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $registres = array();
        // gets user id from Moodle
        $user_array = ModUtil::apiFunc('IWmoodle', 'user', 'getuserMDuid', array('username' => $args['user']));
        $userid = $user_array['id'];
        $prefix = ModUtil::getVar('IWmoodle', 'dbprefix');
        $username = UserUtil::getVar('uname');
        $connect = ModUtil::apiFunc('IWmoodle', 'user', 'connectExtDB');
        if (!$connect) {
            return LogUtil::registerError($this->__('The connection to Moodle database has failed.'));
        }
        $sql = "SELECT $prefix" . "course.id, $prefix" . "role.name as rolename, to_char($prefix" . "course.summary) as summary, $prefix" . "course.fullname
			FROM $prefix" . "course, $prefix" . "context, $prefix" . "role_assignments, $prefix" . "role
			WHERE $prefix" . "context.id = $prefix" . "role_assignments.contextid 
			AND $prefix" . "role_assignments.userid = $userid
			AND $prefix" . "course.id = $prefix" . "context.instanceid
			AND  $prefix" . "role.id = $prefix" . "role_assignments.roleid
			AND $prefix" . "course.visible=1
			ORDER BY $prefix" . "course.id,$prefix" . "course.fullname";
        $results = oci_parse($connect, $sql);
        $r = oci_execute($results);
        if (!$r) {
            oci_close($connect);
            return LogUtil::registerError($this->__('Error! Could not load items.'));
        }
        while ($array = oci_fetch_array($results)) {
            $registres[] = array('id' => $array['ID'],
                'rolename' => $array['ROLENAME'],
                'summary' => $array['SUMMARY'],
                'fullname' => $array['FULLNAME']);
        }
        oci_close($connect);
        // Return and array with values
        return $registres;
    }

    /**
     * Checks if an user is pre-enroled in a course
     * @author:     Albert PÃ©rez Monfort (intraweb@xtec.cat)
     * @param:	args   Array with the id of the course, the role and the id of the user
     * @return:	True if the user is pre-enroled and false in any other case
     */
    public function is_preenroled($args) {

        // Security check
        if (!SecurityUtil::checkPermission('IWmoodle:coursesblock:', "::", ACCESS_READ)) {
            return false;
        }
        extract($args);
        $pntable = & DBUtil::getTables();
        $c = $pntable['IWmoodle_column'];
        $where = "$c[uid] = $user AND $c[mcid] = $course	AND $c[role] = $role";
        // get the objects from the db
        $items = DBUtil::selectObjectArray('IWmoodle', $where);
        // Check for an error with the database code, and if so set an appropriate
        // error message and return
        if ($items === false) {
            return LogUtil::registerError($this->__('Error! Could not load items.'));
        }
        if (count($items) > 0) {
            return true;
        } else {
            return false;
        }
    }

}