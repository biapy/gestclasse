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

//les notes
				
				titre_page("Mes notes et les commentaires");
				for ($t=1 ; $t<=3 ; $t++)
				{
				echo"
				<br>
				<table align=\"center\" width=\"90%\" border=\"0\"><tr><td><div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Trimestre $t</font></td></tr></table>
				<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"4\" cellpadding=\"0\" bgcolor=\"#ffffff\" class=\"borduregrise\">
				 <tr>
				  <td>
				  <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">
       			  	<tr bgcolor=\"#EBEBEB\">
					 <td>
				";
				$sql="select gc_notes.note, gc_devoir.nom FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$_SESSION[id_eleve]') and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim$t' ) and ( coef<>'0') ";
				$resultat=mysql_db_query($dbname,$sql,$id_link);
				while($rang=mysql_fetch_array($resultat))
				{
				$note=$rang['0'];
				if ($note==99) $note="<font color=\"#3399FF\">ABS</font>";
				if ($note==98) $note="<font color=\"#3399FF\">NN</font>";
				if ($note==97) $note="<font color=\"#3399FF\">NR</font>";
				if ($note<10) $note="<font color=\"#ff0000\">$note</font>";
				$nom_devoir=$rang['1'];
				echo" <font face=\"Arial, Helvetica, sans-serif\" size=\"1\">&nbsp; $nom_devoir : </font><font color=\"#0000CC\" face=\"Arial, Helvetica, sans-serif\" size=\"1\"> $note  </font>";
				}
				echo "</td></tr>";
				$sql2="select gc_devoir.nom, gc_notes.com_note FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$_SESSION[id_eleve]' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim$t' ) ";
				$resultat2=mysql_db_query($dbname,$sql2,$id_link);
				while($rang2=mysql_fetch_array($resultat2))
				{
				$nom_devoir=$rang2['0'];
				$com_note=$rang2['1'];
				if ($com_note<>'') echo "<tr><td><font face=\"Arial, Helvetica, sans-serif\" size=\"1\" ><font face=\"Arial, Helvetica, sans-serif\" color=\"#0000CC\">&nbsp; $nom_devoir : </font>$com_note</font></td></tr>";
				}
				echo"</tr></table></td></tr></table>";
			echo"<br>";
			}
?>	
<?		
//moyenne eleve

$sql="select trim1, trim2, trim3, trim4 FROM gc_eleve where id_eleve='$_SESSION[id_eleve]'";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
				if ($rang['trim1']==99) $trim1="";
				else $trim1=$rang['trim1'];
				if ($rang['trim2']==99) $trim2="";
				else $trim2=$rang['trim2'];
				if ($rang['trim3']==99) $trim3="";
				else $trim3=$rang['trim3'];
				if ($rang['trim4']==99) $trim4="";
				else $trim4=$rang['trim4'];

if ($trim1<10) $trim1="<font color=\"#ff0000\">$trim1</font>";
if ($trim2<10) $trim2="<font color=\"#ff0000\">$trim2</font>";
if ($trim3<10) $trim3="<font color=\"#ff0000\">$trim3</font>";
if ($trim4<10) $trim4="<font color=\"#ff0000\">$trim4</font>";		
				
titre_page ("Mes moyennes ");
?>
<br>
<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" class="borduregrise" bgcolor="#ffffff" >
  <tr> 
    <td width="25%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Trimestre1</font></div></td>
    <td width="25%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Trimestre2</font></div></td>
    <td width="25%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Trimestre3</font></div></td>
    <td width="25%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">G&eacute;n&eacute;rale</font></div></td>
  </tr>
  <tr> 
    <td width="25%"><font color="#0000CC" face="Arial, Helvetica, sans-serif"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $trim1 ?></font></div></font></td>
    <td width="25%"><font color="#0000CC" face="Arial, Helvetica, sans-serif"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $trim2 ?></font></div></font></td>
    <td width="25%"><font color="#0000CC" face="Arial, Helvetica, sans-serif"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $trim3 ?></font></div></font></td>
    <td width="25%"><font color="#0000CC" face="Arial, Helvetica, sans-serif"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $trim4 ?></font></div></font></td>
  </tr>
</table>
<br>
<?

//les ds

	titre_page("Les statistiques des devoirs");
	$sqld="select * FROM gc_devoir where classe='$_SESSION[classe_active]' and coef<>'0' ORDER BY id_devoir ";
	$resultatd=mysql_db_query($dbname,$sqld,$id_link);
	while($rangd=mysql_fetch_array($resultatd))
	{
		$id_devoir=$rangd['id_devoir'];
		$nom_devoir=$rangd['nom'];
		$duree=$rangd['duree'];
		$trim=$rangd['trim'];
		$coef=$rangd['coef'];
		$type=$rangd['type'];
		$date=$rangd['date'];
		$commentaire=$rangd['commentaire'];

		echo
		"
		<br><table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ffffff\" class=\"borduregrise\">
		<tr>
		<td>
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  >
		  <tr> 
			<td width=\"16%\"  > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>$nom_devoir</strong></font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">dur&eacute;e</font></div></td>
			<td width=\"16%\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">coef</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">date</font></div></td>
			<td width=\"20%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">commentaire</font></div></td>
		  </tr>
		  <tr> 
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$trim</font></div></td>
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
		
		
		$sql="select  note FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$i=1;
		while($rang=mysql_fetch_array($resultat))
		{
				$notem[$i]=$rang['0'];
				$i++;
		}
		if ($notem) $mediane=mediane($notem);
		
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90') and (note>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$sup10=$rang[0];
		
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90') and (note<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$inf10=$rang[0];
		
		echo
		"
		<tr>
		<td>
		<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\"  >
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
		<br>
		";
		}
		
//les statistiques de la classe
		echo "<br>";
		titre_page("Les statistiques de la classe");
		echo "<br>";
		for ($k=1 ; $k<=4 ; $k++)
		{
		$sql="select  COUNT(trim$k),ROUND(AVG(trim$k),1),MIN(trim$k),MAX(trim$k),ROUND(STD(trim$k),1) FROM gc_eleve where classe='$_SESSION[classe_active]' and trim$k!='99.0'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$moy=$rang[1];
		$min=$rang[2];
		$max=$rang[3];
		$ecty=$rang[4];
		
		$sql="select  count(trim$k) FROM gc_eleve where classe='$_SESSION[classe_active]' and trim$k!='99.0' and (trim$k>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		if (!$moy) $sup="";
		else $sup=$rang[0]; 
		
		$sql="select  count(trim$k) FROM gc_eleve where classe='$_SESSION[classe_active]' and trim$k!='99.0' and (trim$k<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		if (!$moy) $inf="";
		else $inf=$rang[0]; 
		
		$sql="select  trim$k FROM gc_eleve where classe='$_SESSION[classe_active]' and (trim$k!='99')";
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
		else $med='';
			
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
		graphique( $trim,'gc_eleve','classe',$_SESSION['classe_active']);
		echo "</div></td></tr></table><br>";
		
		
		
		
		}
				
?>