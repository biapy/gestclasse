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

//test pour vérifier la connexion
$nb_tbl="0";
if((mysql_select_db($dbname,$id_link))) 
{
$tables = mysql_list_tables ($dbname);
while($rang=mysql_fetch_array($tables))
{
if (substr($rang['0'],0,3)=="gc_") $nb_tbl++ ;
}
}

if(!(mysql_select_db($dbname,$id_link)) or $nb_tbl<>"17") 
{
echo "<div align=\"left\"><img src=\"images/config/logogestclasse.gif\"></div><p align=\"center\"><font size=\"6\" face=\"Arial, Helvetica, sans-serif\">Echec de 
  connexion &agrave; la base de donn&eacute;es</font></p>
  ";
  echo"
<p><font face=\"Arial, Helvetica, sans-serif\"><a href=\"installation/\">Consultez 
  le fichier d'installation du programme</a></font></p>

  <p><font face=\"Arial, Helvetica, sans-serif\"><a href=\"presentation.htm\">Consultez 
  le fichier de présentation</a> 
  </font></p>
  ";
  exit;
}
 

?>