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
session_start();
include ("../../commun/connect.php");
include("../../commun/config.php");
include ("../../commun/fonction.php");
include("../../commun/texte.php"); 
echo "<link href=\"../../commun/style.css\" rel=\"stylesheet\" type=\"text/css\">";

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td colspan="2" > 
      <? 
	titre_page_impression ("Appreciations de $_GET[choix_classe]");
	
	?>
    </td>
  </tr>
  </table>
<p><br>
  <?

if (isset($_GET['choix_classe']) )
{

//le carnet de notes
			$sql="select id_eleve, nom , prenom, appreciation FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			    $id_eleve=$rang['id_eleve'];
				$nom_eleve=$rang['nom'];
				$prenom_eleve=$rang['prenom'];
				$appreciation=$rang['appreciation'];
				echo 
				"
				<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"3\" cellpadding=\"0\" class=\"borduregrise\" bgcolor=\"#FFFFFF\">
  				
			    <tr><td><img src=\"../photo_classe/$id_eleve.jpg\" align=\"absmiddle\" > <font size=\"3\" face=\"Arial, Helvetica, sans-serif\">$nom_eleve $prenom_eleve</font></td></tr>				
				<tr><td><font face=\"Arial, Helvetica, sans-serif\" size=\"1\">$appreciation</font></td></tr><br></table>
				";
			}
			

}
echo "<p align=\"right\"><img src=\"../../images/config/logogestclasse.gif\"></p>";
?>

