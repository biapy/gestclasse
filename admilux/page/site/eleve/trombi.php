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

//protection de la page
if (!isset($_SESSION['login']) or !isset($_SESSION['passe']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

titre_page("Le trombinoscope de la classe");


?>

<p>&nbsp;</p>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr>
<?
$sql="select classe FROM gc_eleve where id_eleve='$_SESSION[id_eleve]'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$classe=$rang['classe'];
//les photos
			$sql="select id_eleve, nom , prenom FROM gc_eleve where classe='$classe' ORDER BY nom,prenom ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$compteur=0;
			while($rang=mysql_fetch_array($resultat))
			{
			    $id_eleve_trombi=$rang['id_eleve'];
				$nom_eleve_trombi=$rang['nom'];
				$prenom_eleve_trombi=$rang['prenom'];
				$compteur++;
				if ($compteur%5==1) {echo "</tr><tr>";}
				echo "<td width=\"20%\">
					  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					    <tr>
      					  <td><div align=\"center\"><img src=\"admilux/photo_classe/$id_eleve_trombi.jpg\"></div></td>
  					    </tr>
  					   <tr>
   						  <td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom_eleve_trombi <br>$prenom_eleve_trombi</font></div></td>
  					   </tr>
					</table>
					</td>";
				
			}

?>
</tr></table>

