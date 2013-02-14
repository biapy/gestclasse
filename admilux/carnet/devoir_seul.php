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

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td colspan="2" > 
<?	  
titre_page("$_GET[choix_classe] : statistiques du $_GET[nom]" );
?>
    </td>
  </tr>
</table>
<br>
<?
//les ds
	$id_devoir=$_GET['id_devoir'];
	$nom=$_GET['nom'];
	$sqld="select * FROM gc_devoir where classe='$_GET[choix_classe]' and id_devoir=$id_devoir and coef<>'0'";
	$resultatd=mysql_db_query($dbname,$sqld,$id_link);
	while($rangd=mysql_fetch_array($resultatd))
	{
		$duree=$rangd['duree'];
		$trim=$rangd['trim'];
		$coef=$rangd['coef'];
		$type=$rangd['type'];
		$date=$rangd['date'];
		$commentaire=$rangd['commentaire'];
		echo
		"
		<table bgcolor=\"#FFFFFF\" width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"borduregrise\">
		<tr>
		<td>
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  >
		  <tr> 
			<td width=\"16%\"  > <div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp; $nom </strong></font><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $trim</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">dur&eacute;e</font></div></td>
			<td width=\"16%\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">coef</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">date</font></div></td>
			<td width=\"20%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">commentaire</font></div></td>
		  </tr>
		  <tr> 
		    <td width=\"16%\" ></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$duree</font></div></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$coef</font></div></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$type</font></div></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$date</font></div></td>
			<td width=\"20%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font></div></td>
		   </tr>
		 </table>
		 </td>
		 </tr>
		 ";
		
		//les statistiques  ... du devoir

		$sql="select  COUNT(note) FROM gc_notes where (id_devoir=$id_devoir) and (note>'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$absent=$rang[0];
		
		$sql="select  COUNT(note),ROUND(AVG(note),1),MIN(note),MAX(note),ROUND(STD(note),1) FROM gc_notes where id_devoir=$id_devoir and note<'90'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nombre_present=$rang[0];
		$moyenne=$rang[1];
		$minimum=$rang[2];
		$maximum=$rang[3];
		$ecart_type=$rang[4];
		
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90') and (note>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);

		$sup10=$rang[0];
		
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90') and (note<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$inf10=$rang[0];
		
		
		$sql="select  note FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$i=1;
		while($rang=mysql_fetch_array($resultat))
		{
				$notem[$i]=$rang['0'];
				$i++;
		}
		if ($notem) $mediane=mediane($notem);
		echo
		"
		<tr>
		<td>
		<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\" >
		  <tr> 
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Absents ou non not&eacute;s</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Moyenne</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">M&eacute;diane</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Min</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Max</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">sup10</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">inf10</font></div></td>
			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Ecart 
				type</font></div></td>
		  </tr>
		  <tr> 
			<td width=\"12%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$absent</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$moyenne</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$mediane</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$minimum</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$maximum</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$sup10</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$inf10</font></div></td>
			<td width=\"20%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$ecart_type</font></div></td>
		  </tr>
		</table>
		</td>
		</tr>
		<tr>
		<td><div align=\"center\">";
		graphique('note','gc_notes','id_devoir',$id_devoir);
		echo"</div>
		</td>
		</tr>
		<br>
		</table>
		";
		
		}
?>