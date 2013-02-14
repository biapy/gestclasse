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
include("../../commun/texte.php"); 
include("graphique_impression.php"); 
?>
<link href="../../commun/style.css" rel="stylesheet" type="text/css">
<?


//protection de la page

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

if (isset($_GET['page_admi']))
{
switch ($_GET['page_admi']) 
{
case "notes_tableau": include( "notes_tableau.php") ; break;
case "devoir": include( "devoir.php") ; break;
case "classe": include( "classe.php") ; break;
case "notes_ligne": include( "notes_ligne.php") ; break;
case "admicarnet": include( "carnet.php") ; break;
}
}
?>
