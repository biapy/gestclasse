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


//formatage des textes
if (isset($_POST['nom'])) $_POST['nom']=texte($_POST['nom']);
if (isset($_POST['classe'])) $_POST['classe']=texte($_POST['classe']);
if (isset($_POST['commentaire'])) $_POST['commentaire']=texte($_POST['commentaire']);





		if (!isset($_POST['modification']) )
		{
		$id_devoir=$_GET['id_devoir'];
		}
		if ( isset($_POST['modification']) and $_POST['modification']=="ok")//Modification du devoir
		{
				$sql="REPLACE INTO gc_devoir ( id_devoir, nom, classe, duree, trim , coef, type , date, commentaire) VALUES ( '$_POST[id_devoir]','$_POST[nom]', '$_POST[classe]', '$_POST[duree]', '$_POST[trim]' , '$_POST[coef]', '$_POST[type]', '$_POST[date]', '$_POST[commentaire]')";
				mysql_db_query($dbname,$sql,$id_link);
				$id_devoir=$_POST['id_devoir'];
		}
		$sql="select  * FROM gc_devoir where id_devoir=$id_devoir";
					
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$id_devoir=$rang['id_devoir'];
			$nom=$rang['nom'];
			$classe=$rang['classe'];
			$duree=$rang['duree'];
			$trim=$rang['trim'];
			$coef=$rang['coef'];
			$type=$rang['type'];
			$date=$rang['date'];
			$commentaire=$rang['commentaire'];
		titre_page("Modification des informations concernant le devoir $nom de $classe");
		echo"<br>";
		
//suppression d'un devoir

if (isset($_GET['del']) and $_GET['del']=="ok" )
{
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer ce devoir et les notes concernant ce devoir  définitivement de la base de données');
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"?page_admi=modif_dev&id_devoir=$_GET[id_devoir]&del=ok&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"?page_admi=modif_dev&id_devoir=$_GET[id_devoir]\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 { 
		$sql="delete FROM gc_devoir where id_devoir=$_GET[id_devoir]";
		mysql_db_query($dbname,$sql,$id_link);
		$sql="delete FROM gc_notes where id_devoir=$_GET[id_devoir]";
		mysql_db_query($dbname,$sql,$id_link);
	    message('Le devoir et les notes  ont été supprimés définitivement de la base de données');
        ;	 
	 }
	 
}

if (!isset($_GET['del_confirmation'])) 
	 { 
		echo 
		"
			<form method=\"post\" action=\"?page_admi=modif_dev\" >
				<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"bordure\">
				  <tr> 
					<td width=\"10%\" height=\"18\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">nom</font></div></td>
					<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">classe</font></div></td>
					<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">dur&eacute;e</font></div></td>
					<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">trimestre</font></div></td>
					<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">coef</font></div></td>
					<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
					<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">date</font></div></td>
					<td width=\"30%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">commentaire</font></div></td>
				  </tr>
				  <tr> 

					<td ><div align=\"center\"><input name=\"nom\" type=\"text\" value=\"$nom\" size=\"5\" ></div></td>
					<td><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"> $classe</font></div></td>
					<td ><div align=\"center\"> <input name=\"duree\" type=\"text\" value=\"$duree\" size=\"4\" ></div></td>
					<td >
					";
					
					if ($trim=="trim1")
					echo"<select name=\"trim\"><option>trim1</option><option>trim2</option><option>trim3</option></select></td>";
					else if ($trim=="trim2")
					echo"<select name=\"trim\"><option>trim2</option><option>trim1</option><option>trim3</option></select></td>";
					else
					echo"<select name=\"trim\"><option>trim3</option><option>trim1</option><option>trim2</option></select></td>";
					echo"
					<td><div align=\"center\"><input name=\"coef\" type=\"text\" value=\"$coef\" size=\"3\" ></div></td>
					<td ><div align=\"center\">
					";
					if ($type=="DS")
					echo"<select name=\"type\" ><option>DS</option><option>DM</option><option>Int.écrite</option><option>Int.orale</option></select></div></td>";
					else if ($type=="DM")
					echo"<select name=\"type\" ><option>DM</option><option>DS</option><option>Int.écrite</option><option>Int.orale</option></select></div></td>";
					else if ($type=="Int.écrite")
					echo"<select name=\"type\" ><option>Int.écrite</option><option>DM</option><option>DS</option><option>Int.orale</option></select></div></td>";
					else
					echo"<select name=\"type\" ><option>Int.orale</option><option>DM</option><option>Int.écrite</option><option>DS</option></select></div></td>";
					echo"
					<td ><div align=\"center\"> <input name=\"date\" type=\"text\" value=\"$date\" size=\"9\" ></div></td>
					<td  ><div align=\"center\"><input name=\"commentaire\" type=\"text\" value=\"$commentaire\" size=\"22\" ></div></td>
				   </tr>
				 </table>
				 <input name=\"classe\" type=\"hidden\" value=\"$classe\"><br>
				 <input name=\"modification\" type=\"hidden\" value=\"ok\">
				 ";
		 
				 echo
				 "
				 <input name=\"id_devoir\" type=\"hidden\" value=\"$id_devoir\">
				 <div align=\"center\"><input type=\"submit\" name=\"Submit\" value=\"Modifier\"></div>
				 </form>
		";
	//aucune note
	$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
	$resultat=mysql_db_query($dbname,$sql,$id_link);
	$rang=mysql_fetch_array($resultat);
	$nb_notes=$rang[0];
	if ($nb_notes==0) $nb_notes="pas_de_note";
	
		//les statistiques du devoir
		
		if ( $coef<>'0')
		{
		titre_page("Statistiques du devoir $nom de $classe");
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
				$note[$i]=$rang['0'];
				$i++;
		}
		if ($note) $mediane=mediane($note);
		
		echo
		"
		<br>
		<table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\" class=\"bordure\">
		  <tr> 
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Absents ou non not&eacute;s</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Moyenne</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">M&eacute;diane</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Min</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Max</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">sup10</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">inf10</font></div></td>
			<td width=\"20%\"><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Ecart 
				type</font></div></td>
		  </tr>
		  <tr> 
			<td width=\"12%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$absent</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$moyenne</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$mediane</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$minimum</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$maximum</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$sup10</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$inf10</font></div></td>
			<td width=\"20%\"><div align=\"center\"><font color=\"#FF6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$ecart_type</font></div></td>
		  </tr>
		</table>
		";
		}
		echo"<p><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=modif_dev&del=ok&id_devoir=$id_devoir\">Supprimer
		  le devoir</a> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" align=\"bottom\"> ( le devoir et les notes sont supprimés ) </font></font> </p>";
		if ($nb_notes==0) echo "<p><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=pas_de_note \">Retourner à la liste des notes</a></font></p>";
		else echo "<p><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=$nb_notes \">Retourner à la liste des notes</a></font></p>";

		
		

		// Calcul des moyennes des élèves		
		$sql="select id_eleve FROM gc_eleve where classe='$classe'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		while($rang=mysql_fetch_array($resultat))
		{
		$id_eleve=$rang['id_eleve'];		
		for ($i=1 ; $i<=3 ; $i++)
				{
				$trim="trim".$i;
				$sql1="select SUM(gc_notes.note*gc_devoir.coef)/SUM(gc_devoir.coef) FROM gc_notes,gc_devoir where (gc_notes.note<'90') and (id_eleve='$id_eleve') and (gc_notes.id_devoir=gc_devoir.id_devoir) and (gc_devoir.trim='$trim') ";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				$rang1=mysql_fetch_array($resultat1);
				if (!$rang1['0'] and $rang1['0']!="0")
				$moy[$i]="99.0";
				else
				$moy[$i]=$rang1['0']; 
				
				}
				$sql2="select SUM(gc_notes.note*gc_devoir.coef)/SUM(gc_devoir.coef) FROM gc_notes,gc_devoir where (gc_notes.note<'90') and (id_eleve='$id_eleve') and (gc_notes.id_devoir=gc_devoir.id_devoir) ";
				$resultat2=mysql_db_query($dbname,$sql2,$id_link);
				$rang2=mysql_fetch_array($resultat2);
				if (!$rang2['0'] and $rang2['0']!="0")
				$moy_gen="99.0";
				else
				$moy_gen=$rang2['0']; 
				
				$sql3="UPDATE gc_eleve SET trim1='$moy[1]',trim2='$moy[2]',trim3='$moy[3]',trim4='$moy_gen' where id_eleve='$id_eleve'";
				$resultat3=mysql_db_query($dbname,$sql3,$id_link);
		}
}

?>