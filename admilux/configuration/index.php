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
##                      modifié avec l'aide de TRUGEON Nicolas                ##
##   This program is free software. You can redistribute it and/or modify     ##
##   it under the terms of the GNU General Public License as published by     ##
##   the Free Software Foundation.                                            ##
################################################################################

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

titre_page("Configuration générale");

if (isset($_GET['sous_titre'])) $selection=$_GET['sous_titre'];
else $selection="non";
echo"<table><tr>";
if ($selection=="accueil") sous_titre("<font size=\"1\">La page d'accueil du site</font>","selection");
else sous_titre("<font size=\"1\">La page d'accueil du site</font>","admi.php?page_admi=config&sous_titre=accueil");
if ($selection=="design") sous_titre("<font size=\"1\">Le design du site</font>","selection");
else sous_titre("<font size=\"1\">Le design du site</font>","admi.php?page_admi=config&sous_titre=design");
if ($selection=="restriction") sous_titre("<font size=\"1\">Restriction</font>","selection");
else sous_titre("<font size=\"1\">Restriction</font>","admi.php?page_admi=config&sous_titre=restriction");
if ($selection=="compteur") sous_titre("<font size=\"1\">Le compteur</font>","selection");
else sous_titre("<font size=\"1\">Le compteur</font>","admi.php?page_admi=config&sous_titre=compteur");
if ($selection=="passe") sous_titre("<font size=\"1\">Mot de passe du professeur</font>","selection");
else sous_titre("<font size=\"1\">Mot de passe du professeur</font>","admi.php?page_admi=config&sous_titre=passe");
if ($selection=="lire") sous_titre("<font size=\"1\">A lire ...</font>","selection");
else sous_titre("<font size=\"1\">A lire ...</font>","admi.php?page_admi=config&sous_titre=lire");

echo"</tr></table>";

switch ($selection) 
{
case "accueil": include( "admilux/configuration/page_accueil.php") ; break;
case "design": include( "admilux/configuration/design.php") ; break;
case "passe": include( "admilux/configuration/modifier_mdp.php") ; break;
case "compteur": include( "admilux/configuration/compteur.php") ; break;
case "restriction": include( "admilux/configuration/restriction_rubrique.php") ; break;
case "lire": include( "admilux/configuration/lire.php") ; break;
}

?>