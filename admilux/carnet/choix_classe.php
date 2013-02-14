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

if (!isset($_GET['impression']))
{
echo" <form name=\"classe\">
        <div align=\"center\"> 
          <select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">
            <option>de :</option>
	";

			$sql="select  classe  from gc_classe";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$classe=$rang[classe];
			echo "<option value=\"?page_admi=$_GET[page_admi]&choix_classe=$classe\">$classe</option>";
			}
echo "</select>";
if (isset($_GET['choix_classe'])) 
{
if (isset($_GET['page_admi']) and $_GET['page_admi']=='notes_tableau') echo " <a href=\"admilux/carnet/impression.php?page_admi=$_GET[page_admi]&choix_classe=$_GET[choix_classe]&impression=ok&cacher=$_GET[cacher]\" target=\"_blank\"><img src=\"images/config/impression.gif\" align=\"absmiddle\" border=\"0\" ></a>";
else echo " <a href=\"admilux/carnet/impression.php?page_admi=$_GET[page_admi]&choix_classe=$_GET[choix_classe]&impression=ok\" target=\"_blank\"><img src=\"images/config/impression.gif\" align=\"absmiddle\" border=\"0\" ></a>";
if (isset($_GET['page_admi']) and $_GET['page_admi']=='notes_ligne') echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/carnet/appreciations.php?choix_classe=$_GET[choix_classe]\" target=\"_blank\">> Imprimer uniquement les appréciations aves les photos</a>";
echo " <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/fiches/mdp.php?choix_classe=$_GET[choix_classe]\" target=\"_blank\"> > voir les mots de passe</a></font>";
}
echo "</font></div></form>";
}
?>
