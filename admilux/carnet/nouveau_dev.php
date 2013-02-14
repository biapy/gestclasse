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

titre_page("Ajouter/modifier un devoir");

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}
message('- Pour nommer le devoir, il est préférable d\'utiliser trois caractères au plus.<br>- Pour saisir un devoir ne comptant pas dans la moyenne, choisissez 0 comme coefficient.<br>- Vous pouvez saisir un coefficient plus fin dans la rubrique - Modifier les informations concernant le devoir -.');

//formatage des textes
if (isset($_POST['nom'])) $_POST['nom']=texte($_POST['nom']);
if (isset($_POST['classe'])) $_POST['classe']=texte($_POST['classe']);
if (isset($_POST['commentaire'])) $_POST['commentaire']=texte($_POST['commentaire']);



echo "<table align=\"center\" width=\"100%\" border=\"0\"><tr><td>";

//*************** definir un nouveau devoir 
if (!isSet($_POST['nouveau_devoir']) and !isSet($_GET['modification_notes_bis']) )
{

		echo
		"
		<p>&nbsp;</p>
		<form method=\"post\" action=\"?page_admi=adminouveau_dev\" >
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"bordure\">
		  <tr> 
			<td width=\"10%\" height=\"18\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom</font></div></td>
			<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">classe</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">dur&eacute;e</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">trimestre</font></div></td>
			<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">coef</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">date</font></div></td>
			<td width=\"30%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">commentaire</font></div></td>
		  </tr>
		  <tr> 
			<td ><div align=\"center\"><input name=\"nom\" type=\"text\" size=\"5\" ></div></td>
			<td> 
		";
				echo "<select name=\"classe\" >";
				$sql="select  classe  from gc_classe";
				$resultat=mysql_db_query($dbname,$sql,$id_link);
				while($rang=mysql_fetch_array($resultat))
				{
				$classe=$rang[classe];
				echo"<option>$classe</option>";
				}
				echo "</select>";
		echo"
			</td>
			<td ><div align=\"center\"> <input name=\"duree\" type=\"text\" size=\"4\" ></div></td>
			<td ><div align=\"center\"> <select name=\"trim\" ><option>trim1</option><option>trim2</option><option>trim3</option></select></div></td>
			<td><div align=\"center\"><select name=\"coef\"><option>1</option><option>1.5</option><option>2</option><option>2.5</option><option>3</option><option>3.5</option><option>4</option><option>4.5</option><option>5</option><option>5.5</option><option>6</option><option>6.5</option><option>7</option><option>7.5</option><option>8</option><option>8.5</option><option>9</option><option>9.5</option><option>10</option><option>10.5</option><option>0</option></select></div></td>
			<td ><div align=\"center\"> <select name=\"type\" ><option>DS</option><option>DM</option><option>Int.écrite</option><option>Int.orale</option></select></div></td>
			<td><div align=\"center\"><input name=\"date\" type=\"text\" size=\"9\" ></div></td>
			<td ><div align=\"center\"><input name=\"commentaire\" type=\"text\" size=\"22\" ></div></td>
		   </tr>
		 </table>
		 <input name=\"nouveau_devoir\" type=\"hidden\" value=\"ok\"><br>
		 <div align=\"center\"><input type=\"submit\" name=\"Submit\" value=\"Ajouter\"></div>
		 </form>
		";

}
//*************** fin ( définir un nouveau devoir )

	
//--------------- nouveau devoir 
if ( (isset($_POST['nouveau_devoir']) and $_POST['nouveau_devoir']=="ok") or ( isset($_GET['modification_notes_bis']) and $_GET['modification_notes_bis']=="ok"))
{
	if ((isset($_POST['nom'])) and $_POST['nom']=="")
	{ 
	message('Il faut absolument nommer le devoir');
	}
	else
	{
		//nouveau devoir
	if (!isset($_POST['nlle_notes']) and !isSet($_GET['modification_notes_bis']))
	{
		
	$sql="INSERT INTO gc_devoir ( nom, classe, duree,trim, coef, type , date, commentaire) VALUES ('$_POST[nom]', '$_POST[classe]', '$_POST[duree]', '$_POST[trim]','$_POST[coef]', '$_POST[type]', '$_POST[date]', '$_POST[commentaire]')";
	mysql_db_query($dbname,$sql,$id_link);
	$sql="select  * FROM gc_devoir where id_devoir=last_insert_id()";
	}
	else
	{
	if (isset($_GET['id_devoir'])) $id_devoir=$_GET['id_devoir'];
	if (isset($_POST['id_devoir'])) $id_devoir=$_POST['id_devoir'];
	$sql="select  * FROM gc_devoir where id_devoir=$id_devoir";
	}
		
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

		if (!isset($_POST['nlle_notes']) and !isset($_POST['modification_notes']) and !isset($_GET['modification_notes_bis']))
		{
		message('Il faut saisir les notes ( ou les commentaires ) avant de pouvoir modifier les informations concernant le devoir.</font>');
		}
		echo
		"
		<table width=\"80%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"bordure\">
		  <tr> 
			<td width=\"10%\" height=\"18\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">nom</font></div></td>
			<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">classe</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">dur&eacute;e</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">trimestre</font></div></td>
			<td width=\"10%\"> <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">coef</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
			<td width=\"10%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">date</font></div></td>
			<td width=\"30%\" > <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">commentaire</font></div></td>
		  </tr>
		  <tr> 
			<td  ><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$nom</font></div></td>
			<td><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$classe</font></div></td>
			<td ><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$duree</font></div></td>
			<td ><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$trim</font></div></td>
			<td><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$coef</font></div></td>
			<td ><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$type</font></div></td>
			<td ><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$date</font></div></td>
			<td  ><div align=\"center\"><font color=\"#ff6600\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font></div></td>
		   </tr>
		 </table>
		
		 ";
if (isset($_POST['nlle_notes']) or isset($_GET['modification_notes_bis']) and (isset($_GET['nb_notes']) and $_GET['nb_notes']<>'pas_de_notes' )) echo "<img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\"><a href=\"?page_admi=modif_dev&id_devoir=$id_devoir\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Modifier les informations concernant le devoir</font></a>";
//--------------- fin ( nouveau devoir )


echo "</td></tr></table>";
//+++++++++++++++ les notes des élèves 


if ( $coef<>'0') titre_page("Saisir/modifier les notes et les commentaires");
else titre_page("Saisir/modifier les commentaires");

echo "<table align=\"center\" width=\"100%\" border=\"0\"><tr><td>";
if ( $coef<>'0') message('Saisissez 99 pour indiquer qu\'un élève est absent.<br>Saisissez 98 pour indiquer qu\'un élève est non noté. <br>Saisissez 97 pour indiquer qu\'un devoir est non rendu.');
//oooooooo nouvelles notes

		
		if ( (!isset($_POST['nlle_notes']) and !isset($_GET['modification_notes_bis']) ) or ( isset($_GET['nb_notes']) and $_GET['nb_notes']=="pas_de_note"))
		{	
		echo "<form name=\"form1\" method=\"post\" action=\"?page_admi=adminouveau_dev\">";
		echo "<table width=\"80%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"bordure\">";
	  	$sql="select  *  FROM gc_eleve where classe='$classe' ORDER BY nom,prenom";	
	 	$resultat=mysql_db_query($dbname,$sql,$id_link);
		$couleur='#F4F4F4';
	  	while($rang=mysql_fetch_array($resultat))
			{
		$id_eleve=$rang['id_eleve'];
		$nom_eleve=$rang['nom'];
		$nom_eleve=subStr($nom_eleve,0,19);
		$prenom=$rang['prenom'];
		$prenom=subStr($prenom,0,1).".";
			
			
			echo
			"
			<tr bgcolor=\"$couleur\">
				<td width=\"10%\"></td>
				<td width=\"30%\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"> <img src=\"images/config/lien.gif\"  align=\"absmiddle\"> $nom_eleve
				  $prenom</font></td>
			";
			if ($coef<>'0') echo"<td width=\"20%\"><input type=\"text\" name=\"note[$id_eleve]\" size=\"5\"></td>";
			echo"
				<td width=\"40%\"><input type=\"text\" size=\"40\" name=\"com_note[$id_eleve]\"></td>
			</tr>";
			if ($couleur=='#F4F4F4') $couleur='#FFFFFF';
			else $couleur='#F4F4F4';
			}
		 echo 
		 "
			</table>
			<input name=\"nouveau_devoir\" type=\"hidden\" value=\"ok\">
			<input name=\"modification\" type=\"hidden\" value=\"ok\">
			<input name=\"nlle_notes\" type=\"hidden\" value=\"ok\">
			<input name=\"id_devoir\" type=\"hidden\" value=\"$id_devoir\">
			<br>
			<div align=\"center\"><input type=\"submit\" name=\"Submit\" value=\"Valider\"></div>
			</form>
		 ";
		}

//oooooooo fin (nouvelles notes)	 
	 	//modification de notes


		if ( (isset($_POST['nlle_notes']) and $_POST['nlle_notes']=="ok" ) or ( ( isset($_GET['modification_notes_bis']) and $_GET['modification_notes_bis']=='ok')  and ( isset($_GET['nb_notes']) and $_GET['nb_notes']<>"pas_de_note" ) ))
		{
			if ( isset($_POST['modification_notes']) and $_POST['modification_notes']=="ok"  )
			{
			$sql="select  gc_eleve.*,gc_notes.id_notes  FROM gc_eleve,gc_notes where (gc_eleve.classe='$classe') and (gc_eleve.id_eleve=gc_notes.id_eleve )and (gc_notes.id_devoir='$_POST[id_devoir]') ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
				{
			
				$id_eleve=$rang['id_eleve'];
				$id_note=$rang['id_notes'];
				if ($coef<>'0')
				{
				if ($_POST['note'][$id_eleve]=="abs") $_POST['note'][$id_eleve]=99;
				$note=$_POST['note'][$id_eleve];
				$com_note=texte($_POST['com_note'][$id_eleve]);
				$sql="REPLACE INTO gc_notes ( id_notes, id_devoir, id_eleve, note, com_note) VALUES ( '$id_note' , '$_POST[id_devoir]', '$id_eleve', '$note', '$com_note')";
				}
				else
				{
				$com_note=texte($_POST['com_note'][$id_eleve]);
				$sql="REPLACE INTO gc_notes ( id_notes, id_devoir, id_eleve, note, com_note) VALUES ( '$id_note' , '$_POST[id_devoir]', '$id_eleve', '0', '$com_note')";
				}
				mysql_db_query($dbname,$sql,$id_link);
				}
			
			}
		
			else
			{
				if (!isset($_GET['modification_notes_bis']))
				{
				$sql="select  *  FROM gc_eleve where classe='$classe' ";
				$resultat=mysql_db_query($dbname,$sql,$id_link);
				while($rang=mysql_fetch_array($resultat))
					{
					$id_eleve=$rang['id_eleve'];
					if ($coef<>'0')
				    {
					$note=$_POST['note'][$id_eleve];
					if ($note=="") $note="99";
					$com_note=texte($_POST['com_note'][$id_eleve]);
					$sql="INSERT INTO gc_notes ( id_devoir, id_eleve, note, com_note) VALUES ('$_POST[id_devoir]', '$id_eleve', '$note', '$com_note')";
					}
					else
					{
					$com_note=texte($_POST['com_note'][$id_eleve]);
					$sql="INSERT INTO gc_notes ( id_devoir, id_eleve, note, com_note) VALUES ('$_POST[id_devoir]', '$id_eleve', '0', '$com_note')";
					}
					
					mysql_db_query($dbname,$sql,$id_link);
					}
				}	
			}
			
			
		//affichage des nouvelles notes
		
		if ( (isset($_GET['nb_notes']) and $_GET['nb_notes']<>"pas_de_note") or !isset($_GET['nb_notes']) )
		{
			if ( isset($_GET['modification_notes_bis'] ) and $_GET['modification_notes_bis']=="ok" )
			{
			if ($coef<>'0') echo "<br><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\"><a href=\"?page_admi=modif_dev&id_devoir=$id_devoir\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Calculer les statistiques du devoir et les moyennes des élèves</font></a><br>";
			$sql="select  gc_eleve.*,gc_notes.note, gc_notes.com_note  FROM gc_eleve,gc_notes where (gc_eleve.classe='$classe') and (gc_notes.id_eleve=gc_eleve.id_eleve) and ( gc_notes.id_devoir=$_GET[id_devoir])  ORDER BY nom,prenom";
			}
			else
			{
			if ($coef<>'0') echo "<br><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\"><a href=\"?page_admi=modif_dev&id_devoir=$id_devoir\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Calculer les statistiques du devoir et les moyennes des élèves</font></a><br>";
			$sql="select  gc_eleve.*,gc_notes.note, gc_notes.com_note  FROM gc_eleve,gc_notes where (gc_eleve.classe='$classe') and (gc_notes.id_eleve=gc_eleve.id_eleve) and ( gc_notes.id_devoir=$_POST[id_devoir])  ORDER BY nom,prenom";
			}
		echo "<br><form name=\"form1\" method=\"post\" action=\"?page_admi=adminouveau_dev\">";
		echo "<table width=\"80%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"bordure\">";
		
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$couleur='#F4F4F4';
	  	while($rang=mysql_fetch_array($resultat))
		{
		$id_eleve=$rang['id_eleve'];
		$nom_eleve=$rang['nom'];
		$nom_eleve=subStr($nom_eleve,0,19);
		$prenom=$rang['prenom'];
		$prenom=subStr($prenom,0,1).".";
		$note=$rang['note'];
		$com_note=$rang['com_note'];
		echo
		"
		<tr bgcolor=\"$couleur\">
		    <td width=\"10%\"></td>
		    <td width=\"30%\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"> <img src=\"images/config/lien.gif\"  align=\"absmiddle\"> $nom_eleve
				  $prenom</font></td>
		";
		if ($coef<>'0') echo"<td width=\"20%\"><input type=\"text\" name=\"note[$id_eleve]\" value=\"$note\" size=\"5\"></td>";
		echo"
		<td><input type=\"text\" size=\"40\" name=\"com_note[$id_eleve]\" value=\"$com_note\"></td>
  		</tr>";
		if ($couleur=='#F4F4F4') $couleur='#FFFFFF';
		else $couleur='#F4F4F4';
		}
	 echo 
	 "
	 	</table>
		<input name=\"nouveau_devoir\" type=\"hidden\" value=\"ok\">
		<input name=\"modification\" type=\"hidden\" value=\"ok\">
		<input name=\"nlle_notes\" type=\"hidden\" value=\"ok\">
		<input name=\"modification_notes\" type=\"hidden\" value=\"ok\">
		<input name=\"id_devoir\" type=\"hidden\" value=\"$id_devoir\">
		<br><div align=\"center\"><input type=\"submit\" name=\"Submit\" value=\"Modifier les notes\"></div>
		</form>
	 ";
		}
	
		}
//+++++++++++++++ fin ( les notes des élèves )				
}
}
echo "</td></tr></table>";

?> 

