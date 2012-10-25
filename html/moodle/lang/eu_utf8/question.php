<?PHP // $Id: question.php,v 1.10 2009/12/14 09:20:37 mudrd8mz Exp $ 
      // question.php - created with Moodle 1.9.4+ (Build: 20090218) (2007101541)


$string['adminreport'] = 'Zure galderen datu-basean izan daitezkeen arazoei buruzko txostena';
$string['availableq'] = 'Eskuragarri?';
$string['broken'] = 'Etendako esteka da hau: ez dagoen fitxategi batera eramaten du';
$string['byandon'] = '<em>$a->user</em>-ek <em>$a->time</em>(et)an';
$string['cannotcreate'] = 'Ezin da beste sarrera bat soryi hemen: question_attempts table';
$string['cannotcreatepath'] = 'Ezin da bidea sortu: $a';
$string['cannotdeletecate'] = 'Ezin duzu kategoria hau ezabatu testuinguru honetako berezko kategoria bada.';
$string['cannotfindcate'] = 'Ezin da kategoriaren erregistroa aurkitu';
$string['cannotinsertquestion'] = 'Ezin da beste galdera bat txertatu!';
$string['cannotloadquestion'] = 'Ezin da galdera kargatu';
$string['cannotopenforwriting'] = 'Ezin da idazteko zabaldu: $a';
$string['cannotpreview'] = 'Ezin dituzu galdera hauek aurreikusi';
$string['cannotunzip'] = 'Ezin da fitxategia deskonprimatu.';
$string['categorycurrent'] = 'Oraingo kategoria';
$string['categorycurrentuse'] = 'Erabili kategoria hau';
$string['categorydoesnotexist'] = 'Ez da kategoria hau existitzen';
$string['categorymoveto'] = 'Gorde kategorian';
$string['changepublishstatuscat'] = '<a href=\"$a->caturl\"> \"$a->name\"</a> kategoriak, \"$a->coursename\" ikastarokoa, bere <strong>$a->changefrom truke egoera beste honetara aldatuko du $a->changeto</strong>.';
$string['chooseqtypetoadd'] = 'Aukeratu gehitu nahi duzun galdera-mota';
$string['copy'] = 'Kopiatu $a-tik eta aldatu estekak.';
$string['created'] = 'Sortuta';
$string['createdby'] = 'Nork sortua';
$string['createdmodifiedheader'] = 'Sortutako edo gordetako azkena';
$string['createnewquestion'] = 'Sortu beste galdera bat...';
$string['cwrqpfs'] = 'Ausazko galderak, azpikategorietako galderak aukeratuta';
$string['cwrqpfsinfo'] = 'Moodle 1.9ra eguneratu bitartean, galdera-kategoriak hainbat testuingurutan banatuko ditugu. Zure guneko hainbat kategoriak eta galderak aldatu egingo dute truke egoera. Beharrezkoa da hau partekatutako eta ez partekatutako kategoria nahasketa batetik aukeratzen direnean galdera bat edo gehiago, (gune honetan gertatzen den bezala). Hau gertatzen da ausazko galdera bat azpikategorietatik aukeratzeko ezartzen denean eta azpikategoria bat edo gehiagok ausazko galdera sortuko den jatorrizko kategoriak ez bezalako truke egoera dutenean.
Ondorengo kategoriek, zeinetatik aukeratzen dituzten goragoko kategoriek ausazko galderak, Moodle 1.9rako eguneraketan aldatu egingo dute beren truke-egoera ausazko galdera duen kategoriaren egoera berera. Ondoren agertzen diren kategoriek aldatuta izango dute truke egoera. Eragina izan duten galderek funtzionatu egingo dute dauden galdetegi guztietan ahalik eta galdetegi horiek ezabatu arte.';
$string['cwrqpfsnoprob'] = 'Ez dago zure gunean \'Ausazko galderak galderak azpikategorietatik aukeratuta\' aukeraren eraginpeko kategoriarik';
$string['defaultfor'] = '$a-ren berezko balioa';
$string['defaultinfofor'] = '\'$a\' testuinguruan partekatutako galderetarako berezko kategoria.';
$string['deletecoursecategorywithquestions'] = 'Galdera-banku honetan badira ikastaro-kategoria honekin lotutako hainbat galdera. jarraituz gero, ezabatu egingo dira. Nahi baduzu, lehenik mugitu ahal dituzu galdera-bankuaren interfazetik.';
$string['disabled'] = 'Desgaituta';
$string['donothing'] = 'Ez kopiatu, ez mugitu fitxategirik eta ez aldatu estekarik.';
$string['editingcategory'] = 'Kategoria editatzen';
$string['editingquestion'] = 'Galdera editatzen';
$string['editthiscategory'] = 'Kategoria hau editatzen';
$string['emptyxml'] = 'Errore ezezaguna - imsmanifest.xml hutsik dago';
$string['enabled'] = 'Gaituta';
$string['erroraccessingcontext'] = 'Ezin da testuingurura iritsi';
$string['errordeletingquestionsfromcategory'] = 'Errorea gertatu da $a kategoriatik galderak ezabatzean.';
$string['errorduringpost'] = 'Errorea gertatu da prozesaketa-ostean!';
$string['errorduringpre'] = 'Errorea gertatu da aure-prozesaketan!';
$string['errorduringproc'] = 'Errorea gertatu da prozesaketan!';
$string['errorfilecannotbecopied'] = 'Errorea: ezin da $a fitxategia kopiatu.';
$string['errorfilecannotbemoved'] = 'Errorea: ezin da $a fitxategia mugitu.';
$string['errorfileschanged'] = 'Galderetatik estekatutako errore-fitxategiak aldatu egin dira formularioa erakutsi denetik';
$string['errormanualgradeoutofrange'] = '$a->grade kalifikazioa ez da 0 eta $a->maxgrade-ren artekoa $a->name (-)en galderarako. Puntuazioa eta iruzkina ez dira gorde.';
$string['errormovingquestions'] = 'Errorea $a ID-ak dituzten galderak mugitzean.';
$string['errorpostprocess'] = 'Errorea gertatu da prozesaketa-ostean!';
$string['errorpreprocess'] = 'Errorea gertatu da aurre-prozesaketan!';
$string['errorprocess'] = 'Errorea gertatu da prozesaketan!';
$string['errorprocessingresponses'] = 'Errorea gertatu da zure ebazpenak prozesatzean.';
$string['errorsavingcomment'] = 'Eorrea datu-basean $a->name galderaren iruzkina gordetzean.';
$string['errorupdatingattempt'] = 'Eorrea datu-basean $a->id saiakera eguneratzean.';
$string['exportcategory'] = 'Esportatu kategoria';
$string['exporterror'] = 'Erroreak gertatu dira esportatzean';
$string['filesareacourse'] = 'ikastaroaren fitxategi-eremua';
$string['filesareasite'] = 'gunearen fitxategi-eremua';
$string['filestomove'] = 'Fitxategiak $a-ra mugitu/kopiatu?';
$string['flagged'] = 'Markatuta';
$string['flagthisquestion'] = 'Markatu galdera hau';
$string['fractionsnomax'] = 'Erantzunetako batek %%100 izan behar du galdera honetako gehienezko puntuazioa lortu ahal izateko.';
$string['getcategoryfromfile'] = 'Kategoria fitxategitik lortu';
$string['getcontextfromfile'] = 'Testuingurua fitxategitik lortu';
$string['ignorebroken'] = 'Apurtutako estekei jaramonik ez egin';
$string['invalidcontextinhasanyquestions'] = 'Testuinguru baliogabea hona pasa da: question_context_has_any_questions.';
$string['linkedfiledoesntexist'] = 'Ez dago $a lotutako fitxategia';
$string['makechildof'] = 'Bihurtu $a-ren ondorengo';
$string['maketoplevelitem'] = 'Igo ondorengo mailara';
$string['missingimportantcode'] = 'Galdera-mota honek kode garrantzitsu bat falta du: $a.';
$string['modified'] = 'Gordetako azkena';
$string['move'] = 'Mugitu $a-tik eta aldatu estekak';
$string['movecategory'] = 'Mugitu kategoria';
$string['movedquestionsandcategories'] = 'Galderak eta galdera-kategoriak mugituta $a->oldplace -(t)ik $a->newplace -(r)a.';
$string['movelinksonly'] = 'Esteken helmuga bakarrik aldatu, fitxategiak ez mugitu eta ez kopiatu.';
$string['moveq'] = 'Mugitu galdera(k)';
$string['moveqtoanothercontext'] = 'Mugitu galdera beste testuinguru batera';
$string['movingcategory'] = 'Kategoria mugitzen';
$string['movingcategoryandfiles'] = 'Ziur al zaude {$a->name} eta bere azpiko kategoria guztiak \"{$a->contextto}\" testuingurura aldatu nahi dituzula?<br />Galderetatik lotutako {$a->urlcount} fitxategi aurkitu dugu {$a->fromareaname}-n, kopiatu edo {$a->toareaname}-ra mugitu nahi al dituzu?';
$string['movingcategorynofiles'] = 'Ziur al zaude \"{$a->name}\" kategoria eta bere azpiko kategoria guztiak \"{$a->contextto}\" testuingurura mugitu nahi dituzula?';
$string['movingquestions'] = 'Galderak eta hainbat fitxategi mugitzen';
$string['movingquestionsandfiles'] = 'Ziur al zaude {$a->questions} galdera(k) <strong>\"{$a->tocontext}\"</strong> kontestura mugitu nahi d(it)uzula?<br /> Galdera hauetatik/honetatik lotutako <strong>{$a->urlcount} fitxategi</strong> aurkitu dugu{$a->fromareaname}-n, kopiatu edo {$a->toareaname}-ra mugitu nahi al dituzu?';
$string['movingquestionsnofiles'] = 'Ziur al zaude {$a->questions} galdera(k) <strong>\"{$a->tocontext}\"</strong> kontestura mugitu nahi d(it)uzula?<br /> Ez dago galdera hauetatik/honetatik lotutako <strong>inongo fitxategirik</strong> {$a->fromareaname}-n.';
$string['needtochoosecat'] = 'Galdera hau mugitzeko kategoria bat aukeratu behar duzu; bestela, sakatu \'utzi\'.';
$string['nopermissionadd'] = 'Ez duzu baimenik hemen galderarik gaineratzeko.';
$string['nopermissionmove'] = 'Ez duzu baimenik galderak hemendik mugitzeko. Galdera kategoria honetan gorde behar duzu edo galdera berri gisa gorde.';
$string['noprobs'] = 'Zure galderen datu-basean ez da arazorik aurkitu.';
$string['notenoughdatatoeditaquestion'] = 'Ez da galderaren, kategoriaren eta galdera-motaren id-a zehaztu.';
$string['notenoughdatatomovequestions'] = 'Mugitu nahi dituzun galderen ida-ak eman behar dituzu.';
$string['notflagged'] = 'Markatu gabea';
$string['permissionedit'] = 'Editatu galdera hau';
$string['permissionmove'] = 'Mugitu galdera hau';
$string['permissionsaveasnew'] = 'Gorde hau galdera berri gisa';
$string['permissionto'] = 'Honetarako baimena duzu:';
$string['published'] = 'Argitaratuta';
$string['questionaffected'] = '<a href=\"$a->qurl\">Ondoko galdera \"$a->name\" ($a->qtype)</a> kategoria honetan dago baina <a href=\"$a->qurl\">galdetegi honetan ere erabilita dago \"$a->quizname\"</a> beste ikastaro batean: \"$a->coursename\".';
$string['questionbank'] = 'Galdera-bankua';
$string['questioncategory'] = 'Galdera-kategoria';
$string['questioncatsfor'] = 'Galdera-kategoriak \'$a\'-rako';
$string['questiondoesnotexist'] = 'Ez dago galdera hau';
$string['questionname'] = 'Galderaren izena';
$string['questionsaveerror'] = 'Erroreak gertatu dira galdera gordetzean - ($a)';
$string['questionsmovedto'] = 'Oraindik erabiltzen ari diren galderak  \'$a\'-ra mugitzen goragoko ikastaro-kategorian.';
$string['questionsrescuedfrom'] = 'Galderak gordeta $a testuingurutik';
$string['questionsrescuedfrominfo'] = 'Galdera hauek (batzuk ezkutuan egon daitezke) gorde egin ziren $a testuingurua ezabatu zenean, oraindik ere hainbat galdetegitan edo bestelako jardueratan erabili egiten direlako.';
$string['questiontype'] = 'Galdera-mota';
$string['questionuse'] = 'Erabili galdera jarduera honetan';
$string['selectacategory'] = 'Aukeratu kategoria bat:';
$string['selectaqtypefordescription'] = 'Aukeratu galdera-mota bat deskribapena ikusteko.';
$string['shareincontext'] = 'Partekatu $arentzat testuinguruan.';
$string['tofilecategory'] = 'Fitxategiari kategoria idatzi';
$string['tofilecontext'] = 'Fitxategiari testuingurua idatzi';
$string['unknown'] = 'Ezezaguna';
$string['unknownquestiontype'] = 'Galdera-mota ezezaguna: $a.';
$string['unpublished'] = 'Argitaratu gabe';
$string['upgradeproblemcategoryloop'] = 'Galdera-kategoriak eguneratzean arazo bat atzeman da. Kategoria-zuhaitzean begizta (loop) bat dago. Horren eraginpeko kategorien ID-ak ??? dira.';
$string['upgradeproblemcouldnotupdatecategory'] = 'Ezin da ondoko galdera-kategoria eguneratu: $a->name ($a->id).';
$string['upgradeproblemunknowncategory'] = 'Arazoa atzemena da galdera-kategoriak eguneratzean. $a->id kategoria  $a->parent goragoko kategoriari dagokio eta ez da existitzen. Arazoa konpontzeko, goragoko kategoria aldatu egin da.';
$string['yourfileshoulddownload'] = 'Esportatzeko fitxategiak berehala hasi beha luke jaisten. Horrela gertatu ezean, mesedez, <a href=\"$a\">egin klik hemen</a>.';
$string['cannotinsertquestioncate'] = 'Ezin da beste galdera-kategoria bat txertatu: $a'; // ORPHANED
$string['cannotmovecate'] = 'Ezin da $a kategoria mugitu, azkena da testuinguru honetan.'; // ORPHANED
$string['cannotmovefromto'] = 'Ezin da $a[0] kategoria $a[1]ra mugitu'; // ORPHANED
$string['cannotsavequiz'] = 'Oraingo saiakera ez da ondo gorde!'; // ORPHANED
$string['cannotupdatecate'] = 'Ezin da $a kategoria eguneratu'; // ORPHANED
$string['cannotupdatequestion'] = 'Ezin da galdera eguneratu!'; // ORPHANED
$string['cannotupdaterandomqname'] = 'Ezin da ausazko galderaren izena eguneratu'; // ORPHANED
$string['cannotupdatesubcate'] = 'Ezin da beheragoko kategoria eguneratu!'; // ORPHANED

?>