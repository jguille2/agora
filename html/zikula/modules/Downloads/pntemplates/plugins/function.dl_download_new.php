<?php
//-------------------------------------------------------------------------------------
/**
 * Downloads
 *
 * Purpose of file:  smarty plugin
 *
 * @package      Downloads
 * @version      2.3
 * @author       Sascha Jost
 * @link         http://www.cmods-dev.de
 * @copyright    Copyright (C) 2005 by the Cmods Development Team
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
 // -----------------------------------------------------------------------------------

/**
 * Smarty modifier to display the correct message
 * 
 * 
 * @param        array    $string     
 * @return       string   
 */
function smarty_function_dl_download_new ($params, &$smarty)
{

	extract($params);
    unset($params);
    
    if (!isset($lid)) 
	{
        $lid =0;
    }
    
	$grafx = pnVarPrepForDisplay(pnModAPIFunc('Downloads', 'user', 'file_new_icon',array('cid' => 0, 'get_by_cid' => false,'lid' => $lid,'get_by_lid' => true)));

    if (isset($assign)) 
	{
        $smarty->assign($assign, $grafx);
    } 
	else 
	{
        return $grafx;
    }
}

?>
