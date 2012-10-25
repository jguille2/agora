<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2002, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnadmin.php 9 2008-11-05 21:42:16Z Guite $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Value_Addons
 * @subpackage Referers
 */

/**
 * the main administration function
 *
 * @author       The Zikula Development Team
 * @return       output       The main module admin page.
 */
function Referers_admin_main()
{
    // Security check
    if (!SecurityUtil::checkPermission('Referers::', '::', ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    // Create output object
    $pnRender = pnRender::getInstance('Referers', false);

    // Return the output that has been generated by this function
    return $pnRender->fetch('referers_admin_main.htm');
}

/**
 * view items
 *
 * @author       The Zikula Development Team
 * @param        startnum     The number of the first item to show
 * @return       output       The main module admin page
 */
function referers_admin_view()
{
    //  Security check
    if (!SecurityUtil::checkPermission('Referers::', '::', ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }

    // Get parameters from whatever input we need
    $startnum = (int)FormUtil::getPassedValue('startnum', 1, 'REQUEST');
    $sortby   = FormUtil::getPassedValue('sortby', null, 'REQUEST');

    // Create output object
    $pnRender = pnRender::getInstance('Referers', false);

    // we need this value multiple times, so we keep it
    $itemsperpage = pnModGetVar('Referers', 'itemsperpage');

    // Get all matching referrers
    $referers = pnModAPIFunc('Referers', 'user', 'getall',
               array('sortby' => $sortby, 'startnum' => $startnum, 'numitems' => $itemsperpage));

    // Assign the items to the template
    $pnRender->assign('referers', $referers);
    $pnRender->assign('totalfreq', pnModAPIFunc('Referers', 'user', 'sumitems'));

    // assign the values for the smarty plugin to produce a pager
    $pnRender->assign('pager', array('numitems'     => pnModAPIFunc('Referers', 'user', 'countitems'),
                                     'itemsperpage' => $itemsperpage));

    // Return the output that has been generated by this function
    return $pnRender->fetch('referers_admin_view.htm');
}

/**
 * Modify configuration
 *
 * @author       The Zikula Development Team
 * @return       output       The configuration page
 */
function referers_admin_modifyconfig()
{
    // Security check
    if (!SecurityUtil::checkPermission('Referers::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    // Create output object
    $pnRender = pnRender::getInstance('Referers', false);

    // Assign all the module variables to the template
    $pnRender->assign(pnModGetVar('Referers'));

    // Return the output that has been generated by this function
    return $pnRender->fetch('referers_admin_modifyconfig.htm');
}

/**
 * Update the configuration
 *
 * @author       The Zikula Development Team
 * @param        httref         activate the http referers
 * @param        itemsperpage   number of items per page
 */
function referers_admin_updateconfig()
{
    $dom = ZLanguage::getModuleDomain('Referers');
    // Security check
    if (!SecurityUtil::checkPermission('Referers::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    // Confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Referers', 'admin', 'view'));
    }

    // Get parameters from whatever input we need
    $httpref         = FormUtil::getPassedValue('httpref', false, 'REQUEST');
    $httprefexcluded = FormUtil::getPassedValue('httprefexcluded', null, 'REQUEST');
    $itemsperpage    = (int)FormUtil::getPassedValue('itemsperpage', 25, 'REQUEST');

    // Update module variables
    pnModSetVar('Referers', 'httpref', $httpref);
    if ($itemsperpage < 1) {
        $itemsperpage = 25;
    }
    pnModSetVar('Referers', 'itemsperpage',    $itemsperpage);
    pnModSetVar('Referers', 'httprefexcluded', $httprefexcluded);

    // the module configuration has been updated successfuly
    LogUtil::registerStatus (__('Done! Module configuration updated.', $dom));

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    return pnRedirect(pnModURL('Referers', 'admin', 'view'));
}

/**
 * delete item
 *
 * @author       The Zikula Development Team
 * @param        tid            the id of the item to be modified
 * @param        confirmation   confirmation that this item can be deleted
 */
function referers_admin_delete($args)
{
    $dom = ZLanguage::getModuleDomain('Referers');
    // Get parameters from whatever input we need.
    $confirmation = FormUtil::getPassedValue('confirmation', null, 'REQUEST');

    // Security check
    if (!SecurityUtil::checkPermission('Referers::', '::', ACCESS_DELETE)) {
        return LogUtil::registerPermissionError();
    }

    // Check for confirmation.
    if (!$confirmation) {
        // No confirmation yet - display a suitable form

        // Create output object
        $pnRender = pnRender::getInstance('Referers', false);

        // Return the output that has been generated by this function
        return $pnRender->fetch('referers_admin_delete.htm');
    }

    // If we get here it means that the user has confirmed the action

    // Confirm authorisation code
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Referers', 'admin', 'view'));
    }

    // Delete all referers
    if (pnModAPIFunc('Referers', 'admin', 'delete')) {
        // Success
        LogUtil::registerStatus (__('All referers deleted', $dom));
    }

    // This function generated no output, and so now it is complete we redirect
    // the user to an appropriate page for them to carry on their work
    return pnRedirect(pnModURL('Referers', 'admin', 'view'));
}