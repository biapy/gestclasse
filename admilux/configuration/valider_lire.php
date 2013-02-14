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

//ajouter
if (isset($_GET['aj']) and  $_GET['aj']=='ok')
{
	
	$fichier = "commun/texte.php";
	$ecrire="<?\nfunction  texte(\$texte)\n{\n\$texte=addslashes(\$texte);\nreturn \$texte;\n}\n?>"; 
	$fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero 
	if (!$fp) { echo "Impossible d'ouvrir $fichier en ecriture"; exit; } 
  	fputs($fp, $ecrire); fclose($fp); 
}

//ne pas ajouter
if (isset($_GET['naj']) and  $_GET['naj']=='ok')
{
	
	$fichier = "commun/texte.php";
	$ecrire="<?\nfunction  texte(\$texte)\n{\nreturn \$texte;\n}\n?>"; 
	$fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero 
	if (!$fp) { echo "Impossible d'ouvrir $fichier en ecriture"; exit; } 
  	fputs($fp, $ecrire); fclose($fp); 
}
?>