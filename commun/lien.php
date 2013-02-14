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
if (!isset($_GET['page'])) $_GET['page']='accueil';

switch ($_GET['page']) 
{
case "cahier_texte": include( "admilux/cahier_texte/cahier_texte_eleve.php") ; break;
case "cahier_texte_archive": include( "admilux/cahier_texte/cahier_texte_archive_eleve.php") ; break;
case "deconnexion": include( "session/deconnexion.php") ; break;

case "plan": include( "admilux/page/site/plan.php") ; break;
case "lien": include( "admilux/page/site/lien.php") ; break;
case "page": include( "admilux/page/site/page.php") ; break;
case "agenda": include( "admilux/agenda/agenda_site.php") ; break;


//rubrique eleve
case "passe": include( "session/passe.php") ; break;
case "eleveok": include( "admilux/page/site/eleve/index.php") ; break;

default : include( "admilux/page/site/accueil.php") ; break;
}

?>