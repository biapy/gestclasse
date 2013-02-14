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
include("graphique_impression.php"); 

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}
if (isset($_GET['choix_classe']) and isset($_GET['trimestre']))
{
switch ($_GET['trimestre']) {
case "trim1": $k=1 ; break;
case "trim2": $k=2 ; break;
case "trim3": $k=3 ; break;
case "trim4": $k=4 ; break;
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td colspan="2" > 
      <? 
if ($k<>4)titre_page("$_GET[choix_classe] : Statistiques du trimestre $k ");
else titre_page("$_GET[choix_classe] : Statistiques de l'année ");
$trim=$_GET['trimestre'];
	?>
    </td>
  </tr>
</table>
<br>
<?

//les statistiques de la classe

		$sql="select  COUNT($trim),ROUND(AVG($trim),1),MIN($trim),MAX($trim),ROUND(STD($trim),1) FROM gc_eleve where classe='$_GET[choix_classe]' and $trim!='99.0'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$moy=$rang[1];
		$min=$rang[2];
		$max=$rang[3];
		$ecty=$rang[4];
		
		
		$sql="select  count($trim) FROM gc_eleve where classe='$_GET[choix_classe]' and $trim!='99.0' and ($trim>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		if (!$moy) $sup="";
		else $sup=$rang[0]; 

		$sql="select  count($trim) FROM gc_eleve where classe='$_GET[choix_classe]' and $trim!='99.0' and ($trim<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
 		if (!$moy) $inf="";
		else $inf=$rang[0]; 
		$sql="select  $trim FROM gc_eleve where classe='$_GET[choix_classe]' and ($trim!='99')";
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
		graphique( $trim,'gc_eleve','classe',$_GET['choix_classe']);
		echo "</div></td></tr></table><br>";


		
}

?>




