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

session_start();
include("../../commun/connect.php");
include("../../commun/config.php");
include("../../commun/fonction.php"); 
?>
<link href="../../commun/style.css" rel="stylesheet" type="text/css">
<?

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


if ( isset($_GET['voir']))
{


//affichage des jours 
$impression='ok';
$sql1="select  *  FROM gc_cahier_texte where (classe='$_GET[classe]' and type='jour' and archive='1' and id_jour>='$_GET[voir]' ) ORDER BY id_com_classe";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_com_classe=$rang1['id_com_classe'];	
$jour=$rang1['jour'];
echo "<hr><font color=\"#000099\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../images/config/lien.gif\"  align=\"absmiddle\">$jour</font>";
include('com_classe_archive.php');
}
}
?>

