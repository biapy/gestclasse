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

//c'est la page de l'élève

//protection de la page
if (!isset($_SESSION['login']) or !isset($_SESSION['passe']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

if (!isset($_GET['eleve_lien'])) $_GET['eleve_lien']='accueil';

switch ($_GET['eleve_lien']) 
{
case "information": include("admilux/page/site/eleve/information.php") ; break;
case "notes": include ("admilux/page/site/eleve/notes.php") ; break;
case "trombi": include("admilux/page/site/eleve/trombi.php") ; break;


default : include( "admilux/page/site/eleve/accueil.php") ; break;
}

?>
