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


// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

$sql="alter TABLE gc_agenda ORDER BY id_agenda";
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_bloc_notes ORDER BY id_bloc";
mysql_db_query($dbname,$sql,$id_link); 
$sql="alter TABLE gc_cahier_texte ORDER BY id_com_classe"; 
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_classe ORDER BY id_classe";
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_connexion ORDER BY id_connexion";
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_contenu_auto ORDER BY id_auto";
mysql_db_query($dbname,$sql,$id_link); 
$sql="alter TABLE gc_contenu_page ORDER BY id_contenu";
mysql_db_query($dbname,$sql,$id_link); 
$sql="alter TABLE gc_devoir ORDER BY id_devoir"; 
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_division_page ORDER BY id_division";
mysql_db_query($dbname,$sql,$id_link); 
$sql="alter TABLE gc_eleve ORDER BY id_eleve"; 
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_lien ORDER BY id_lien"; 
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_modification ORDER BY id_modification";
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_notes ORDER BY id_notes";
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_page ORDER BY id_page";
mysql_db_query($dbname,$sql,$id_link);
$sql="alter TABLE gc_vacances ORDER BY id_vacances"; 
mysql_db_query($dbname,$sql,$id_link);
?>