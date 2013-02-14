<? 
################################################################################
##                      -=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-                    ##
##                               Gest'classe_v7_plus                          ##                               
##             Logiciel (php/Mysql)  destiné aux enseignants                  ##
##                      -=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-                    ##
##                                                                            ##
## -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-    ##
##                                                                            ##
##     Copyright (c) 2003-2008 by Lux Pierre (luxpierre@hotmail.com)          ##
##                          http://gestclasse.free.fr                         ##
##                                                                            ##
##   This program is free software. You can redistribute it and/or modify     ##
##   it under the terms of the GNU General Public License as published by     ##
##   the Free Software Foundation.                                            ##
################################################################################

// pour l'impression
if (isset($impression)) $imp='';
else $imp='admilux/cahier_texte/';
			
//affichage des commentaires pour la classe
$sql="select  *  FROM gc_cahier_texte where jour='$id_com_classe' ORDER BY id_com_classe";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
			{
			$id_com_classe=$rang['id_com_classe'];	
			$commentaire=style($rang['commentaire']);
			$type=$rang['type'];
			$pour=$rang['pour'];
			echo"<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">";
			echo"<tr><td valign=\"top\">";
			echo"<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >";
			switch ($type)
			{
			case "aucun": echo "&nbsp; &nbsp; &nbsp; $commentaire" ; break;
			case "ds": echo "<img src=\"".$imp."image/ds.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "dm": echo "<img src=\"".$imp."image/dm.gif\" align=\"absmiddle\"> pour $pour : $commentaire" ; break;
			case "correction": echo "<img src=\"".$imp."image/correction.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "int": echo "<img src=\"".$imp."image/int.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "attention": echo "<img src=\"".$imp."image/attention.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "note": echo "<img src=\"".$imp."image/note.gif\" align=\"absmiddle\"> &nbsp;$commentaire" ; break;
			case "faire": echo "<img src=\"".$imp."image/afaire.gif\" align=\"absmiddle\"> pour $pour : $commentaire" ; break;
			case "chapitre": echo "<font size=\"3\" face=\"Arial, Helvetica, sans-serif\" color=\"#FF0000\"> $commentaire</font>" ; break;
			case "sous_titre": echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\" color=\"#006600\"> $commentaire</font>" ; break;
			case "devoir_venir": echo "<img src=\"".$imp."image/devoir_venir.gif\" align=\"absmiddle\">  $pour : $commentaire" ; break;
			case "tp": echo "<img src=\"".$imp."image/tp.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "td": echo "<img src=\"".$imp."image/td.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "activite": echo "<img src=\"".$imp."image/activite.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			case "classe_entiere": echo "<img src=\"".$imp."image/classe_entiere.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			case "groupe": echo "<img src=\"".$imp."image/groupe.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			}	
			echo"</font></td></tr></table>";	
}	

?>


