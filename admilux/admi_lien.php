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

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

if (!isset($_GET['page_admi'])) $_GET['page_admi']='accueil';

switch ($_GET['page_admi']) {
// page d'accueil de la rubrique d'administration
case "accueil": include( "admilux/accueil.php") ; break;

// gestion du site 
case "config": include( "admilux/configuration/index.php") ; break;
case "lien": include( "admilux/page/lien.php") ; break;
case "plan": include( "admilux/page/plan.php") ; break;
case "page": include( "admilux/page/page.php") ; break;
case "agenda": include( "admilux/agenda/agenda.php") ; break;
case "sauvegarde": include( "admilux/tables/sauvegarder.php") ; break;
case "restaurer": include( "admilux/tables/restaurer.php") ; break;
case "vider": include( "admilux/tables/vider.php") ; break;



//gestion des classes et des élèves

case "admiajout_classe": include( "admilux/ajout/classe.php") ; break;
case "admiajout": include( "admilux/ajout/eleve.php") ; break;
case "trombi": include( "admilux/trombi/trombi.php") ; break;
case "connexion": include( "session/dernieres_connexion.php") ; break;

//gestion des fiches
case "les_fiches": include( "admilux/fiches/les_fiches.php") ; break;
case "modification": include( "admilux/fiches/modification.php") ; break;

//gestion des messages
case "admi_message": include( "admilux/ajout/message.php") ; break;

//gestion du cahier de texte
case "cahier_texte": include( "admilux/cahier_texte/cahier_texte.php") ; break;
case "archive": include( "admilux/cahier_texte/archive.php") ; break;

//gestion des notes
case "admicarnet": include( "admilux/carnet/carnet.php") ; break;
case "devoir": include( "admilux/carnet/devoir.php") ; break;
case "classe": include( "admilux/carnet/classe.php") ; break;
case "notes_ligne": include( "admilux/carnet/notes_ligne.php") ; break;
case "notes_tableau": include( "admilux/carnet/notes_tableau.php") ; break;
case "adminouveau_dev": include( "admilux/carnet/nouveau_dev.php") ; break;
case "modif_dev": include( "admilux/carnet/modifier_devoir.php") ; break;


default : include( "admilux/accueil.php") ; break;
}



?>
