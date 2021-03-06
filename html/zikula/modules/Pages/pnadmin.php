<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2002, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnadmin.php 411 2010-04-23 16:02:49Z yokav $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Value_Addons
 * @subpackage Pages
 */

/**
 * the main administration function
 *
 * @return string HTML output
 */
function Pages_admin_main()
{
    // Security check
    if (!SecurityUtil::checkPermission('Pages::', '::', ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    // Create output object
    $render = & pnRender::getInstance('Pages', false);

    // Return the output that has been generated by this function
    return $render->fetch('pages_admin_main.htm');
}

/**
 * add new item
 *
 * @return string HTML output
 */
function Pages_admin_new()
{
    // Security check
    if (!SecurityUtil::checkPermission('Pages::', '::', ACCESS_ADD)) {
        return LogUtil::registerPermissionError();
    }

    $dom = ZLanguage::getModuleDomain('Pages');

    // Get the module configuration vars
    $modvars = pnModGetVar('Pages');

    // Create output object
    $render = & pnRender::getInstance('Pages', false);

    if ($modvars['enablecategorization']) {
        // load the category registry util
        if (!Loader::loadClass('CategoryRegistryUtil')) {
            pn_exit(__f('Error! Unable to load class [%s]', 'CategoryRegistryUtil', $dom));
        }
        $catregistry = CategoryRegistryUtil::getRegisteredModuleCategories('Pages', 'pages');

        $render->assign('catregistry', $catregistry);
    }

    $render->assign($modvars);
    $render->assign('lang', ZLanguage::getLanguageCode());

    // Return the output that has been generated by this function
    return $render->fetch('pages_admin_new.htm');
}

/**
 * create a page
 * @param 'title' the title of the page
 * @param 'content' the content of the page
 * @param 'language' the language of the page
 */
function Pages_admin_create($args)
{
    // Confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Pages', 'admin', 'view'));
    }

    $dom = ZLanguage::getModuleDomain('Pages');

    $page = FormUtil::getPassedValue('page', isset($args['page']) ? $args['page'] : null, 'POST');

    // Notable by its absence there is no security check here
    // Create the page
    $pageid = pnModAPIFunc('Pages', 'admin', 'create', $page);

    // The return value of the function is checked
    if ($pageid != false) {
        // Success
        LogUtil::registerStatus(__('Done! Page created.', $dom));
    }

    return pnRedirect(pnModURL('Pages', 'admin', 'view'));
}

/**
 * modify a page
 *
 * @param 'pageid' the id of the item to be modified
 * @return string HTML output
 */
function Pages_admin_modify($args)
{
    $dom = ZLanguage::getModuleDomain('Pages');

    $pageid   = FormUtil::getPassedValue('pageid', isset($args['pageid']) ? $args['pageid'] : null, 'GET');
    $objectid = FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'GET');
    // At this stage we check to see if we have been passed $objectid
    if (!empty($objectid)) {
        $pageid = $objectid;
    }

    // Validate the essential parameters
    if (empty($pageid)) {
        return LogUtil::registerArgsError();
    }

    // Get the page
    $item = pnModAPIFunc('Pages', 'user', 'get', array('pageid' => $pageid));

    if ($item === false) {
        return LogUtil::registerError(__('No such page found.', $dom), 404);
    }

    // Security check
    if (!SecurityUtil::checkPermission('Pages::', "$item[title]::$pageid", ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    // Get the module configuration vars
    $modvars = pnModGetVar('Pages');

    $item['returnurl'] = pnServerGetVar('HTTP_REFERER');

    // Create output object
    $render = & pnRender::getInstance('Pages', false);

    if ($modvars['enablecategorization']) {
        // load the category registry util
        if (!Loader::loadClass('CategoryRegistryUtil')) {
            pn_exit(__f('Error! Unable to load class [%s]', 'CategoryRegistryUtil', $dom));
        }
        $catregistry = CategoryRegistryUtil::getRegisteredModuleCategories('Pages', 'pages');

        $render->assign('catregistry', $catregistry);
    }

    // assign the item to the template
    $render->assign($item);
    $render->assign($modvars);

    // now we've got this far let's lock the page for editing
    pnModAPIFunc('PageLock', 'user', 'pageLock',
                 array('lockName' => "Pagespage{$pageid}",
                       'returnUrl' => pnModURL('Pages', 'admin', 'view')));

    // Return the output that has been generated by this function
    return $render->fetch('pages_admin_modify.htm');
}

/**
 * update page
 *
 * @param 'pageid' the id of the page
 * @param 'title' the title of the page
 * @param 'content' the content of the page
 * @param 'language' the language of the page
 */
function Pages_admin_update($args)
{
    // Confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError(pnModURL('Pages', 'admin', 'view'));
    }

    $dom = ZLanguage::getModuleDomain('Pages');

    $page = FormUtil::getPassedValue('page', isset($args['page']) ? $args['page'] : null, 'POST');
    $url  = FormUtil::getPassedValue('url', isset($args['url']) ? $args['url'] : null, 'POST');
    if (!empty($page['objectid'])) {
        $page['pageid'] = $page['objectid'];
    }

    // Validate the essential parameters
    if (empty($page['pageid'])) {
        return LogUtil::registerArgsError();
    }

    // Notable by its absence there is no security check here
    // Update the page
    if (pnModAPIFunc('Pages', 'admin', 'update', $page)) {
        // Success
        LogUtil::registerStatus(__('Done! Page updated.', $dom));
    }

    // now release the page lock
    pnModAPIFunc('PageLock', 'user', 'releaseLock',
                 array('lockName' => "Pagespage{$page['pageid']}"));

    if (!isset($url)) {
        return pnRedirect(pnModURL('Pages', 'admin', 'view'));
    }

    return pnRedirect($url);
}

/**
 * delete item
 *
 * @param 'pageid' the id of the page
 * @param 'confirmation' confirmation that this item can be deleted
 * @return mixed string HTML output if no confirmation otherwise true
 */
function Pages_admin_delete($args)
{
    $dom = ZLanguage::getModuleDomain('Pages');

    $pageid = FormUtil::getPassedValue('pageid', isset($args['pageid']) ? $args['pageid'] : null, 'REQUEST');
    $objectid = FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'REQUEST');
    $confirmation = FormUtil::getPassedValue('confirmation', null, 'POST');
    if (!empty($objectid)) {
        $pageid = $objectid;
    }

    // Validate the essential parameters
    if (empty($pageid)) {
        return LogUtil::registerArgsError();
    }

    // Get the existing page
    $item = pnModAPIFunc('Pages', 'user', 'get', array('pageid' => $pageid));

    if ($item === false) {
        return LogUtil::registerError(__('No such page found.', $dom), 404);
    }

    // Security check
    if (!SecurityUtil::checkPermission('Pages::', "$item[title]::$pageid", ACCESS_DELETE)) {
        return LogUtil::registerPermissionError();
    }

    // Check for confirmation.
    if (empty($confirmation)) {
        // No confirmation yet
        // Create output object
        $render = & pnRender::getInstance('Pages', false);

        // Add a hidden field for the item ID to the output
        $render->assign('pageid', $pageid);

        // Return the output that has been generated by this function
        return $render->fetch('pages_admin_delete.htm');
    }

    // If we get here it means that the user has confirmed the action

    // Confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError(pnModURL('Pages', 'admin', 'view'));
    }

    // Delete the page
    if (pnModAPIFunc('Pages', 'admin', 'delete', array('pageid' => $pageid))) {
        // Success
        LogUtil::registerStatus(__('Done! Page deleted.', $dom));
    }

    return pnRedirect(pnModURL('Pages', 'admin', 'view'));
}

/**
 * view items
 *
 * @param int $startnum the start item id for the pager
 * @return string HTML output
 */
function Pages_admin_view($args)
{
    // Security check
    if (!SecurityUtil::checkPermission('Pages::', '::', ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    $dom = ZLanguage::getModuleDomain('Pages');

    // Get parameters from whatever input we need.
    $startnum = (int)FormUtil::getPassedValue('startnum', isset($args['startnum']) ? $args['startnum'] : null, 'GET');
    $language = FormUtil::getPassedValue('language', isset($args['language']) ? $args['language'] : null, 'POST');
    $property = FormUtil::getPassedValue('pages_property', isset($args['pages_property']) ? $args['pages_property'] : null, 'POST');
    $category = FormUtil::getPassedValue("pages_{$property}_category", isset($args["pages_{$property}_category"]) ? $args["pages_{$property}_category"] : null, 'POST');
    $clear    = FormUtil::getPassedValue('clear', false, 'POST');
    $purge    = FormUtil::getPassedValue('purge', false, 'GET');

    if ($purge) {
        if (pnModAPIFunc('Pages', 'admin', 'purgepermalinks')) {
            LogUtil::registerStatus(__('Purging of the pemalinks was successful', $dom));
        } else {
            LogUtil::registerError(__('Purging of the pemalinks has failed', $dom));
        }
        return pnRedirect(strpos(pnServerGetVar('HTTP_REFERER'), 'purge') ? pnModURL('Pages', 'admin', 'view') : pnServerGetVar('HTTP_REFERER'));
    }
    if ($clear) {
        $property = null;
        $category = null;
    }

    // get module vars for later use
    $modvars = pnModGetVar('Pages');

    if ($modvars['enablecategorization']) {
        // load the category registry util
        if (!Loader::loadClass('CategoryRegistryUtil')) {
            pn_exit(__f('Error! Unable to load class [%s]', 'CategoryRegistryUtil', $dom));
        }
        $catregistry = CategoryRegistryUtil::getRegisteredModuleCategories('Pages', 'pages');
        $properties  = array_keys($catregistry);

        // Validate and build the category filter - mateo
        if (!empty($property) && in_array($property, $properties) && !empty($category)) {
            $catFilter = array($property => $category);
        }

        // Assign a default property - mateo
        if (empty($property) || !in_array($property, $properties)) {
            $property = $properties[0];
        }

        // plan ahead for ML features
        $propArray = array();
        foreach ($properties as $prop) {
            $propArray[$prop] = $prop;
        }
    }

    $multilingual = pnConfigGetVar('multilingual', false);

    // Get all matching pages
    $items = pnModAPIFunc('Pages', 'user', 'getall',
                          array('startnum' => $startnum,
                                'numitems' => $modvars['itemsperpage'],
                                'order'    => 'pageid',
                                'ignoreml' => ($multilingual ? false : true),
                                'language' => $language,
                                'category' => isset($catFilter) ? $catFilter : null,
                                'catregistry'  => isset($catregistry) ? $catregistry : null));

    if (!$items) {
        $items = array();
    }

    $pages = array();
    foreach ($items as $key => $item)
    {
        $options = array();
        $options[] = array('url'   => pnModURL('Pages', 'user', 'display', array('pageid' => $item['pageid'])),
                           'image' => 'demo.gif',
                           'title' => __('View', $dom));

        if (SecurityUtil::checkPermission('Pages::', "$item[title]::$item[pageid]", ACCESS_EDIT)) {
            $options[] = array('url'   => pnModURL('Pages', 'admin', 'modify', array('pageid' => $item['pageid'])),
                               'image' => 'xedit.gif',
                               'title' => __('Edit', $dom));

            if (SecurityUtil::checkPermission('Pages::', "$item[title]::$item[pageid]", ACCESS_DELETE)) {
                $options[] = array('url'   => pnModURL('Pages', 'admin', 'delete', array('pageid' => $item['pageid'])),
                                   'image' => '14_layer_deletelayer.gif',
                                   'title' => __('Delete', $dom));
            }
        }

        // Add the calculated menu options to the item array
        $item['options'] = $options;
        $pages[] = $item;
    }

    // Create output object
    $render = & pnRender::getInstance('Pages', false);

    // Assign the items to the template
    $render->assign('pages', $pages);
    $render->assign($modvars);

    // Assign the default language
    $render->assign('lang', ZLanguage::getLanguageCode());
    $render->assign('language', $language);

    // Assign the categories information if enabled
    if ($modvars['enablecategorization']) {
        $render->assign('catregistry', $catregistry);
        $render->assign('numproperties', count($propArray));
        $render->assign('properties', $propArray);
        $render->assign('property', $property);
        $render->assign('category', $category);
    }

    // Assign the information required to create the pager
    $render->assign('pager', array('numitems'     => pnModAPIFunc('Pages', 'user', 'countitems', array('category' => isset($catFilter) ? $catFilter : null)),
                                   'itemsperpage' => $modvars['itemsperpage']));

    // Return the output that has been generated by this function
    return $render->fetch('pages_admin_view.htm');
}

/**
 * modify module configuration
 *
 * @author Mark West
 * @return string HTML output string
 */
function Pages_admin_modifyconfig()
{
    // Security check
    if (!SecurityUtil::checkPermission('Pages::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    // Create output object
    $render = & pnRender::getInstance('Pages', false);

    // Assign all module vars
    $render->assign(pnModGetVar('Pages'));

    // Return the output that has been generated by this function
    return $render->fetch('pages_admin_modifyconfig.htm');
}

/**
 * This is a standard function to update the configuration parameters of the
 * module given the information passed back by the modification form
 */
function Pages_admin_updateconfig()
{
    // Security check
    if (!SecurityUtil::checkPermission('Pages::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    // Confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError(pnModURL('Pages', 'admin', 'view'));
    }

    $dom = ZLanguage::getModuleDomain('Pages');

    // Update module variables
    $itemsperpage = (int)FormUtil::getPassedValue('itemsperpage', 25, 'POST');
    if ($itemsperpage < 1) {
        $itemsperpage = 25;
    }
    pnModSetVar('Pages', 'itemsperpage', $itemsperpage);

    $enablecategorization = (bool)FormUtil::getPassedValue('enablecategorization', false, 'POST');
    pnModSetVar('Pages', 'enablecategorization', $enablecategorization);

    $def_displaywrapper = (bool)FormUtil::getPassedValue('def_displaywrapper', false, 'POST');
    pnModSetVar('Pages', 'def_displaywrapper', $def_displaywrapper);

    $def_displaytitle = (bool)FormUtil::getPassedValue('def_displaytitle', false, 'POST');
    pnModSetVar('Pages', 'def_displaytitle', $def_displaytitle);

    $def_displaycreated = (bool)FormUtil::getPassedValue('def_displaycreated', false, 'POST');
    pnModSetVar('Pages', 'def_displaycreated', $def_displaycreated);

    $def_displayupdated = (bool)FormUtil::getPassedValue('def_displayupdated', false, 'POST');
    pnModSetVar('Pages', 'def_displayupdated', $def_displayupdated);

    $def_displaytextinfo = (bool)FormUtil::getPassedValue('def_displaytextinfo', false, 'POST');
    pnModSetVar('Pages', 'def_displaytextinfo', $def_displaytextinfo);

    $def_displayprint = (bool)FormUtil::getPassedValue('def_displayprint', false, 'POST');
    pnModSetVar('Pages', 'def_displayprint', $def_displayprint);

    $addcategorytitletopermalink = (bool)FormUtil::getPassedValue('addcategorytitletopermalink', false, 'POST');
    pnModSetVar('Pages', 'addcategorytitletopermalink', $addcategorytitletopermalink);

    $showpermalinkinput = (bool)FormUtil::getPassedValue('showpermalinkinput', false, 'POST');
    pnModSetVar('Pages', 'showpermalinkinput', $showpermalinkinput);

    // Let any other modules know that the modules configuration has been updated
    pnModCallHooks('module','updateconfig','Pages', array('module' => 'Pages'));

    // the module configuration has been updated successfuly
    LogUtil::registerStatus(__('Done! Module configuration updated.', $dom));

    return pnRedirect(pnModURL('Pages', 'admin', 'view'));
}
