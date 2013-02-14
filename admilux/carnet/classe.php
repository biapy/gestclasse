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

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td colspan="2" > 
      <? 
	if (isset($_GET['choix_classe'])) 
	{ 
	if (!isset($_GET['impression'])) titre_page("Carnet de notes de  $_GET[choix_classe]");
	else titre_page_impression("Carnet de notes de  $_GET[choix_classe] - Statistiques de la classe ");
	}
	else titre_page('Carnet de notes de ')
	?>
    </td>
  </tr>
  <tr>
  <?  
    	if (!isset($_GET['impression'])) $hauteur_tableau=50;
		else $hauteur_tableau=0;
		echo "<td height=\"$hauteur_tableau\">";
		include('choix_classe.php'); ?>
    </td>
  </tr>
<?
if (isset($_GET['choix_classe'])  and !isset($_GET['impression']))
echo "<tr><td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]\"> Tableau de notes</a>  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=devoir&choix_classe=$_GET[choix_classe]\">
     	 Statistiques des devoirs</a> <img src=\"images/config/lien.gif\" >  Statistiques de la classe <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_ligne&choix_classe=$_GET[choix_classe]\"> Notes en ligne - appréciations</a>  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=admicarnet&choix_classe=$_GET[choix_classe]\"> Carnet de notes complet</a> </font><div></td></tr>";  
?>
</table>
<br>
<?
if (isset($_GET['choix_classe']))
{


		
//les statistiques de la classe

		for ($k=1 ; $k<=4 ; $k++)
		{
		$sql="select  COUNT(trim$k),ROUND(AVG(trim$k),1),MIN(trim$k),MAX(trim$k),ROUND(STD(trim$k),1) FROM gc_eleve where classe='$_GET[choix_classe]' and trim$k!='99.0'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$moy=$rang[1];
		$min=$rang[2];
		$max=$rang[3];
		$ecty=$rang[4];
		
		
		$sql="select  count(trim$k) FROM gc_eleve where classe='$_GET[choix_classe]' and trim$k!='99.0' and (trim$k>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		if (!$moy) $sup="";
		else $sup=$rang[0]; 
		
		
		
		$sql="select  count(trim$k) FROM gc_eleve where classe='$_GET[choix_classe]' and trim$k!='99.0' and (trim$k<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
 		if (!$moy) $inf="";
		else $inf=$rang[0]; 
		$sql="select  trim$k FROM gc_eleve where classe='$_GET[choix_classe]' and (trim$k!='99')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		unset($notem);
		unset($med);
		$j=1;
		while($rang=mysql_fetch_array($resultat))
		{
				$notem[$j]=$rang['0'];
				$j++;
		}
		if (isset($notem)) $med=mediane($notem);
		else $med=0;
	
		if ($k==4)
		{
		echo"<table align=\"center\" width=\"90%\" border=\"0\"><tr><td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Moyenne générale</font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> ( Calculée sur toutes les notes coefficientées de l'année)</font></td></tr></table>";
		}
		else
		{
		echo"<table align=\"center\" width=\"90%\" border=\"0\"><tr><td><div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Trimestre $k</font></td></tr></table>";
		}
		echo
		"
		<table bgcolor=\"#ffffff\" width=\"90%\" align=\"center\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\" class=\"borduregrise\">
		  <tr><td>
		    <table width=\"100%\"><tr> 
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Moyenne</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">M&eacute;diane</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Min</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Max</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">sup10</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">inf10</font></div></td>
			<td width=\"22%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Ecart 
				type</font></div></td>
			</tr>
			</table>	
		  </td></tr>
		  <tr><td>
		    <table width=\"100%\"><tr> 
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$moy</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$med</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$min</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$max</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$sup</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$inf</font></div></td>
			<td width=\"22%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$ecty</font></div></td>
		  </tr></table></td></tr><tr><td><div align=\"center\">";
		$trim='trim'.$k;
		graphique( $trim,'gc_eleve','classe',$_GET['choix_classe']);
		echo "</div></td></tr></table><br>";

		}
		
}

if (isset($_GET['impression'])) echo "<p align=\"right\"><img src=\"../../images/config/logogestclasse.gif\"></p>";
?>




