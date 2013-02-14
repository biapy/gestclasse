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

// protection de la page

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}
titre_page_impression("Trombinoscope de  $_GET[choix_classe]");
?>
<br>	
<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr>
<?
if (isset($_GET['choix_classe']) )
{

//les photos
			$sql="select id_eleve, nom , prenom FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$compteur=0;
			while($rang=mysql_fetch_array($resultat))
			{
			    $id_eleve=$rang['id_eleve'];
				$nom_eleve=$rang['nom'];
				$prenom_eleve=$rang['prenom'];
				$compteur++;
				if ($compteur%5==1) {echo "</tr><tr>";}
				echo "<td width=\"20%\">
					  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					    <tr>
 						 <div align=\"center\"><img src=\"../../admilux/photo_classe/$id_eleve.jpg\" border=\"0\"></div>
  					    </tr>
  					   <tr>
   						  <td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom_eleve <br>$prenom_eleve</font></div></td>
  					   </tr>
					</table>
					</td>";
			
			}
}
?>
</tr></table>

<div align="right"><br>
  <img src="../../images/config/logogestclasse.gif" ></div>
