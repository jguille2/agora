<?php
function smarty_function_iwqvuserassignmentactionmenulinks($params, &$smarty)
{
	$dom = ZLanguage::getModuleDomain('iw_qv');
	// set some defaults
	if (!isset($params['start'])) {
		$params['start'] = '[';
	}
	if (!isset($params['end'])) {
		$params['end'] = ']';
	}
	if (!isset($params['separator'])) {
		$params['separator'] = ' | ';
	}
	if (!isset($params['class'])) {
		$params['class'] = 'pn-sub';
	}

	if ($params['viewas']=='teacher'){
		if (SecurityUtil::checkPermission('iw_qv::', "::", ACCESS_ADD)) {
			$html = "<span class=\"" . $params['class'] . "\">" . $params['start'] . " ";	
			$html .= "<a onclick=\"iwqvPreviewAssignment('".$params['url']."?skin=".$params['skin']."&lang=".$params['lang']."')\" href=\"javascript:void(0);\">".__('preview', $dom)."</a>";
			if ($params['hidecorrect']==false) $html .= $params['separator']. "<a onclick=\"iwqvShowAssignment(".$params['qvid'].", '".$params['viewas']."')\" href=\"javascript:void(0);\">".__('correct', $dom)."</a>";
			$html .= $params['separator']. "<a onclick=\"iwqvEditAssignment(".$params['qvid'].")\" href=\"javascript:void(0);\">".__('edit', $dom)."</a>";
			
			if (SecurityUtil::checkPermission('iw_qv::', "::", ACCESS_DELETE)) {
				if ($params['hidecorrect']==false) $html .= $params['separator']. "<a onclick=\"iwqvDeleteAssignment(".$params['qvid'].")\" href=\"javascript:void(0);\">".__('delete', $dom)."</a>";
			}
			$html .= $params['end'] . "</span>\n";
		}		
	}
	return $html;
}
