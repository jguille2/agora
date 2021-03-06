<?php

class Agoraportal_Api_Admin extends Zikula_AbstractApi {

    /**
     * Insert a new client in the database
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param 		The client main properties 
     * @return 		The new client identity if success and false otherwise 
     */
    public function createClient($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            //TODO: Protect correctly this function. It needs access from the AuthLDAP module in the first validation process
            //throw new Zikula_Exception_Forbidden();
        }
        // Needed argument
        if (!isset($args['clientName']) || !isset($args['clientDNS']) || !isset($args['clientCode'])) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        // Check if the client DNS exists or the client code exists
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_clients_column'];
        $where = "$c[clientCode]='$args[clientCode]' OR $c[clientDNS]='$args[clientDNS]'";
        $items = DBUtil::selectObjectArray('agoraportal_clients', $where, '', '0', '1', 'clientId');
        if ($items === false) {
            return LogUtil::registerError($this->__('S\'ha produït un error en carregar elements'));
        }
        if (!empty($items)) {
            return LogUtil::registerError($this->__('Aquest client ja existeix. El DNS i el codi de client han de ser únics'));
        }
        //Create item
        $item = array('clientCode' => $args['clientCode'],
            'clientName' => $args['clientName'],
            'clientDNS' => $args['clientDNS'],
            'clientAddress' => $args['clientAddress'],
            'clientCity' => $args['clientCity'],
            'clientPC' => $args['clientPC'],
            'clientState' => $args['clientState'],
            'clientDescription' => $args['clientDescription']);
        if (!DBUtil::insertObject($item, 'agoraportal_clients', 'clientId')) {
            return LogUtil::registerError($this->__('L\'intent de creació ha fallat'));
        }

        Loader::LoadClass('UserUtil');
        $idGroupClients = UserUtil::getGroupIdList('name=\'Clients\'');

        if (!isset($args['dontAddToGroup']) && !ModUtil::apiFunc('Groups', 'user', 'isgroupmember', array('gid' => $idGroupClients,
                    'uid' => UserUtil::getIdFromName($args['clientCode'])))) {
            if (UserUtil::getIdFromName($args['clientCode'])) {
                // add client to clients group which has the id 3
                if (!ModUtil::apiFunc('Groups', 'admin', 'adduser', array('gid' => $idGroupClients,
                            'uid' => UserUtil::getIdFromName($args['clientCode'])))) {
                    return LogUtil::registerError($this->__('El client no s\'ha pogut posar al grup de clients.'));
                }
            }
        }
        // Return the id of the newly created item to the calling process
        return $item['clientId'];
    }

    /**
     * Update a existing client
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param 		Client identity and new properties values
     * @return 		True if success and false otherwise 
     */
    public function editClient($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get client information
        $client = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClients', array('clientId' => $args['clientId']));
        if (!$client) {
            LogUtil::registerError($this->__('No s\'ha trobat el client'));
            return System::redirect(ModUtil::url('Agoraportal', 'admin', 'clientsList'));
        }
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_clients_column'];
        $where = "$c[clientId] = $args[clientId]";
        if (!DBUTil::updateObject($args['items'], 'agoraportal_clients', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * update a service for a given client
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param 		Client-service identity
     * @return 		True if success and false otherwise 
     */
    public function editService($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $clientServiceId = $args['clientServiceId'];

        // Needed argument
        if (!isset($clientServiceId) || !is_numeric($clientServiceId)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        //Get item
        $item = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClientsAndServices', array('clientServiceId' => $clientServiceId));
        if ($item == false) {
            return LogUtil::registerError($this->__('No s\'ha trobat el servei'));
        }
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_client_services_column'];
        $where = "$c[clientServiceId] = $clientServiceId";

        if (!DBUTil::updateObject($args['items'], 'agoraportal_client_services', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * remove a service for a given client
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param 		Client-service identity
     * @return 		True if success and false otherwise 
     */
    public function deleteService($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $clientServiceId = $args['clientServiceId'];
        // Needed argument
        if (!isset($clientServiceId) || !is_numeric($clientServiceId)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        //Get item
        $item = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClientsAndServices', array('clientServiceId' => $clientServiceId));
        if ($item == false) {
            return LogUtil::registerError($this->__('No s\'ha trobat el servei'));
        }
        if (!DBUtil::deleteObjectByID('agoraportal_client_services', $clientServiceId, 'clientServiceId')) {
            return LogUtil::registerError($this->__('L\'intent d\'esborrament ha fallat'));
        }
        // The item has been deleted, so we clear all cached pages of this item.
        $view = Zikula_View::getInstance('Agoraportal');
        $view->clear_cache(null, $clientServiceId);
        return true;
    }

    /**
     * Activate moodle service. Each service have got its activation function.
     * 
     * @author 	Albert Pérez Monfort (aperezm@xtec.cat)
     * @author 	Toni Ginard
     *
     * @param string Client-service identity
     * 
     * @return  array if Ok / boolean if error
     */
    public function activeService_moodle2($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Needed argument
        $clientServiceId = $args['clientServiceId'];
        if (!isset($clientServiceId) || !is_numeric($clientServiceId)) {
            return LogUtil::registerError($this->__('Falta l\'Id del client-servei'));
        }

        // This function is only for moodle2 service
        $serviceName = 'moodle2';

        // Get definition of service moodle2
        $service = ModUtil::apiFunc('Agoraportal', 'user', 'getServiceByName', array('serviceName' => $serviceName));
        if (!is_array($service)) {
            return LogUtil::registerError($this->__('No s\'ha trobat el servei moodle2'));
        }

        $serviceId = $service['serviceId'];

        // Get full client-service record
        $clientService = ModUtil::apiFunc('Agoraportal', 'user', 'getClientServiceById', array('clientServiceId' => $clientServiceId));
        if (!$clientService) {
            return LogUtil::registerError($this->__('No s\'ha trobat la informació del client-servei amb Id ' . $clientServiceId));
        }

        // Get full client record
        $client = ModUtil::apiFunc('Agoraportal', 'user', 'getClientById', array('clientId' => $clientService['clientId']));
        if (!$client) {
            return LogUtil::registerError($this->__('No s\'ha trobat la informació del client amb Id ' . $clientServiceId['clientId']));
        }

        // Get a DB Id
        if (!empty($clientService) && $clientService['activedId'] > 0) {
            // This client-service has already an Id assigned
            $db = $clientService['activedId'];
        } else {
            // Get the actual Id
            $db = ModUtil::apiFunc('Agoraportal', 'admin', 'getFreeDataBase', array('serviceId' => $serviceId,
                        'serviceName' => $serviceName));
            if (!$db) {
                LogUtil::registerError($this->__('No queda cap base de dades lliure'));
                return false;
            }
        }

        global $agora;
        $prefix = $agora[$serviceName]['prefix'];

        // Query to get admin id
        $sql = "SELECT id FROM {$prefix}user WHERE username='admin'";
        // Actual execution
        $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $db,
                    'sql' => $sql,
                    'serviceName' => $serviceName,
                ));
        // Error check. Stop in case of error.
        if (!$result['success']) {
            return LogUtil::registerError($this->__('No s\'ha pogut executar la consulta: ' . $sql . '. Error: ' . $result['errorMsg']));
        } else {
            // Keep result
            $adminId = $result['values'][0]['ID'];
        }

        // Generate a password for Moodle admin user
        $password = $this->createRandomPass();
        $passwordEnc = md5($password);

        // Query to update admin password
        $sqls[] = "
            UPDATE {$prefix}user
            SET password='$passwordEnc',
                firstname='Administrador/a',
                lastname='" . str_replace("'", "''", $client['clientName']) . "',
                email='" . str_replace("'", "''", $client['clientCode']) . "@xtec.cat',
                institution='" . str_replace("'", "''", $client['clientName']) . "',
                address='" . str_replace("'", "''", $client['clientAddress']) . "',
                city='" . str_replace("'", "''", $client['clientCity']) . "'
            WHERE id=$adminId
            ";

        // Query to force change of password of user admin
        $sqls[] = "
            UPDATE {$prefix}user_preferences
            SET value=1
            WHERE name='auth_forcepasswordchange' AND userid=$adminId
            ";

        // Query to update site name and site description
        $sqls[] = "
            UPDATE {$prefix}course 
            SET	fullname='" . str_replace("'", "''", $client['clientName']) . "',
                shortname='" . str_replace("'", "''", $client['clientDNS']) . "',
                summary='Moodle del centre " . str_replace("'", "''", $client['clientName']) . "'
            WHERE id=1
            ";

        // Query to update the cookie name
        $sessionPrefix = 'moodle';
        $sqls[] = "
            UPDATE {$prefix}config 
            SET value='$sessionPrefix" . $client['clientId'] . "' 
            WHERE name='sessioncookie'
            ";

        // Execute the querys
        foreach ($sqls as $sql) {
            // Actual execution
            $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $db,
                        'sql' => $sql,
                        'serviceName' => $serviceName,
                    ));
            // Error check. Stop in case of error.
            if (!$result['success']) {
                return LogUtil::registerError($this->__('No s\'ha pogut executar la consulta: ' . $sql . '. Error: ' . $result['errorMsg']));
            }
        }

        return array('db' => $db, 'password' => $password);
    }

    /**
     * Activate intranet service. Each service have got its activation function
     *
     * @author 	Albert Pérez Monfort (aperezm@xtec.cat)
     * @author 	Toni Ginard
     *
     * @param string $clientServiceId
     * @param string Data base server including optional port
     * 
     * @return 	array if Ok / boolean if error
     */
    public function activeService_intranet($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Get the params
        $clientServiceId = $args['clientServiceId'];
        $dbHost = $args['dbHost'];

        // Needed argument
        if (!isset($clientServiceId) || !is_numeric($clientServiceId)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        // Get all info about service with ID $clientServiceId
        $item = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClientsAndServices', array('clientServiceId' => $clientServiceId));
        if ($item == false) {
            return LogUtil::registerError($this->__('No s\'ha trobat el servei'));
        }

        // Get free data base and config
        $serviceId = $item[$clientServiceId]['serviceId'];
        $db = ModUtil::apiFunc('Agoraportal', 'admin', 'getFreeDataBase', array('serviceId' => $serviceId,
                    'dbHost' => $dbHost));
        if (!$db) {
            LogUtil::registerError($this->__('No queda cap base de dades lliure'));
            return false;
        }

        // Generate a password for Intraweb admin user
        $password = $this->createRandomPass();
        $passwordEnc = '1$$' . md5($password);

        global $agora;
        $username = $agora['intranet']['userprefix'] . $db;

        $sql = array();

        $value = DataUtil::formatForStore(serialize($item[$clientServiceId]['clientName']));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='sitename'";

        $value = DataUtil::formatForStore(serialize($item[$clientServiceId]['clientName']));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='defaultpagetitle'";

        $value = DataUtil::formatForStore(serialize($item[$clientServiceId]['clientCode'] . '@xtec.cat'));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='adminmail'";

        $value = DataUtil::formatForStore(serialize('ZKSID' . $db));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='sessionname'";

        $value = DataUtil::formatForStore(serialize(''));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='slogan'";

        $value = DataUtil::formatForStore(serialize('Intranet de ' . $item[$clientServiceId]['clientName']));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='defaultmetadescription'";

        $value = DataUtil::formatForStore(serialize(date('m/Y', time())));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='ZConfig' AND name='startdate'";

        $sql[] = "UPDATE users set pass='$passwordEnc', email='" . $item[$clientServiceId]['clientCode'] . "@xtec.cat' WHERE uname='admin'";

        $value = DataUtil::formatForStore(serialize($agora['server']['root'] . $agora['intranet']['datadir'] . $username . '/data'));
        $sql[] = "UPDATE module_vars set value='$value' WHERE modname='IWmain' AND name='documentRoot'";

        foreach ($sql as $oneSql) {
            $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $db,
                        'sql' => $oneSql,
                        'serviceName' => 'intranet',
                        'host' => $dbHost,
                    ));
            if (!$result['success']) {
                return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $oneSql . '. Error: ' . $result['errorMsg']));
            }
        }

        return array ('db' => $db, 'password' => $password);
    }

    /**
     * Activate marsupial service.
     * 
     * @author Albert Pérez Monfort (aperezm@xtec.cat)
     * 
     * @return 	array with dummy value
     */
    public function activeService_marsupial($args) {
        return array ('db' => 1, 'password' => '');
    }

    /**
     *  Find free database number
     * 
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @author     Toni Ginard
     * 
     * @param  		Client-service identity
     * 
     * @return 		The first available database or false if something is wrong
     */
    public function getFreeDataBase($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Needed for connectExtDB
        $dbHost = $args['dbHost'];

        // Moodle and moodle2 use the same activeId, so must be treated as one 
        if (isset($args['serviceName']) && $args['serviceName'] == 'moodle2') {
            // Get the list of moodle2 services of all the clients. First step 
            // is to get the service Id from the service definition. Second step 
            // is get all the client-services with that Id.
            $moodle2Service = ModUtil::apiFunc('Agoraportal', 'user', 'getServiceByName', array('serviceName' => 'moodle2'));
            $moodle2ServiceId = $moodle2Service['serviceId'];
            $moodle2ClientServices = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClientsAndServices', array('service' => $moodle2ServiceId,
                        'state' => -1));

            if (empty($moodle2ClientServices)) {
                LogUtil::registerError($this->__('No s\'han obtingut dades de la taula clientServices'));
                return false;
            }

            // Initial values
            $databaseIds = array();
            $max = 0;

            // Get a list of activedId of moodle2 client-services
            foreach ($moodle2ClientServices as $service) {
                if ($service['activedId'] != 0) {
                    $databaseIds[] = $service['activedId'];
                    if ($service['activedId'] > $max) {
                        $max = $service['activedId'];
                    }
                }
            }

            sort($databaseIds);

        } else {
            // get all services (all states)
            $items = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClientsAndServices', array('service' => $args['serviceId'],
                        'state' => -1));
            if (!$items) {
                return false;
            }

            // get all the database used
            $databaseIds = array();
            $max = 0;
            foreach ($items as $item) {
                if ($item['activedId'] != 0) {
                    $databaseIds[] = $item['activedId'];
                    if ($item['activedId'] > $max) {
                        $max = $item['activedId'];
                    }
                }
            }

            sort($databaseIds);
        }

        // Look for next free ID
        $j = 0;
        // First, look for a free database (a gap in the list)
        for ($i = 0; $i < $max; $i++) {
            $j++;
            if ($databaseIds[$i] != $j) {
                $free = $j;
                break;
            }
        }

        // No luck, so let's try the following ID
        if ($j == $max) {
            $free = $max + 1;
        }

        // Get info of the service from its ID
        $serviceInfo = ModUtil::apiFunc('Agoraportal', 'user', 'getService', array('serviceId' => $args['serviceId']));

        $connect = ModUtil::apiFunc('Agoraportal', 'user', 'connectExtDB', array('serviceName' => $serviceInfo['serviceName'],
                    'database' => $free,
                    'host' => $dbHost));

        if (!$connect) {
            return false;
        }

        return $free;
    }

    /**
     * Update an existing service
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The service identity
     * @return     The first available database or false if something is wrong
     */
    public function updateService($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_services_column'];
        $where = "$c[serviceId] = $args[serviceId]";
        if (!DBUtil::updateObject($args['service'], 'agoraportal_services', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * Update a location
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The location identity
     * @return     Thue if success and false otherwise
     */
    public function editLocation($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get location information
        $location = ModUtil::apiFunc('Agoraportal', 'user', 'getAllLocations', array('locationId' => $args['locationId']));
        if (!$location) {
            return LogUtil::registerError($this->__('No s\'ha trobat el Servei Territorial'));
        }
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_location_column'];
        $where = "$c[locationId] = $args[locationId]";
        $items = array('locationName' => $args['locationName']);
        if (!DBUtil::updateObject($items, 'agoraportal_location', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * Update a request type
     * @author      Aida Regi Cosculluela (aregi@xtec.cat)
     * @param      The request type information
     * @return     Thue if success and false otherwise
     */
    public function editRequestType($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get location information
        $requestType = ModUtil::apiFunc('Agoraportal', 'user', 'getAllRequestTypes', array('requestTypeId' => $args['requestTypeId']));
        if (!$requestType) {
            return LogUtil::registerError($this->__('No s\'ha trobat el tipus de sol·licitud'));
        }
        $id = $args['requestTypeId'];
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_requestTypes_column'];
        $where = "$c[requestTypeId] = $id";
        $items = array('name' => $args['requestTypeName'], 'description' => $args['requestTypeDescription'], 'userCommentsText' => $args['requestTypeUserCommentsText']);
        if (!DBUtil::updateObject($items, 'agoraportal_requestTypes', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * Insert a new location
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The location parameters
     * @return     Thue new location identity if success and false otherwise
     */
    public function addNewLocation($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Check if the client DNS exists or the client code exists
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_location_column'];
        //Create item
        $item = array('locationName' => $args['locationName']);
        if (!DBUtil::insertObject($item, 'agoraportal_location', 'locationId')) {
            return LogUtil::registerError($this->__('L\'intent de creació ha fallat'));
        }
        // Return the id of the newly created item to the calling process
        return $item['locationId'];
    }

    /**
     * Insert a new relation request type - service
     * @author      Aida Regi Cosculluela (aregi@xtec.cat)
     * @param      The request type and service identification
     * @return     The request type identity if success and false otherwise
     */
    public function addNewRequestTypeService($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Check if the client DNS exists or the client code exists
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_requestTypesServices_column'];
        //Create item
        $item = array('requestTypeId' => $args['requestTypeId'], 'serviceId' => $args['serviceId']);
        if (!DBUtil::insertObject($item, 'agoraportal_requestTypesServices')) {
            return LogUtil::registerError($this->__('L\'intent de creació ha fallat'));
        }
        // Return the id of the newly created item to the calling process
        return $item['requestTypeId'];
    }

    /**
     * Insert a new request type
     * @author      Aida Regi Cosculluela (aregi@xtec.cat)
     * @param      The request type parameters
     * @return     Thue new request type identity if success and false otherwise
     */
    public function addNewRequestType($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Check if the client DNS exists or the client code exists
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_requestTypes_column'];
        //Create item
        $item = array('name' => $args['requestTypeName'], 'description' => $args['requestTypeDescription'], 'userCommentsText' => $args['requestTypeUserCommentsText']);
        if (!DBUtil::insertObject($item, 'agoraportal_requestTypes', 'requestTypeId')) {
            return LogUtil::registerError($this->__('L\'intent de creació ha fallat'));
        }
        // Return the id of the newly created item to the calling process
        return $item['requestTypeId'];
    }

    /**
     * Remove a location
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The location identity
     * @return     Thue if success and false otherwise
     */
    public function deleteLocation($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get location information
        $location = ModUtil::apiFunc('Agoraportal', 'user', 'getAllLocations', array('locationId' => $args['locationId']));
        if (!$location) {
            return LogUtil::registerError($this->__('No s\'ha trobat el Servei Territorial'));
        }
        if (!DBUtil::deleteObjectByID('agoraportal_location', $args['locationId'], 'locationId')) {
            return LogUtil::registerError($this->__('L\'intent d\'esborrament ha fallat'));
        }
        // The item has been deleted, so we clear all cached pages of this item.
        $view = Zikula_View::getInstance('Agoraportal');
        $view->clear_cache(null, $args['locationId']);
        return true;
    }

    /**
     * Update a client type
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The type identity
     * @return     Thue if success and false otherwise
     */
    public function editType($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get location information
        $location = ModUtil::apiFunc('Agoraportal', 'user', 'getAllTypes', array('typeId' => $args['typeId']));
        if (!$location) {
            return LogUtil::registerError($this->__('No s\'ha trobat la tipologia'));
        }
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_clientType_column'];
        $where = "$c[typeId] = $args[typeId]";
        $items = array('typeName' => $args['typeName']);
        if (!DBUtil::updateObject($items, 'agoraportal_clientType', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * Remove a relation between a request type and a service
     * @author     Aida Regi Cosculluela (aregi@xtec.cat)
     * @param      The request type and service identities
     * @return     Thue if success and false otherwise
     */
    public function deleteRequestTypeService($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_requestTypesServices_column'];

        $type = $args['requestTypeId'];
        $service = $args['serviceId'];
        $where = "$c[requestTypeId] = $type AND $c[serviceId] = $service";

        if (!DBUtil::deleteWhere('agoraportal_requestTypesServices', $where)) {
            return LogUtil::registerError($this->__('L\'intent d\'esborrament ha fallat'));
        }
        // The item has been deleted, so we clear all cached pages of this item.
        $view = Zikula_View::getInstance('Agoraportal');
        $view->clear_cache(null, $args['requestTypeId']);
        return true;
    }

    /**
     * Remove a request type
     * @author     Aida Regi Cosculluela (aregi@xtec.cat)
     * @param      The request type identity
     * @return     Thue if success and false otherwise
     */
    public function deleteRequestType($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get location information
        $requestType = ModUtil::apiFunc('Agoraportal', 'user', 'getAllRequestTypes', array('requestTypeId' => $requestTypeId));
        if (!$requestType) {
            return LogUtil::registerError($this->__('No s\'ha trobat el tipus de sol·licitud'));
        }
        if (!DBUtil::deleteObjectByID('agoraportal_requestTypes', $args['requestTypeId'], 'requestTypeId')) {
            return LogUtil::registerError($this->__('L\'intent d\'esborrament ha fallat'));
        }
        // The item has been deleted, so we clear all cached pages of this item.
        $view = Zikula_View::getInstance('Agoraportal');
        $view->clear_cache(null, $args['requestTypeId']);
        return true;
    }

    /**
     * Insert a new location
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The location parameters
     * @return     Thue new location identity if success and false otherwise
     */
    public function addNewType($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // Check if the client DNS exists or the client code exists
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_clientType_column'];
        //Create item
        $item = array('typeName' => $args['typeName']);
        if (!DBUtil::insertObject($item, 'agoraportal_clientType', 'typeId')) {
            return LogUtil::registerError($this->__('L\'intent de creació ha fallat'));
        }
        // Return the id of the newly created item to the calling process
        return $item['typeId'];
    }

    /**
     * Remove a client type
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The type identity
     * @return     Thue if success and false otherwise
     */
    public function deleteType($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        // get location information
        $location = ModUtil::apiFunc('Agoraportal', 'user', 'getAllTypes', array('typeId' => $args['typeId']));
        if (!$location) {
            return LogUtil::registerError($this->__('No s\'ha trobat la tipologia de centre'));
        }
        if (!DBUtil::deleteObjectByID('agoraportal_clientType', $args['typeId'], 'typeId')) {
            return LogUtil::registerError($this->__('L\'intent d\'esborrament ha fallat'));
        }
        // The item has been deleted, so we clear all cached pages of this item.
        $view = Zikula_View::getInstance('Agoraportal');
        $view->clear_cache(null, $args['typeId']);
        return true;
    }

    /**
     * Execute diferent actions to fix several configuration issues
     * @author		Albert Pérez Monfort (aperezm@xtec.cat)
     * @param      The client-service identity
     * @return     Thue if success and false otherwise
     */
    public function executeAction($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        $clientServiceId = FormUtil::getPassedValue('clientServiceId', isset($args['clientServiceId']) ? $args['clientServiceId'] : null, 'GETPOST');
        $action = FormUtil::getPassedValue('action', isset($args['action']) ? $args['action'] : null, 'GETPOST');

        // Needed argument
        if (!isset($clientServiceId) || !is_numeric($clientServiceId) || !isset($action) || !is_numeric($action)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        //Get item
        $item = ModUtil::apiFunc('Agoraportal', 'user', 'getAllClientsAndServices', array('clientServiceId' => $clientServiceId));
        $serviceId = $item[$clientServiceId]['serviceId'];
        $service = ModUtil::apiFunc($this->name, 'user', 'getService', array('serviceId' => $serviceId));
        $serviceName = $service['serviceName'];

        if ($item == false) {
            return LogUtil::registerError($this->__('No s\'ha trobat el servei'));
        }

        $activedId = $item[$clientServiceId]['activedId'];
        $dbHost = $item[$clientServiceId]['dbHost'];

        if ($action > 1) {
            // needed to maintain comptability during migration from 1.2.x to 1.3.x
            $compat = ModUtil::apiFunc('Agoraportal', 'admin', 'compat', array('intranetVersion' => $item[$clientServiceId]['version']));
            $host = $item[$clientServiceId]['dbHost'];
        }

        global $agora;

        switch ($action) {
            case 1: 
                // Create or delete Moodle2 super administrator
                // get all the services and tables prefix for moodle tables
                $services = ModUtil::apiFunc('Agoraportal', 'user', 'getAllServices');
                $prefix = $agora[$serviceName]['prefix'];
                $service = $services[$item[$clientServiceId]['serviceId']]['serviceName'];

                $sql = "SELECT id FROM {$prefix}user u WHERE u.username='xtecadmin'";
                $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                            'sql' => $sql,
                            'serviceName' => $serviceName,
                        ));
                if (!$result['success']) {
                    return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                }

                $uid = (isset($result['values'][0]['ID']) && $result['values'][0]['ID'] > 0) ? $result['values'][0]['ID'] : 0;

                if ($uid > 0) {
                    // Get xtecadmin user id
                    $sql = "SELECT id FROM {$prefix}user u WHERE u.username='xtecadmin'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }
                    $xtecadminID = $result['values'][0]['ID'];
                    
                    // Get list of site admins
                    $sql = "SELECT to_char(c.value) as value FROM {$prefix}config c WHERE c.name='siteadmins'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }
                    
                    // Remove xtecadmin ID from the list of admins
                    $siteadmins = explode(',', $result['values'][0]['VALUE']);
                    $siteadmins = array_diff($siteadmins, array($xtecadminID));
                    $siteadmins = implode(',', $siteadmins);

                    // Update list of site admins
                    $sql = "UPDATE {$prefix}config c SET c.value='$siteadmins' WHERE c.name='siteadmins'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }

                    $sql = "DELETE FROM {$prefix}user WHERE id='" . $uid . "'";

                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));

                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }

                    LogUtil::registerStatus($this->__('S\'ha esborrat l\'usuari xtecadmin del Moodle del centre'));
                } else {
                    // Create xtecadmin
                    // Get MNETHOSTID
                    $sql = "SELECT mnethostid FROM {$prefix}user u WHERE u.username='admin'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));

                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }
                    $mnethostid = $result['values'][0]['MNETHOSTID'];
                    // create user
                    global $agora;

                    $sql = "INSERT INTO {$prefix}USER(AUTH,
                            CONFIRMED,
                            POLICYAGREED,
                            DELETED,
                            MNETHOSTID,
                            USERNAME,
                            PASSWORD,
                            IDNUMBER,
                            FIRSTNAME,
                            LASTNAME,
                            EMAIL,
                            EMAILSTOP,
                            ICQ,
                            SKYPE,
                            YAHOO,
                            AIM,
                            MSN,
                            PHONE1,
                            PHONE2,
                            INSTITUTION,
                            DEPARTMENT,
                            ADDRESS,
                            CITY,
                            COUNTRY,
                            LANG,
                            THEME,
                            TIMEZONE,
                            FIRSTACCESS,
                            LASTACCESS,
                            LASTLOGIN,
                            CURRENTLOGIN,
                            LASTIP,
                            SECRET,
                            PICTURE,
                            URL,
                            DESCRIPTION,
                            MAILFORMAT,
                            MAILDIGEST,
                            MAILDISPLAY,
                            HTMLEDITOR,
                            AUTOSUBSCRIBE,
                            TRACKFORUMS,
                            TIMEMODIFIED,
                            TRUSTBITMASK,
                            IMAGEALT)
                            VALUES ('manual',
                                    1,
                                    0,
                                    0,
                                    $mnethostid,
                                    'xtecadmin',
                                    '" . $agora['config']['xtecadmin'] . "',
                                    ' ',
                                    'Administrador/a',
                                    'XTEC',
                                    'agora@xtec.cat',
                                    1,
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    ' ',
                                    'Barcelona',
                                    'es',
                                    'ca',
                                    ' ',
                                    '99',
                                    0,
                                    1208419071,
                                    1208419039,
                                    1208419069,
                                    '0.0.0.0',
                                    ' ',
                                    0,
                                    ' ',
                                    'Administrador/a de la XTEC ',
                                    1,
                                    0,
                                    0,
                                    1,
                                    1,
                                    0,
                                    1208418989,
                                    0,
                                    ' ')";

                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }

                    // Get xtecadmin userid
                    $sql = "SELECT id FROM {$prefix}user u WHERE u.username='xtecadmin' ";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => $serviceName,
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }
                    $xtecadminID = $result['values'][0]['ID'];

                    // Get list of site admins
                    $sql = "SELECT to_char(c.value) as value FROM {$prefix}config c WHERE c.name='siteadmins'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => 'moodle2',
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }
                    // Add xtecadmin ID from the list of admins
                    $siteadmins = explode(',', $result['values'][0]['VALUE']);
                    array_push($siteadmins, $xtecadminID);
                    $siteadmins = array_reverse($siteadmins); // xtecadmin will be main admin!
                    $siteadmins = implode(',', $siteadmins);

                    // Update list of site admins
                    echo $sql = "UPDATE {$prefix}config c SET c.value='$siteadmins' WHERE c.name='siteadmins'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => 'moodle2',
                            ));
                    if (!$result['success']) {
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }

                    LogUtil::registerStatus($this->__('S\'ha creat correctament l\'usuari xtecadmin del centre.'));
                }
                break;

            case 2: // Connect Zikula and Moodle
                break;

            case 3: // Create or delete Zikula super administrator
                $sql = "SELECT {$compat['fieldsPrefix']}uid FROM {$compat['tablePrefix']}users WHERE {$compat['fieldsPrefix']}uname='xtecadmin'";
                $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                            'sql' => $sql,
                            'serviceName' => 'intranet',
                            'host' => $host,
                        ));

                if (!$result['success'])
                    return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));

                if ($result['values'][0]["{$compat['fieldsPrefix']}uid"] > 0) {
                    //delete all the user groups
                    $sql = "DELETE FROM {$compat['tablePrefix']}group_membership
                    WHERE `{$compat['fieldsPrefix']}uid`=" . $result['values'][0]["{$compat['fieldsPrefix']}uid"];
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => 'intranet',
                                'host' => $host,
                            ));

                    if (!$result['success'])
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));

                    //the user exists and delete it
                    $sql = "DELETE FROM {$compat['tablePrefix']}users
                        WHERE `{$compat['fieldsPrefix']}uname`= 'xtecadmin'";

                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => 'intranet',
                                'host' => $host,
                            ));
                    if (!$result['success'])
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    LogUtil::registerStatus($this->__('S\'ha esborrat l\'usuari xtecadmin del centre'));
                } else {
                    //the user doesn't exists and create it
                    $sql = ($item[$clientServiceId]['version'] == '128') ?
                            "INSERT INTO zk_users (pn_uname, pn_pass, pn_email, pn_hash_method, pn_activated)
                        VALUES ('xtecadmin','" . $agora['config']['xtecadmin'] . "','agora@xtec.cat',1,1)" :
                            "INSERT INTO users (uname, pass, email, activated)
                        VALUES ('xtecadmin','" . '1$$' . $agora['config']['xtecadmin'] . "','agora@xtec.cat',1)";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => 'intranet',
                                'host' => $host,
                            ));
                    if (!$result['success'])
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));

                    $sql = "SELECT {$compat['fieldsPrefix']}uid FROM {$compat['tablePrefix']}users WHERE {$compat['fieldsPrefix']}uname='xtecadmin'";
                    $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                'sql' => $sql,
                                'serviceName' => 'intranet',
                                'host' => $host,
                            ));
                    if (!$result['success'])
                        return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));

                    if ($result['values'][0]["{$compat['fieldsPrefix']}uid"] > 0) {
                        //insert the user into admin group
                        $sql = "INSERT INTO {$compat['tablePrefix']}group_membership ({$compat['fieldsPrefix']}uid, {$compat['fieldsPrefix']}gid)
                            VALUES (" . $result['values'][0]["{$compat['fieldsPrefix']}uid"] . ",2)";

                        $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                                    'sql' => $sql,
                                    'serviceName' => 'intranet',
                                    'host' => $host,
                                ));
                        if (!$result['success'])
                            return LogUtil::registerError($this->__('L\'execució de l\'sql ha fallat: ' . $sql . '. Error:' . $result['errorMsg']));
                    }
                    LogUtil::registerStatus($this->__('S\'ha creat correctament l\'usuari xtecadmin del centre.'));
                }
                break;

            case 4: // Create the first administrator permission
                //delete the sequence in the first position
                $sql = "DELETE FROM {$compat['tablePrefix']}group_perms WHERE `{$compat['fieldsPrefix']}sequence` < 1 OR `{$compat['fieldsPrefix']}pid` = 1";
                $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                            'sql' => $sql,
                            'serviceName' => 'intranet',
                            'host' => $host,
                        ));
                if (!$result['success'])
                    return LogUtil::registerError($this->__('No s\'han pogut esborrar la seqüència amb valor 0.'));

                //insert a new sequence
                //the user doesn't exists and create it
                $sql = "INSERT INTO {$compat['tablePrefix']}group_perms ({$compat['fieldsPrefix']}gid, {$compat['fieldsPrefix']}sequence, {$compat['fieldsPrefix']}component, {$compat['fieldsPrefix']}instance, {$compat['fieldsPrefix']}level, {$compat['fieldsPrefix']}pid) VALUES (2,0,'.*','.*',800,1)";
                $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                            'sql' => $sql,
                            'serviceName' => 'intranet',
                            'host' => $host,
                        ));
                if (!$result['success'])
                    return LogUtil::registerError($this->__('No s\'han pogut crear la seqüència.'));
                break;

            case 5: // Desactive all the portal blocks
                //update blocks table
                //the user doesn't exists and create it
                $sql = "UPDATE {$compat['tablePrefix']}blocks SET {$compat['fieldsPrefix']}active=0";
                $result = ModUtil::apiFunc('Agoraportal', 'admin', 'executeSQL', array('database' => $activedId,
                            'sql' => $sql,
                            'serviceName' => 'intranet',
                            'host' => $host,
                        ));
                if (!$result['success'])
                    return LogUtil::registerError($this->__('No s\'han pogut desactivar els blocs.'));
                break;

            case 6:
            case 7:
                ModUtil::func('Agoraportal', 'user', 'calcUsedSpace', array('clientCode' => $item[$clientServiceId]['clientCode'],
                    'serviceId' => $item[$clientServiceId]['serviceId'],
                    'clientServiceId' => $clientServiceId));
                break;
        }

        return true;
    }

    /**
     * Get managers of a client. Relationship between clients' table and managers'
     * table is not done using clientID but clientCode.
     *
     * @author  Toni Ginard
     * @param   clientCode
     * @return  array containing one row per manager
     */
    public function getManagers($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Check for mandatory parameter
        if (!isset($args['clientCode'])) {
            return array();
        }

        // Get managers from DB and return
        $where = 'clientCode = \'' . $args['clientCode'] . '\''; // Condition
        $join[] = array('join_table' => 'users',
            'join_field' => array('uname', 'email'),
            'object_field_name' => array('pn_uname', 'email'),
            'compare_field_table' => 'managerUName',
            'compare_field_join' => 'uname');

        $items = DBUtil::selectExpandedObjectArray('agoraportal_client_managers', $join, $where, 'managerUName', -1, -1, 'managerId');

        return $items;
    }

    /**
     * update a service for a given client
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @author      Aida Regi
     * @param 		Client-service identity
     * @return 		True if success and false otherwise 
     */
    public function editRequest($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $requestId = $args['requestId'];
        // Needed argument
        if (!isset($requestId) || !is_numeric($requestId)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        $pntable = DBUtil::getTables();
        $c = $pntable['agoraportal_request_column'];
        $where = "$c[requestId] = $requestId";

        if (!DBUtil::updateObject($args['items'], 'agoraportal_request', $where)) {
            return LogUtil::registerError($this->__('No s\'ha pogut actualitzar'));
        }
        return true;
    }

    /**
     * remove a request for a given client
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @author      Aida Regi
     * @param 		Client-service identity
     * @return 		True if success and false otherwise 
     */
    public function deleteRequest($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }
        $clientRequestId = $args['requestId'];
        // Needed argument
        if (!isset($clientRequestId) || !is_numeric($clientRequestId)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }
        //Get item

        if (!DBUtil::deleteObjectByID('agoraportal_request', $clientRequestId, 'requestId')) {
            return LogUtil::registerError($this->__('L\'intent d\'esborrament ha fallat'));
        }
        // The item has been deleted, so we clear all cached pages of this item.
        $view = Zikula_View::getInstance('Agoraportal');
        $view->clear_cache(null, $clientRequestId);
        return true;
    }

    /**
     * remove a request for a given client
     * @author 		Albert Pérez Monfort (aperezm@xtec.cat)
     * @author      Aida Regi
     * @param 		Client-service identity
     * @return 		True if success and false otherwise 
     */
    public function getInfodeleteRequest($args) {
        // Security check
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        $clientRequestId = $args['requestId'];
        // Needed argument
        if (!isset($clientRequestId) || !is_numeric($clientRequestId)) {
            return LogUtil::registerError($this->__('No s\'ha pogut carregar el que volíeu. Reviseu les dades'));
        }

        //Get item
        $pntables = DBUtil::getTables();
        $c = $pntables['agoraportal_request_column'];
        $orderby = '';
        $where = '';

        $myJoin[] = array('join_table' => 'users',
            'join_field' => array('uname', 'email'),
            'object_field_name' => array('username', 'email'),
            'compare_field_table' => 'userId',
            'compare_field_join' => 'uid');
        $myJoin[] = array('join_table' => 'agoraportal_clients',
            'join_field' => array('clientCode', 'clientDNS', 'clientName', 'clientAddress', 'clientCity', 'clientPC', 'clientState'),
            'object_field_name' => array('clientCode', 'dns', 'clientName', 'clientAddress', 'clientCity', 'clientPC', 'clientState'),
            'compare_field_table' => 'clientId',
            'compare_field_join' => 'clientId');
        $myJoin[] = array('join_table' => 'agoraportal_requestStates',
            'join_field' => array('name'),
            'object_field_name' => array('state'),
            'compare_field_table' => 'requestStateId',
            'compare_field_join' => 'requestStateId');
        $myJoin[] = array('join_table' => 'agoraportal_requestTypes',
            'join_field' => array('name'),
            'object_field_name' => array('type'),
            'compare_field_table' => 'requestTypeId',
            'compare_field_join' => 'requestTypeId');
        $myJoin[] = array('join_table' => 'agoraportal_services',
            'join_field' => array('serviceName'),
            'object_field_name' => array('serviceName'),
            'compare_field_table' => 'serviceId',
            'compare_field_join' => 'serviceId');

        $init = (isset($args['init'])) ? $args['init'] - 1 : '-1';
        $rpp = (isset($args['rpp']) && $args['rpp'] > 0) ? $args['rpp'] : '15';

        if (isset($args['requestId'])) {
            $where = " WHERE tbl." . $c['requestId'] . " = " . $clientRequestId . "";
        }

        $items = DBUtil::selectExpandedObjectArray('agoraportal_request', $myJoin, $where, $orderby, $init, $rpp);
        return $items;
    }

    /**
     * Get all requests from database
     * 
     * @author	Albert Pérez Monfort (aperezm@xtec.cat)
     * @author Aida Regi
     * @param  Filter parameters
     * 
     * @return	Array The list of available services. False in case of error.
     */
    public function getAllRequests($args) {
        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        $pntables = DBUtil::getTables();
        $c = $pntables['agoraportal_request_column'];
        $lcolumn = $pntables['agoraportal_clients_column'];

        $where = '';

        if ((isset($args['service']) && $args['service'] != 0) || (isset($args['state']) && $args['state'] != '-1')) {
            if ($args['service'] != 0) {
                $where .= ( $where != '') ? ' AND ' : '';
                $where .= "tbl.$c[serviceId] = $args[service]";
            }
            if ($args['state'] != '-1') {
                $where .= ( $where != '') ? ' AND ' : '';
                $where .= "tbl.$c[requestStateId] = $args[state]";
            }
        }

        if ((isset($args['search']) && $args['search'] != 0) && $args['searchText'] != '') {
            $where .= ( $where != '') ? ' AND ' : '';
            switch ($args['search']) {
                case '1':
                    $where .= "b.$lcolumn[clientCode]" . " LIKE '%" . $args['searchText'] . "%'";
                    break;
                case '2':
                    $where .= "b.$lcolumn[clientName]" . " LIKE '%" . $args['searchText'] . "%'";
                    break;
                case '3':
                    $where .= "b.$lcolumn[clientCity]" . " LIKE '%" . $args['searchText'] . "%'";
                    break;
            }
        }

        $orderby = 'requestId desc';

        $myJoin[] = array('join_table' => 'users',
            'join_field' => array('uname'),
            'object_field_name' => array('username'),
            'compare_field_table' => 'userId',
            'compare_field_join' => 'uid');
        $myJoin[] = array('join_table' => 'agoraportal_clients',
            'join_field' => array('clientCode', 'clientDNS', 'clientName', 'clientAddress', 'clientCity', 'clientPC', 'clientState'),
            'object_field_name' => array('clientCode', 'dns', 'clientName', 'clientAddress', 'clientCity', 'clientPC', 'clientState'),
            'compare_field_table' => 'clientId',
            'compare_field_join' => 'clientId');
        $myJoin[] = array('join_table' => 'agoraportal_requestStates',
            'join_field' => array('name'),
            'object_field_name' => array('state'),
            'compare_field_table' => 'requestStateId',
            'compare_field_join' => 'requestStateId');
        $myJoin[] = array('join_table' => 'agoraportal_requestTypes',
            'join_field' => array('name'),
            'object_field_name' => array('type'),
            'compare_field_table' => 'requestTypeId',
            'compare_field_join' => 'requestTypeId');
        $myJoin[] = array('join_table' => 'agoraportal_services',
            'join_field' => array('serviceName'),
            'object_field_name' => array('serviceName'),
            'compare_field_table' => 'serviceId',
            'compare_field_join' => 'serviceId');

        $init = (isset($args['init'])) ? $args['init'] - 1 : '-1';
        $rpp = (isset($args['rpp']) && $args['rpp'] > 0) ? $args['rpp'] : '15';



        if (!isset($args['onlyNumber'])) {
            $args['rpp'] = (isset($args['rpp']) && $args['rpp'] > 0) ? $args['rpp'] : '15';
            $init = (isset($args['init']) && $args['init'] != 0) ? $args['init'] - 1 : '-1';
            $items = DBUtil::selectExpandedObjectArray('agoraportal_request', $myJoin, $where, $orderby, $init, $rpp);
        } else {
            $items = DBUtil::selectExpandedObjectCount('agoraportal_request', $myJoin, $where);
        }


        if ($items === false) {
            // return LogUtil::registerError($this->__('S\'ha produït un error en carregar elements'));
        }

        return $items;
    }

    /**
     * Get database table prefix and names depending on intranet version to make functions compatible
     * 
     * @author Albert Pérez Monfort (aperezm@xtec.cat)
     * @param  intranetVersion
     *  
     * @return	Array with the correct names and tables prefix in database
     */
    public function compat($args) {
        $version = $args['intranetVersion'];
        if (!isset($version) || empty($version)) {
            $version = '135';
        }

        switch ($version) {
            case '128':
                $tablePrefix = 'zk_';
                $fieldsPrefix = 'pn_';
                $coreModuleName = '/PNConfig';
                $intrawebModulePrefix = 'iw_';
                $downloadsModuleName = 'downloads';
                break;
            case '135':
                $tablePrefix = '';
                $fieldsPrefix = '';
                $coreModuleName = 'ZConfig';
                $intrawebModulePrefix = 'IW';
                $downloadsModuleName = 'Downloads';
                break;
        }
        return array('tablePrefix' => $tablePrefix,
            'fieldsPrefix' => $fieldsPrefix,
            'coreModuleName' => $coreModuleName,
            'intrawebModulePrefix' => $intrawebModulePrefix,
            'downloadsModuleName' => $downloadsModuleName,
        );
    }

    /**
     * Execute SQL commands
     * 
     * @author Albert Pérez Monfort (aperezm@xtec.cat)
     * @param  sql
     * @param  serviceName
     * @param  database 
     * @param  host 
     *  
     * @return	Array with success 0 or 1, errorMsg with the error text or '' and values in select commands
     */
    public function executeSQL($args) {
        $sql = $args['sql'];
        $serviceName = $args['serviceName'];
        $database = $args['database'];
        $host = (isset($args['host'])) ? $args['host'] : '';
        $serviceDB = (isset($args['serviceDB'])) ? $args['serviceDB'] : '';

        if (!SecurityUtil::checkPermission('Agoraportal::', "::", ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        global $agora;

        $dbType = (isset($agora[$serviceName]['dbtype'])) ? $agora[$serviceName]['dbtype'] : 'mysql';

        // Exception for portal. Is not a multisite service
        if ($serviceName == 'portal') {
            $dbType = 'mysql';
        }
        
        $connect = ModUtil::apiFunc('Agoraportal', 'user', 'connectExtDB', array('database' => $database,
                    'serviceName' => $serviceName,
                    'host' => $host,
                    'serviceDB' => $serviceDB,
                ));

        if (!$connect) {
            return LogUtil::registerError($this->__('No s\'ha pogut connectar a la base de dades amb ID ' . $database));
        }

        $success = false;
        $errorMsg = '';
        $values = array();

        switch ($dbType) {
            case 'mysql':
                $results = mysql_query($sql, $connect);
                if (!$results) {
                    $errorMsg = mysql_error();
                } else {
                    $success = true;
                    if (strtolower(substr(trim($sql), 0, 6)) == 'select') {
                        // return rows
                        while ($row = mysql_fetch_assoc($results)) {
                            $values[] = $row;
                        }
                    }
                }
                mysql_close($connect);
                break;
            case 'oci8':
            case 'oci8po':
                if (substr_count(strtolower(trim($sql)), 'insert') > 1 
                        || substr_count(strtolower(trim($sql)), 'update') > 1 
                        || substr_count(strtolower(trim($sql)), 'delete') > 1) {
                    // for multiple inserts, updates and deletes in Oracle SQL
                    $sql = "BEGIN $sql END;";
                }
                $results = oci_parse($connect, $sql);
                if (!$results) {
                    $error = oci_error($connect);
                    $errorMsg = $error["message"];
                }
                $r = oci_execute($results);
                if (!$r) {
                    $error = oci_error($results);
                    $errorMsg = $error["message"];
                } else {
                    $success = true;
                    if (strtolower(substr(trim($sql), 0, 6)) == 'select') {
                        while ($row = oci_fetch_assoc($results)) {
                            $values[] = $row;
                        }
                    }
                }
                oci_close($connect);
                break;
        }

        return array('success' => $success,
            'errorMsg' => $errorMsg,
            'values' => $values,
        );
    }

    /**
     * Create random password
     * 
     * @author Toni Ginard
     * 
     * @return string The password
     */
    public function createRandomPass() {

        // Chars allowed in password
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";

        // Sets the seed for rand function
        srand((float) microtime() * 1000000);

        for ($i = 0, $pass = ''; $i < 8; $i++) {
            $num = rand() % strlen($chars);
            $pass = $pass . substr($chars, $num, 1);
        }

        return $pass;
    }

}
