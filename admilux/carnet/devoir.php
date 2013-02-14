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
	else titre_page_impression("Carnet de notes de  $_GET[choix_classe] - Statistiques des devoirs ");
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
	    include('choix_classe.php');
 ?>
 </td>
  </tr>
<?
if (isset($_GET['choix_classe'])  and !isset($_GET['impression']))
echo "<tr><td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]\"> Tableau de notes</a>  <img src=\"images/config/lien.gif\" > 
     	 Statistiques des devoirs <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=classe&choix_classe=$_GET[choix_classe]\"> Statistiques de la classe</a> <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_ligne&choix_classe=$_GET[choix_classe]\"> Notes en ligne - appréciations</a>  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=admicarnet&choix_classe=$_GET[choix_classe]\"> Carnet de notes complet</a> </font><div></td></tr>";  
?>
</table>
<br>
<?
//les ds
	$sqld="select * FROM gc_devoir where classe='$_GET[choix_classe]' and coef<>'0' ORDER BY id_devoir   ";
	$resultatd=mysql_db_query($dbname,$sqld,$id_link);
	while($rangd=mysql_fetch_array($resultatd))
	{
		$id_devoir=$rangd['id_devoir'];
		$nom=$rangd['nom'];
		$duree=$rangd['duree'];
		$trim=$rangd['trim'];
		$coef=$rangd['coef'];
		$type=$rangd['type'];
		$date=$rangd['date'];
		$commentaire=$rangd['commentaire'];

		//aucune note
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nb_notes=$rang[0];
		if ($nb_notes==0) $nb_notes="pas_de_note";
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
		  ";
		  if (!isset($_GET['impression']))
		  {
		  if ($nb_notes==0) echo "<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=pas_de_note\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">modifier</font></a></font></div></td>";
		  else echo "<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=$nb_notes\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">modifier</font></a></font></div></td>";	
		  }
		  else echo "<td width=\"16%\" ></td>";
		  echo"
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
if (isset($_GET['impression'])) echo "<p align=\"right\"><img src=\"../../images/config/logogestclasse.gif\"></p>";
?>