<?php
// ----------------------------------------------------------------------
// Copyright (C) 2006 per Jordi Fons
// ----------------------------------------------------------------------
// Aquest programa fa �s de les funcions de l'API de PostNuke
// PostNuke Content Management System
// Copyright (C) 2002 by the PostNuke Development Team.
// http://www.postnuke.com/
// ----------------------------------------------------------------------
// Based on:
// PHP-NUKE Web Portal System - http://phpnuke.org/
// Thatware - http://thatware.org/
// --------------------------------------------------------------------------
// Llic�ncia
//
// Aquest programa �s de software lliure. Pot redistribuir-lo i/o modificar-lo
// sota els termes de la Llic�ncia P�blica General de GNU segons est� publicada
// per la Free Software Foundation, b� de la versi� 2 de l'esmentada Llic�ncia
// o b� (segons la seva elecci�) de qualsevol versi� posterior.
//
// Aquest programa es distribueix amb l'esperan�a que sigui �til, per� sense
// cap garantia, fins i tot sense la garantia MERCANTIL impl�cita o sense
// garantir la conveni�ncia per a un prop�sit particular. Consulti la Llic�ncia
// General de GNU per a m�s detalls.
//
// Pots trobar la Llic�ncia a http://www.gnu.org/copyleft/gpl.html
// --------------------------------------------------------------------------
// Autor del fitxer original: Jordi Fons (jfons@iespfq.org)
// --------------------------------------------------------------------------
// Prop�sit del fitxer:
//      Funcions de l'usuari del m�dul llibres
// --------------------------------------------------------------------------

function iw_books_user_main()
{
    $dom = ZLanguage::getModuleDomain('iw_books');	
	
	
    if (!pnSecAuthAction(0, 'iw_books::', '::', ACCESS_READ)) {
        return pnVarPrepHTMLDisplay(__('Sorry! No authorization to access this module.', $dom));
    }
    if (!SecurityUtil::checkPermission('iw_books::', '::', ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }
    
    $pnRender = pnRender::getInstance('iw_books');
	    
    // Return the output that has been generated by this function
    return $pnRender->fetch('iw_books_user_main.htm');
    
}


/*
 Funció que retorna informació del mòdul
 */
function iw_books_user_module(){
    $dom = ZLanguage::getModuleDomain('iw_books');
	// Security check
	if (!SecurityUtil::checkPermission('iw_books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(__('Sorry! No authorization to access this module.', $dom), 403);
	}

	// Create output object
	$pnRender = pnRender::getInstance('iw_books',false);

	$module = pnModFunc('iw_main', 'user', 'module_info', array('module_name' => 'iw_books', 'type' => 'user'));

	$pnRender -> assign('module', $module);
	return $pnRender -> fetch('iw_books_user_module.htm');
}


function iw_books_user_view()
{
    $dom = ZLanguage::getModuleDomain('iw_books');
    
	if (!SecurityUtil::checkPermission('iw_books::', '::', ACCESS_READ)) {
        return LogUtil::registerPermissionError();
	}
    
	include_once('pnfpdf.php');
	
	if ( FormUtil::getPassedValue ('pdf') != ''){
		$any     = FormUtil::getPassedValue ('curs');
		$etapa   = FormUtil::getPassedValue ('etapa');
		$materia = FormUtil::getPassedValue ('materia');
		$nivell  = FormUtil::getPassedValue ('nivell');
		$lectura = FormUtil::getPassedValue ('lectura');
	

		$file = generapdf(array('any' => $any,
		'materia'  => $materia,
		'etapa'    => $etapa,
		'nivell'   => $nivell,
		'lectura' => $lectura));
	
		/*
		$file = pnModAPIFunc('iw_books', 'user', 'generapdf', array('any' => $any,
																	'materia' => $materia,
																'etapa' => $etapa,
																'nivell' => $nivell));
		*/																
	}

	
	$pnRender = pnRender::getInstance('iw_books');
	
	if (FormUtil::getPassedValue ('curs') != ""){
		$any     = FormUtil::getPassedValue ('curs');
   		$etapa   = FormUtil::getPassedValue ('etapa');
   		$nivell  = FormUtil::getPassedValue ('nivell');
 		$text    = FormUtil::getPassedValue ('text');
   		$lectura = FormUtil::getPassedValue ('lectura');
   		$materia = FormUtil::getPassedValue ('materia');	

   		$pnRender->assign('cursselec', $any);   
		$pnRender->assign('etapaselec', $etapa);  
		$pnRender->assign('nivellselec', $nivell);  
		$pnRender->assign('textselec', $text);
		$pnRender->assign('lecturaselec', $lectura);
		$pnRender->assign('materiaselec', $materia);
		
		$pnRender->assign('mostra', 1 );
		$pnRender->assign('cursacad', pnModAPIFunc('iw_books', 'user', 'cursacad', array('any' => $any)) );
		$pnRender->assign('nivell_abre', pnModAPIFunc('iw_books', 'user', 'reble', array('nivell' => $nivell)) );
		$pnRender->assign('mostra_pla', " | ".pnModAPIFunc('iw_books', 'user', 'descriplans', array('etapa' => $etapa)) );
		
		$mostra_mat = pnModAPIFunc('iw_books', 'user', 'nommateria', array('codi_mat' => $materia));
		if ($materia == "TOT"){
			$pnRender->assign('mostra_mat', " | Totes les matèries" );
		}else{
			$pnRender->assign('mostra_mat', " | ". $mostra_mat );
		}
		
   		$pnRender->assign('lectura', $lectura );	

	}else{
		$any  = pnModGetVar('iw_books', 'any');
	//	$etapa = 'TOT';
    // 	$nivell = '';
 		$text    = 0;
   		$lectura = 0;
		$materia = 'TOT';
			
		$pnRender->assign('mostra', 0 );
		$pnRender->assign('cursselec', $any );   
		$pnRender->assign('etapaselec', $etapa);  
		$pnRender->assign('nivellselec', $nivell);  
		$pnRender->assign('materiaselec', $materia);  	
		$pnRender->assign('lecturaselec', $lectura);
   }	
   
   $startnum = (int)FormUtil::getPassedValue ('startnum', 0)-1;

   //$pnRender = pnRender::getInstance('iw_books');
   
   $aanys = pnModAPIFunc('iw_books', 'user', 'anys');
   asort($aanys);
   $pnRender->assign('aanys', $aanys);
   
  /* if ($any == '') {
   		$pnRender->assign('cursselec', pnModGetVar('iw_books', 'any'));
   }*/

   
   $aplans = pnModAPIFunc('iw_books', 'user', 'plans', array('tots' => false));
  // array_unshift($aplans['TOT'], 'Tots'));
   $pnRender->assign('aplans', $aplans);
   
   $anivells = pnModAPIFunc('iw_books', 'user', 'nivells', array('blanc' => false));
   $pnRender->assign('anivells', $anivells);
   
   $amateries = pnModAPIFunc('iw_books', 'user', 'materies', array('tots' => true));
   $pnRender->assign('amateries', $amateries);
   
   $items = pnModAPIFunc('iw_books', 'user', 'getall',
                           array('startnum' => $startnum,
                                 'numitems' => pnModGetVar('iw_books', 'itemsperpage'),
                           		 'flag'     => 'user',
                                 'any'      => $any,
                                 'etapa'    => $etapa,
                                 'nivell'   => $nivell,
                           		 'lectura'  => $lectura,
                                 'materia'  => $materia)) ;

    foreach ($items as $key => $item) {
		if ( $items[$key]['lectura'] == 1){
			$items[$key]['lectura'] = "Sí";
		}else{
			$items[$key]['lectura'] = "No";
		}	
		
		if ( $items[$key]['optativa'] == 1){
			$items[$key]['optativa'] = "Sí";
		}else{
			$items[$key]['optativa'] = "No";
		}	
		
		if ( $items[$key]['materials'] != ""){
			$items[$key]['materials'] = "x";
		}else{
			$items[$key]['materials'] = "-";
		}	

    	if (SecurityUtil::checkPermission('iw_books::', "$item[titol]::$item[tid]", ACCESS_READ)) {
            $options = array();
            if (SecurityUtil::checkPermission('iw_books::', "$item[titol]::$item[tid]", ACCESS_EDIT)) {
                $options[] = array('url'   => pnModURL('iw_books', 'admin', 'modify', array('tid' => $item['tid'])),
                                   'image' => 'xedit.gif',
                                   'title' => __('Edit', $dom));
                if (SecurityUtil::checkPermission('iw_books::', "$item[titol]::$item[tid]", ACCESS_DELETE)) {
                    $options[] = array('url'   => pnModURL('iw_books', 'admin', 'delete', array('tid' => $item['tid'])),
                                       'image' => '14_layer_deletelayer.gif',
                                       'title' => __('Delete', $dom));
                }
            }

            $items[$key]['options'] = $options;
            $items[$key]['codi_mat'] = pnModAPIFunc('iw_books', 'user', 'nommateria', array('codi_mat' => $item[codi_mat]) );
    		$items[$key]['titol'] =  "<a href=\"".pnModURL('iw_books', 'user', 'display', array('tid' => $item['tid'],'etapa' => $etapa ))."\">".$items[$key]['titol']."</a>";
       //                                'image' => '',
       //                                'title' => $items[$key]['titol']);        
	            //echo $items[$key]['codi_mat']."<br>";

    	} 
    }

                 //        print_r($items);
    $pnRender->assign('iw_booksitems', $items);

	$numitems = pnModAPIFunc('iw_books', 'user', 'countitemsselect', array('any' => $any,
    													'etapa' => $etapa,
														'nivell' => $nivell,
    													'materia' => $materia,
														'lectura' => $lectura ));
											
    $pnRender->assign('pager', array( 'numitems' => $numitems,
    								 'itemsperpage' => pnModGetVar('iw_books', 'itemsperpage')));
    
    return $pnRender->fetch('iw_books_user_view.htm');
}


function iw_books_user_display()
{
	$dom = ZLanguage::getModuleDomain('iw_books');
	
   if (!pnSecAuthAction(0, 'iw_books::', '::', ACCESS_READ)) {
        return pnVarPrepHTMLDisplay(__('Sorry! No authorization to access this module.', $dom));
    }
    if (!SecurityUtil::checkPermission('iw_books::', '::', ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }
   	
    $tid   = FormUtil::getPassedValue ('tid');
    $etapa = FormUtil::getPassedValue ('etapa');

    $pnRender = pnRender::getInstance('iw_books');
    
    $item = pnModAPIFunc('iw_books', 'user', 'get',
                           array('tid' => $tid)) ;
     
    $pnRender->assign('materia', pnModAPIFunc('iw_books', 'user', 'nommateria', array('codi_mat' => $item['codi_mat'])));
      
    $item['etapa'] = pnModAPIFunc('iw_books', 'user', 'descriplans', array('etapa' => $etapa));
  //  $item['nivell'] = pnModAPIFunc('iw_books', 'user', 'reble', array('nivell' => $item['nivell']));
    $item['nivell'] = pnModAPIFunc('iw_books', 'user', 'descrinivells', array('nivell' => $item['nivell']));
    
    if ($item['optativa'] == 1){
    	$item['optativa'] = "Sí";
    }else{
    	$item['optativa'] = "No";
	}    	

	if ($item['lectura'] == 1){
    	$item['lectura'] = "Sí";
    }else{
    	$item['lectura'] = "No";
	}  
    $pnRender->assign('itembook', $item);
    $pnRender->assign('mostra', 1);                      

    return $pnRender->fetch('iw_books_user_display.htm');
}

/**
 * generate menu fragment
 */
function iw_books_usermenu()
{
    $dom = ZLanguage::getModuleDomain('iw_books');
	$output =& new pnHTML();

	$cursacademic = pnModGetVar('iw_books', 'any');

	// Start options menu
	$output->Text(pnGetStatusMsg());
	$output->Linebreak(2);

	$output->SetInputMode(_PNH_VERBATIMINPUT);
	$output->Text('<h1>'.__('Textbooks and lectures', $dom).'</h1>');
	//$output->SetOutputMode(_PNH_RETURNOUTPUT);

	$output->TableStart();
	//  $output->SetInputMode(_PNH_VERBATIMINPUT);

	// Iniciem formulari de selecci� de dades
	$output->FormStart(pnModUrl('iw_books','user','view'));

	$output->LineBreak();
	$output->TableRowStart();
	$output->TableColStart();
	$output->Text(__('Try course:', $dom));
	$output->FormText('any', $cursacademic, 4, 4);
	$output->TableColEnd();

	$data = pnModAPIFunc('iw_books', 'user', 'plans');
	$output->TableColStart();
	$output->Text(__('Plan:', $dom));
	$output->FormSelectMultiple('etapa', $data);
	$output->TableColEnd();

	$data2 = pnModAPIFunc('iw_books', 'user', 'nivells');
	$output->TableColStart();
	$output->Text(__('Level:', $dom));
	$output->FormSelectMultiple('nivell', $data2);
	$output->TableColEnd();
	$output->TableRowEnd();

	$data3 = pnModAPIFunc('iw_books', 'user', 'materies');
	$output->TableRowStart();
	$output->TableColStart();
	$output->Text(__('Subject:', $dom));
	$output->FormSelectMultiple('materia', $data3);
	$output->TableColEnd();

	$output->TableColStart();
	$output->Text(__('Reads:', $dom));
	$output->FormCheckbox('lectura', $checked=false, $value='1');
	$output->TableColEnd();
	$output->TableRowStart();
	$output->TableColStart();
	$output->Linebreak(2);
	$output->FormSubmit(__('See list of books', $dom));
	$output->TableColEnd();

	$output->TableColStart();
	$output->Linebreak(2);
	$output->Text('<input type="submit" value="'. __('Creating listed on page PDF', $dom).'" name="pdf" tabindex="7" />');
	$output->TableColEnd();
	$output->TableRowEnd();

	$output->FormEnd();

	$output->SetOutputMode(_PNH_KEEPOUTPUT);
	$output->SetInputMode(_PNH_VERBATIMINPUT);

	$output->SetInputMode(_PNH_PARSEINPUT);
	$output->TableEnd();


	return $output->GetOutput();
}

/**
 * generate menu fragment
 */
function iw_books_usermenu1()
{
    $dom = ZLanguage::getModuleDomain('iw_books');
	$output =& new pnHTML();

	// Start options menu
	$output->Text(pnGetStatusMsg());
	$output->Linebreak(2);
	$output->SetInputMode(_PNH_VERBATIMINPUT);
	$output->Text('<h1>'.__('Textbooks and lectures', $dom).'</h1>');

	$output->TableStart();
	$output->TableEnd();
	$output->Linebreak(1);
	$output->URL(pnVarPrepForDisplay(pnModURL('iw_books','user','main')),__('Back', $dom));
	$output->Linebreak(2);

	return $output->GetOutput();
}

/**
 * Get a file from a server folder even it is out of the public html directory
 * @author:     Albert Pérez Monfort (aperezm@xtec.cat)
 * @param:	name of the file that have to be gotten
 * @return:	The file information
 */
function iw_books_user_getFile($args)
{
    $dom = ZLanguage::getModuleDomain('iw_books');
	// File name with the path
	$fileName = FormUtil::getPassedValue('fileName', isset($args['fileName']) ? $args['fileName'] : 0, 'GET');

	// Security check
	if (!SecurityUtil::checkPermission('iw_books::', "::", ACCESS_READ)) {
		return LogUtil::registerError(__('Sorry! No authorization to access this module.', $dom), 403);
	}
	$sv = pnModFunc('iw_main', 'user', 'genSecurityValue');
	return pnModFunc('iw_main', 'user', 'getFile', array('fileName' => $fileName,
								'sv' => $sv));
}


function generapdf($args)
{
    $dom = ZLanguage::getModuleDomain('iw_books');
	require_once(pnModGetVar('iw_books', 'fpdf').'fpdf.php');

	$any     = FormUtil::getPassedValue ('curs');
	$etapa   = FormUtil::getPassedValue ('etapa');
	$materia = FormUtil::getPassedValue ('materia');
	$nivell  = FormUtil::getPassedValue ('nivell');
	$lectura = FormUtil::getPassedValue ('lectura');
	
	//    $dir = "modules/iw_books/tmp/";
	$dir = pnModGetVar('iw_main', 'documentRoot')."/".pnModGetVar('iw_main', 'tempFolder')."/";
	// Netegem els fitxers temporals amb X segons d'antiguitat
	NetejaFitxers($dir);

	$file = $dir."tmp".date('h'.'m'.'s'.'d').".pdf";

	extract($args);
	
	$cursacad    = pnModAPIFunc('iw_books', 'user', 'cursacad', array('any' => $any));
	$nivell_abre = pnModAPIFunc('iw_books', 'user', 'reble', array('nivell' => $nivell));

	$items = pnModAPIFunc('iw_books',
                          'user',
                          'getall',
	array('startnum' => $startnum,
                                'any'      => $any,
                                'etapa'    => $etapa,
                                'nivell'   => $nivell,
                                'text'     => $text,
                                'lectura'  => $lectura,
                                'materia'  => $materia,
                                'flag'     => 'user',
                                'numitems' => 1000));

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();

	// Definir marges: esquerra i superior
	$marge_esq = 16;
	$marge_sup = 20;
	$pdf->SetMargins($marge_esq, $marge_sup);
	//  $pdf->SetMargins(25,20);
	$pdf->AddPage();


	$alt       = pnModGetVar('iw_books', 'mida_font')/2; //5;
	$salt      = pnModGetVar('iw_books', 'mida_font')/2; //5;
	$fita_lect = 0;   // marca de t�tol llibres de lectura
	$fita_opt  = 0;   // marca de t�tol llibres d'optativa
	$fita_mat  = 0;   // marca de t�tol de materisls


	$llis_mat  =  pnModGetVar('iw_books', 'llistar_materials');
	$mida_font =  pnModGetVar('iw_books', 'mida_font');
	$mida_font_tit = $mida_font+1;

	if (count($items) == 0){
		$pdf->Write($alt,utf8_decode(__('There aren\'t books for your selection', $dom)));// No hi ha llibres amb l'opció sol·licitada
		$pdf->Output($file);
		pnRedirect(pnModFunc('iw_books', 'user', 'getFile', array('fileName' => str_replace(pnModGetVar('iw_main', 'documentRoot')."/",'',$file))));
		return $file;
	}

	$mostra_pla = pnModAPIFunc('iw_books', 'user', 'descriplans', array('etapa' => $etapa));

	$pdf->SetFont('Arial','B', 14);
	//        "Llistat de llibres"
	$pdf->MultiCell(0,7,utf8_decode(__('List of books · Course', $dom).$cursacad." · ".$nivell_abre." ".$mostra_pla),1,'C',0);

	$pdf->Ln($salt-1);
	$pdf->SetFont('Arial','BU', $mida_font_tit);
	$pdf->Write($alt, utf8_decode(__('Textbooks', $dom)));
	$pdf->Ln($salt+1);
	
	foreach ($items as $item) {
		if( $item[lectura] == 1 and $fita_lect != 1){
			$fita_lect = 1;
			$pdf->SetFont('Arial','BU',$mida_font_tit);
			$pdf->Ln($salt-1);
			$pdf->Write($alt, utf8_decode(__('Reading Books', $dom)));
			$pdf->Ln($salt+1);
		}

		if( $item[optativa] == 1 and $fita_opt != 1){
			$fita_lect = 0;
			$fita_opt  = 1;
			$pdf->SetFont('Arial','BU',12);
			$pdf->Ln($salt+3);
			$pdf->SetFont('Arial','B', $mida_font_tit);
			$pdf->MultiCell(0,$alt+1,utf8_decode(__('Optional subjects', $dom)),1,'C',0);
			$pdf->Ln(2);
			$pdf->SetFont('Arial','I',$mida_font_tit-1);
			$pdf->Write($alt, utf8_decode("ATENCIÓ: Només per a l'alumnat que triï aquestes matèries"));
			$pdf->SetFont('Arial','BU', $mida_font_tit);
			$pdf->Ln($salt+2);

			if ($item[lectura] == 1){
				$fita_lect = 1;
				$pdf->Write($alt, utf8_decode(__('Reading Books', $dom)));
				$pdf->Ln($salt+1);
			}else{
				$pdf->Write($alt, utf8_decode(__('Textbooks', $dom)));
				$pdf->Ln($salt+1);
			}
		}

		if ($item['optativa'] == 1)
		$optativa = '**' ;

		$nommateria = utf8_decode(pnModAPIFunc('iw_books', 'user', 'nommateria', array('codi_mat' => $item['codi_mat'])));

		if ( substr($item['codi_mat'],0, 2) != "AA"){

			$pdf->SetFont('Arial','',$mida_font);

			$pdf->Write($alt, chr(149)." ".$optativa." ".$nommateria." -  ");

			$m_autor = "";
			if ($item[autor] != "")
			$m_autor = utf8_decode($item[autor]).", ";

			$pdf->Write($alt, $m_autor);
			$pdf->SetFont('Arial','I',$mida_font);
			$pdf->Write($alt, utf8_decode($item[titol]));
			$pdf->SetFont('Arial','',$mida_font);
			$m_aval = '';

			if( $item[avaluacio] != "")
			$m_aval = ", (".$item[avaluacio]. utf8_decode(__('to avaluation', $dom)).")";

			$m_publi = "";
			if( $item[any_publi] != "")
			$m_publi = ", ".$item[any_publi];

			$m_isbn = "";
			if($item[isbn] != "")
			$m_isbn = ", (ISBN: ". $item[isbn].")";

			$pdf->Write($alt,", ". utf8_decode($item[editorial]).$m_publi.$m_aval.$m_isbn);


			$m_obs = "";
			if($item[observacions] != "")
			$m_obs = " -- (". utf8_decode($item[observacions]).")";

			$pdf->SetFont('Arial','I',$mida_font);
			$pdf->Write($alt,$m_obs);

			$pdf->Ln($salt);

		}

		// Omplim array amb els materials, per imprimir-los despr�s
		if ( $item[materials] != ""){
			$amaterials[] = array( 'nom_mat'   => $nommateria,
                                    'materials' => $item[materials],
                                    'etapa'     => $item[etapa],
                                    'optativa'  => $optativa);
		}

	}


	// Llistem materials
	foreach($amaterials as $row){
		if ($llis_mat == "1"){
			if( $llis_mat == 1 and $fita_mat != 1){
				$fita_mat = 1;
				$pdf->SetFont('Arial','B',$mida_font_tit);
				$pdf->Ln($salt+2);
				$pdf->MultiCell(0,$alt+1, utf8_decode(__('Materials', $dom)),1,'C',0);
				$pdf->Ln($salt);
			}

			$pdf->SetFont('Arial','B',$mida_font);
			$pdf->Write($alt, chr(149)." ".$row[optativa]." ".$row[nom_mat]);
			$pdf->Ln($salt);
			$pdf->SetFont('Arial','',$mida_font);
			$posicio = $pdf->GetX();
			$pdf->SetX($posicio+8);
			$pdf->Multicell(0,$alt,utf8_decode($row[materials]));
			$pdf->SetX($posicio);
			$pdf->Ln($salt-2);
		}
	}

	$pdf->Output($file);
	$pdf->Output();

	pnRedirect(pnModFunc('iw_books', 'user', 'getFile', array('fileName' => str_replace(pnModGetVar('iw_main', 'documentRoot')."/",'',$file))));

	return $file;
}

?>
