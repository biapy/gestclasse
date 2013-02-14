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

titre_page("Cahier de texte de $_GET[classe]");

echo " <div><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" ><a href=\"index.php?page=cahier_texte_archive&classe=$_GET[classe]\">Voir 
les archives</a></font></div><br>";

//affichage des jours 
$sql1="select  *  FROM gc_cahier_texte where (classe='$_GET[classe]' and type='jour' and archive='0') ORDER BY id_jour DESC";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_com_classe=$rang1['id_com_classe'];	
$jour=$rang1['jour'];
echo "<a name=\"$id_com_classe\"></a><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"200\">";
titre_division($jour);
echo "</td></tr></table>";
include('admilux/cahier_texte/com_classe_archive.php');

}

?>




