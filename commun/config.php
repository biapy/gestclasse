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

$sql="select  *  FROM gc_config";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$mail=$rang['mail'];
$maj=$rang['maj'];
$contenu=$rang['contenu'];
$gauche=$rang['gauche'];
$droite=$rang['droite'];
$bas_page=$rang['bas_page'];
$couleur1=$rang['couleur1'];
$couleur2=$rang['couleur2'];
$couleur3=$rang['couleur3'];
$couleur4=$rang['couleur4'];
$couleur5=$rang['couleur5'];
$couleur6=$rang['couleur6'];
$couleur7=$rang['couleur7'];
$couleur8=$rang['couleur8'];
$fond=$rang['fond'];
$fond_haut_page=$rang['fond_haut_page'];

?>