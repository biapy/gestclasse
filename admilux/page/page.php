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
##                      modifié avec l'aide de TRUGEON Nicolas                ##
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
if (isset($_POST['haut'])) $_POST['haut']=texte($_POST['haut']);
if (isset($_POST['bas'])) $_POST['bas']=texte($_POST['bas']);
if (isset($_POST['nom_auto'])) $_POST['nom_auto']=texte($_POST['nom_auto']);
if (isset($_POST['url_auto'])) $_POST['url_auto']=texte($_POST['url_auto']);
if (isset($_POST['contenu_auto'])) $_POST['contenu_auto']=texte($_POST['contenu_auto']);
if (isset($_POST['nom_division'])) $_POST['nom_division']=texte($_POST['nom_division']);
if (isset($_POST['contenu_division'])) $_POST['contenu_division']=texte($_POST['contenu_division']);

//page active
if (isset($_GET['id_page_sous_titre']) and $_GET['id_page_sous_titre']<>null) $id_page_active=$_GET['id_page_sous_titre'];
else $id_page_active=$_GET['id_page'] ;

//Modification contenu : haut et bas de page
if ( isset($_GET['modif_contenu']) and $_GET['modif_contenu']=="ok")
{
$sql="UPDATE gc_contenu_page SET  haut='$_POST[haut]',bas='$_POST[bas]',id_page='$id_page_active' where id_page='$id_page_active'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout contenu : haut et bas de page
if ( isset($_GET['ajout_contenu']) and $_GET['ajout_contenu']=="ok")
{
$sql="INSERT INTO gc_contenu_page( haut, bas, id_page ) VALUES ('$_POST[haut]','$_POST[bas]', '$id_page_active')";
mysql_db_query($dbname,$sql,$id_link);
};

//Modification du contenu automatique
if ( isset($_GET['modif_auto']) and $_GET['modif_auto']=="ok")
{
if(!isset($_POST['accueil'])) $affichage=0;
if(isset($_POST['invisible'])) $affichage=2;
if(isset($_POST['accueil'])) $affichage=1;

$sql="UPDATE gc_contenu_auto SET  nom='$_POST[nom_auto]',url='$_POST[url_auto]',contenu='$_POST[contenu_auto]',ordre='$_POST[ordre_auto]' ,type='$_POST[type]' , accueil='$affichage'  where id_auto='$_GET[id_auto]'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout de contenu automatique
if ( isset($_GET['ajout_auto']) and  $_GET['ajout_auto']=="ok")
{
if ( !isset($_POST['url']))
	{
    if (isset($_POST['dossier']) and $_POST['dossier']<>'' )
	$content_dir = "documents/".$_POST['dossier']."/"; // dossier où sera déplacé le fichier
	else $content_dir = "documents/";// dossier où sera déplacé le fichier
    $tmp_file = $_FILES['fichier_auto']['tmp_name'];
	if( !is_uploaded_file($tmp_file) )
    {
        message("Le fichier est introuvable $tmp_file");
		exit();
    }

    // on vérifie maintenant l'extension
	$name_file = $_FILES['fichier_auto']['name'];
	$pos_extension=strRpos($name_file,".");
	$extension=substr($name_file,$pos_extension);
	if ($extension==".php" or $extension==".exe" )
	{
        message("Le fichier n'est pas un document");
		exit();
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier_auto']['name'];
	$name_file=$content_dir . $name_file;

	if (file_exists($name_file))
	{
		message("Le fichier spécifié existe déjà...");
		exit();
	}

	if( !move_uploaded_file($tmp_file, $name_file) )
    {
        message("Impossible de copier le fichier dans $content_dir");
		exit();
    }
	$_POST['url_auto']=$name_file;
	}
else $_POST['url_auto']=$_POST['dossier'];

if(!isset($_POST['accueil'])) $affichage=0;
if(isset($_POST['invisible'])) $affichage=2;
if(isset($_POST['accueil'])) $affichage=1;
$sql="INSERT INTO gc_contenu_auto ( nom, url, contenu, ordre, type, accueil, id_division, sans_division ) VALUES ('$_POST[nom_auto]','$_POST[url_auto]', '$_POST[contenu_auto]','$_POST[ordre_auto]', '$_POST[type]' ,'$affichage','$_GET[id_division]' ,'$_POST[sans_division]')";
mysql_db_query($dbname,$sql,$id_link);
};




//Modification d'une division
if ( isset($_GET['modif_division']) and  $_GET['modif_division']=="ok")
{
$sql="UPDATE gc_division_page SET  nom_division='$_POST[nom_division]',id_page='$id_page_active',ordre='$_POST[ordre_division]',contenu='$_POST[contenu_division]' where id_division='$_GET[id_division]'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout d'une division
if ( isset($_GET['ajout_division']) and  $_GET['ajout_division']=="ok")
{
$sql="INSERT INTO gc_division_page( nom_division, id_page, ordre, contenu ) VALUES ('$_POST[nom_division]','$id_page_active', '$_POST[ordre_division]','$_POST[contenu_division]' )";
mysql_db_query($dbname,$sql,$id_link);
};


$sql="select  titre,classe  FROM gc_page where id_page='$_GET[id_page]'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$titre=$rang['titre'];
$classe=$rang['classe'];


?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td >
<? 
if ( $classe<>"aucune restriction" )titre_page("$classe - $titre");
else titre_page($titre);
//suppression du contenu automatique

if (isset($_GET['del_auto']) and $_GET['del_auto']=="ok")
{
		$sql="SELECT * FROM gc_contenu_auto WHERE id_auto='$_GET[id_auto]'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nom=$rang['nom'];
		$url=$rang['url'];
		$type=$rang['type'];
		$fichier=$rang['url'];
		$sans_division=$rang['sans_division'];
		$id_division=$rang['id_division'];
		if ($sans_division<>'1')
		{
		$sql="SELECT nom_division FROM gc_division_page WHERE id_division='$id_division'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nom_division=$rang['nom_division'];
		$nom_division='- de la division -'.$nom_division;
		}
		else $nom_division="";
		
			
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  	if (file_exists($fichier)  and isset($_GET['del_fichier']) and  $_GET['del_fichier']=="ok")
	 	{	
		message('Voulez-vous vraiment supprimer le contenu automatique -'.$nom.'- de type -'.$type.$nom_division.'- définitivement de la base de données et le fichier associé -'.$url.'-');
		if ( isset($_GET['id_page_sous_titre']))
		echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$_GET[id_auto]&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]&del_fichier=ok&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=page&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\">NON</a></font></p>
		";
		else
		echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$_GET[id_auto]&id_page=$_GET[id_page]&del_fichier=ok&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, saAns-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=page&id_page=$_GET[id_page]]\">NON</a></font></p>
		";
		}
		else
		{	
		message('Voulez-vous vraiment supprimer le contenu automatique -'.$nom.'- de type -'.$type.$nom_division.'- définitivement de la base de données ');
		if ( isset($_GET['id_page_sous_titre']))
		echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$_GET[id_auto]&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=page&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\">NON</a></font></p>
		";
		else
		echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$_GET[id_auto]&id_page=$_GET[id_page]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=page&id_page=$_GET[id_page]]\">NON</a></font></p>
		";
		}
	  }
	 if (isset($_GET['del_confirmation'])) 
	 {
		// on efface le fichier
		if (file_exists($fichier)  and isset($_GET['del_fichier']) and  $_GET['del_fichier']=="ok")
		{
		unlink($fichier);
		message('Le fichier -'.$url.' a été supprimé définitivement');
		}
		// on fait le ménage dans la table
		$sql="DELETE FROM gc_contenu_auto WHERE id_auto='$_GET[id_auto]'";
		mysql_db_query($dbname,$sql,$id_link);	
	 	message('Le contenu automatique -'.$nom.'- de type -'.$type.$nom_division.'- a été supprimé définitivement de la base de données');
	 }
echo "<br>";
}

//fin : suppression du contenu automatique


//suppression d'une division et du contenu automatique associé à la division

if (isset($_GET['del_division']) and $_GET['del_division']=="ok")
{
	  $sql="select  nom_division  FROM gc_division_page where id_division='$_GET[id_division]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $nom_division=$rang['nom_division'];
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer la division -'.$nom_division.'- et le contenu ( html et automatique ) de cette division définitivement de la base de données .<br> Les fichiers du contenu automatique ne sont pas supprimés. ');
	  if ( isset($_GET['id_page_sous_titre']))
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=page&del_division=ok&id_division=$_GET[id_division]&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=page&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\">NON</a></font></p>
		";
	  else
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=page&del_division=ok&id_division=$_GET[id_division]&id_page=$_GET[id_page]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=page&id_page=$_GET[id_page]\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 {
	 	$sql="DELETE FROM gc_division_page WHERE id_division='$_GET[id_division]'";
		mysql_db_query($dbname,$sql,$id_link);
		$sql="DELETE FROM gc_contenu_auto WHERE id_division='$_GET[id_division]'";
		mysql_db_query($dbname,$sql,$id_link);	
	 	message('La division -'.$nom_division.'- et le contenu ( html et automatique ) de cette division ont été supprimés définitivement de la base de données');
	 }
echo "<br>";
}

//fin:suppression d'une division et du contenu automatique associé à la division

?>
		</td>
	  </tr>
	  <tr>
        <td>
			<?
			// affichage des sous titres
 		  	$sql="select  id_page,titre,classe  FROM gc_page where sous_titre_de='$_GET[id_page]' order by ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo "<table><tr>";
			while($rang=mysql_fetch_array($resultat))
			{
			$id_page_sous_titre1=$rang['id_page'];
			$sous_titre=$rang['titre'];
			$classe1=$rang['classe'];
			if ( isset($_GET['id_page_sous_titre']) and $id_page_sous_titre1==$_GET['id_page_sous_titre'])
			{
			if ($classe1<>"aucune restriction") sous_titre("<font size=\"1\">$classe1 :</font> $sous_titre","selection");
			else sous_titre("$sous_titre","selection");
			}
			
			
			else
			{
			if ($classe1<>"aucune restriction") sous_titre("<font size=\"1\">$classe1 :</font> $sous_titre","admi.php?page_admi=page&id_page=$_GET[id_page]&id_page_sous_titre=$id_page_sous_titre1");
			else sous_titre("$sous_titre","admi.php?page_admi=page&id_page=$_GET[id_page]&id_page_sous_titre=$id_page_sous_titre1");
			}

			}
			echo"</tr></table>";
						

		  	?>
	  </td>
      </tr>
    </table>
<?
			//affichage de la liste des divisions
			$sql="select  count(id_division)  FROM gc_division_page where id_page='$id_page_active'";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$nb=$rang[0];
			if ( $nb<>"0")
			{
			$sql="select  *  FROM gc_division_page where id_page='$id_page_active' ORDER BY ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo "<div align=\"center\"><form name=\"divisions\"><select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">";
			while($rang=mysql_fetch_array($resultat))
			{
			$id_division=$rang[id_division];
			$nom_division=$rang[nom_division];
			echo "<option value=\"#div$id_division\">$nom_division</option>";
			}
			echo "</select></div></form>";
			}
			?>
<?
//formulaire d'ajout et de modification : haut et bas de page
$sql="select  *  FROM gc_contenu_page where id_page='$id_page_active'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$haut=$rang['haut'];
$bas=$rang['bas'];

echo "<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">";
if (isset($haut)  or isset($bas))
{
if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_contenu=ok&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\">";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_contenu=ok&id_page=$_GET[id_page]\">";
echo "
	  <tr>
      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Modifier le contenu HTML en haut de la page et en bas de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">
		<input type=\"submit\" name=\"Submit2\" value=\"Modifier\">
        </font></td>
     </tr>
";
}
else
{
if ( isset($_GET['id_page_sous_titre']))
echo "	<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_contenu=ok&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\">";
else
echo "	<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_contenu=ok&id_page=$_GET[id_page]\">";
echo "
	  <tr>
      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Ajouter du contenu HTML en haut de la page et en bas de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">
        <input type=\"submit\" name=\"Submit2\" value=\"Ajouter\">
        </font></td>
     </tr>
	 ";
}
echo"
	  <tr>
      <td>
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">haut</font>
		  <textarea name=\"haut\" rows=\"8\" wrap=\"VIRTUAL\" cols=\"45\">$haut</textarea>
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">bas</font>
		  <textarea name=\"bas\" rows=\"8\" wrap=\"VIRTUAL\" cols=\"45\">$bas</textarea>
	 </td>
    </tr>

  </form>
</table>
<br>
";
//fin : formulaire d'ajout : haut et bas de page


//affichage haut de page
$haut=style($haut);
echo "<div align=\"center\"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong> Visualisation du contenu HTML en haut de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> </font></div>";
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$haut</font>";
echo "<hr>";
//fin : affichage haut de page


// formulaire d'ajout de contenu automatique dans la page
echo"
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
  <tr>
    <td >";
	
//les max pour les liens dans la page après un ajout
$sql="select max(id_auto) from gc_contenu_auto";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$max_id_auto=$rang['0']+1;
$sql="select max(id_division) from gc_division_page";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$max_id_division=$rang['0']+1;

if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_auto=ok&id_division=$id_page_active&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]#$max_id_auto\" enctype=\"multipart/form-data\">";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_auto=ok&id_division=$id_page_active&id_page=$_GET[id_page]#$max_id_auto\" enctype=\"multipart/form-data\">";
echo"
        <p><strong><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Ajouter du contenu automatique
           dans la page $titre : <input type=\"submit\" name=\"Submit\" value=\"Ajouter\"></font></strong> </p>
        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
      			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom </font></div></td>
				<td width=\"15%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">url ou chemin (1)</font></div></td>
      			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">url</font></div></td>
				<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">fichier (2) </font></div></td>
      			<td width=\"25%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu</font></div></td>
				<td width=\"10%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
      			<td width=\"3%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">page d'accueil</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">invisible</font></div></td>
		  </tr>
		  <tr>
            <td width=\"12%\"><div align=\"center\"><input name=\"nom_auto\" type=\"text\"  size=\"15\"></div></td>
			<td width=\"15%\"><div align=\"center\"><input name=\"dossier\" type=\"text\"  size=\"20\"></div></td>
			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"url\" type=\"checkbox\" value=\"1\" checked></font></div></td>
            <td width=\"20%\"><div align=\"center\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\"><input name=\"fichier_auto\" type=\"file\"  size=\"20\"></div></td>
            <td width=\"25%\"><div align=\"center\"><input name=\"contenu_auto\" type=\"text\"  size=\"30\"></div></td>
			<td width=\"10%\"><select name=\"type\" ><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>
            <td width=\"3%\"><div align=\"center\"><input name=\"ordre_auto\" type=\"text\"  size=\"2\"></div></td>
		  	<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\"></font></div></td>
			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\"></font></div></td>
		  	<input name=\"sans_division\" type=\"hidden\" value=\"1\">
		  </tr> 
        </table>
      </form>
    </td>
  </tr>
  <tr>
  	<td>
  	<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">(1) Option 1 : Indiquer éventuellement le chemin dans le dossier - documents - ( ex : 1s/cours ) . Option 2 : Indiquer l'url de téléchargement <br>
	(2) Option 1 : Choisir le fichier à télécharger . Option 2 : Ne rien faire </font>
  	</td>
  </tr>
</table>
<br>
";
// fin : formulaire d'ajout de contenu automatique

//affichage du contenu automatique et des formulaires de modification
$sql1="select  *  FROM gc_contenu_auto where id_division='$id_page_active' and sans_division='1' order by ordre";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_auto=$rang1['id_auto'];
$nom_auto=$rang1['nom'];
$url_auto=$rang1['url'];
$contenu_auto=$rang1['contenu'];
$ordre_auto=$rang1['ordre'];
$type=$rang1['type'];
$accueil=$rang1['accueil'];
echo "<br>";
echo "<a name=\"$id_auto\"></a>";
if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]#$id_auto\">
	<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
    <tr>
      			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=\"blank\">nom </a></font></div></td>
				<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">chemin et fichier</div></td>
				";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]#$id_auto\">
	<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
    <tr>
      			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=\"blank\">nom </a></font></div></td>
				<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">chemin et fichier </div></td>";
echo"     			
				<td width=\"35%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu</font></div></td>
				<td width=\"10%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
      			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">page d'accueil</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">invisible</font></div></td>
	</tr>
    <tr>
      <td width=\"20%\"><div align=\"center\">
          <input name=\"nom_auto\" type=\"text\"  value=\"$nom_auto\" size=\"15\">
        </div></td>
      <td width=\"20%\"><div align=\"center\">
          <input name=\"url_auto\" type=\"text\"  value=\"$url_auto\" size=\"40\">
        </div></td>
      <td width=\"40%\"><div align=\"center\">
          <input name=\"contenu_auto\" type=\"text\"  value=\"$contenu_auto\" size=\"40\">
        </div></td>
	  ";
		if ($type=="cours") echo "<td width=\"15%\"><select name=\"type\" ><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="TP") echo "<td width=\"15%\"><select name=\"type\" ><option>TP</option><option>cours</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="TD") echo "<td width=\"15%\"><select name=\"type\" ><option>TD</option><option>cours</option><option>TP</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="activité") echo "<td width=\"15%\"><select name=\"type\" ><option>activité</option><option>cours</option><option>TP</option><option>TD</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";		
		if ($type=="devoir") echo "<td width=\"15%\"><select name=\"type\" ><option>devoir</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="devoir maison") echo "<td width=\"15%\"><select name=\"type\" ><option>devoir maison</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";       
		if ($type=="interrogation") echo "<td width=\"15%\"><select name=\"type\" ><option>interrogation</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="animation") echo "<td width=\"15%\"><select name=\"type\" ><option>animation</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="révision") echo "<td width=\"15%\"><select name=\"type\" ><option>révision</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
        if ($type=="exercice") echo "<td width=\"15%\"><select name=\"type\" ><option>exercice</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="aucun") echo "<td width=\"15%\"><select name=\"type\" ><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option></select></td>";
	    if ($type=="document") echo "<td width=\"15%\"><select name=\"type\" ><option>document</option><option>exercice</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="en ligne") echo "<td width=\"15%\"><select name=\"type\" ><option>en ligne</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>salle info</option><option>aucun</option></select></td>";
	    if ($type=="salle info") echo "<td width=\"15%\"><select name=\"type\" ><option>salle info</option><option>en ligne</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>aucun</option></select></td>";
	      
	  echo"
	    </div></td>
	  <td width=\"5%\"><div align=\"center\">
          <input name=\"ordre_auto\" type=\"text\"  value=\"$ordre_auto\" size=\"2\"></div></td>";
	 if ($accueil=="0") 	echo "<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\"></font></div></td><td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\" ></font></div></td>";
     if ($accueil=="1") 	echo "<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\" checked></font></div></td><td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\" ></font></div></td>";
	 if ($accueil=="2") 	echo "<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\"></font></div></td><td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\" checked ></font></div></td>";
     echo"
	</tr>
  </table>
  <table width=\"100%\">
  <tr>";
  
if ( isset($_GET['id_page_sous_titre']))
{
echo "<td width=\"30%\"><div align=\"right\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\"> Suppresion de la base de données </a></font></div></td>";
if (file_exists($url_auto)) echo "<td width=\"30%\"><div align=\"left\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]&del_fichier=ok\">Cliquer ici pour supprimer aussi le fichier<a></font></div></td>";
}
else
{
echo "<td width=\"30%\"><div align=\"right\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]\">Suppresion de la base de données </a></font></div></td> ";
if (file_exists($url_auto)) echo "<td width=\"30%\"><div align=\"left\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&del_fichier=ok\">Cliquer ici pour supprimer aussi le fichier<a></font></div></td>";
}
echo"
   <td width=\"40%\"><input type=\"submit\" name=\"Submit\" value=\"Modifier\"></td>
  </tr>
  </table>
</form>
";
 
}
// fin : affichage du contenu automatique et des formulaires de modification dans la page



//formulaire d'ajout d'une division

echo "
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
";
if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_division=ok&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]#$max_id_division\">";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_division=ok&id_page=$_GET[id_page]#$max_id_division\">";
echo"	  <tr>
      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Ajouter une
        division : </strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">
        <input type=\"submit\" name=\"Submit2\" value=\"Ajouter\">
        </font></td>
     </tr>

	  <tr>
      <td>
	  	  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom de la division</font>
          <input name=\"nom_division\" type=\"text\" size=\"30\">
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font>
          <input type=\"text\" name=\"ordre_division\" size=\"1\" value=\"\">
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu HTML</font>
		  <textarea name=\"contenu_division\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"40\"></textarea>
	 </td>
    </tr>

  </form>
</table>
<br>
";

// affichage des divisions
$sql="select  *  FROM gc_division_page where id_page='$id_page_active' order by ordre ";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_division=$rang['id_division'];
$nom_division=$rang['nom_division'];
$contenu=$rang['contenu'];
$ordre=$rang['ordre'];
echo "<a name=\"div$id_division\"></a>";
if ( isset($_GET['id_page_sous_titre']))
titre_division(" $nom_division <a href=\"admi.php?page_admi=page&del_division=ok&id_division=$id_division&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>");
else
titre_division(" $nom_division <a href=\"admi.php?page_admi=page&del_division=ok&id_division=$id_division&id_page=$_GET[id_page]\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>");
echo "<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">";
if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_division=ok&id_division=$id_division&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]#div$id_division\">";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_division=ok&id_division=$id_division&id_page=$_GET[id_page]#div$id_division\">";
echo"
	  <tr>
      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Modifier la division $nom_division</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">
        <input type=\"submit\" name=\"Submit2\" value=\"Modifier\">
        </font></td>
     </tr>

	  <tr>
      <td>
	  	  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom de la division</font>
          <input name=\"nom_division\" type=\"text\" size=\"30\" value=\"$nom_division\">
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font>
          <input type=\"text\" name=\"ordre_division\" size=\"1\" value=\"$ordre\">
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu HTML</font>
		  <textarea name=\"contenu_division\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"60\">$contenu</textarea>
	 </td>
    </tr>

  </form>
</table>
";
$contenu=style($contenu);
echo "<div align=\"center\"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong> Visualisation du contenu HTML de la division $nom_division</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> </font></div>";
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$contenu</font>";
echo "<hr>";


 // formulaire d'ajout de contenu automatique dans la division
echo"
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
  <tr>
    <td >
";

if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_auto=ok&id_division=$id_division&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]#$max_id_auto\" enctype=\"multipart/form-data\">";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&ajout_auto=ok&id_division=$id_division&id_page=$_GET[id_page]#$max_id_auto\" enctype=\"multipart/form-data\">";
echo"       <p><strong><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Ajouter du contenu automatique
           dans la division $nom_division : <input type=\"submit\" name=\"Submit\" value=\"Ajouter\"></font></strong> </p>
        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
      			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom</font></div></td>
				<td width=\"15%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">url ou chemin (1)</font></div></td>
      			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">url</font></div></td>
				<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">fichier (2) </font></div></td>
      			<td width=\"25%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu</font></div></td>
				<td width=\"10%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
      			<td width=\"3%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">page d'accueil</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">invisible</font></div></td>
		  </tr>
		  <tr>
            <td width=\"12%\"><div align=\"center\"><input name=\"nom_auto\" type=\"text\"  size=\"15\"></div></td>
			<td width=\"15%\"><div align=\"center\"><input name=\"dossier\" type=\"text\"  size=\"20\"></div></td>
			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"url\" type=\"checkbox\" value=\"1\" checked></font></div></td>
            <td width=\"20%\"><div align=\"center\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\"><input name=\"fichier_auto\" type=\"file\"  size=\"20\"></div></td>
            <td width=\"25%\"><div align=\"center\"><input name=\"contenu_auto\" type=\"text\"  size=\"30\"></div></td>
			<td width=\"10%\"><select name=\"type\" ><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>
            <td width=\"3%\"><div align=\"center\"><input name=\"ordre_auto\" type=\"text\"  size=\"2\"></div></td>
		  	<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\"></font></div></td>
			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\"></font></div></td>
		  	<input name=\"sans_division\" type=\"hidden\" value=\"0\">
		  </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
  	<td>
  	<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">(1) Option 1 : Indiquer éventuellement le chemin dans le dossier - documents - ( ex : 1s/cours ) . Option 2 : Indiquer l'url de téléchargement <br>
	(2) Option 1 : Choisir le fichier à télécharger . Option 2 : Ne rien faire </font>
  	</td>
  </tr>
</table>
<br>
";
// fin : formulaire d'ajout de contenu automatique

//affichage du contenu automatique et des formulaires de modification
$sql1="select  *  FROM gc_contenu_auto where id_division='$id_division' and sans_division='0' order by ordre";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_auto=$rang1['id_auto'];
$nom_auto=$rang1['nom'];
$url_auto=$rang1['url'];
$contenu_auto=$rang1['contenu'];
$ordre_auto=$rang1['ordre'];
$type=$rang1['type'];
$accueil=$rang1['accueil'];
echo "<br>";
echo "<a name=\"$id_auto\"></a>";


if ( isset($_GET['id_page_sous_titre']))
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]#$id_auto\">";
else
echo "<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=page&modif_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]#$id_auto\">";
echo"
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
    <tr>
      			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=\"blank\">nom </a></font></div></td>
      			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">chemin et fichier </div></td>
      			<td width=\"35%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu</font></div></td>
				<td width=\"10%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
      			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">page d'accueil</font></div></td>
				<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">invisible</font></div></td>
	</tr>
    <tr>
      <td width=\"20%\"><div align=\"center\">
          <input name=\"nom_auto\" type=\"text\"  value=\"$nom_auto\" size=\"15\">
        </div></td>
      <td width=\"20%\"><div align=\"center\">
          <input name=\"url_auto\" type=\"text\"  value=\"$url_auto\" size=\"40\">
        </div></td>
      <td width=\"40%\"><div align=\"center\">
          <input name=\"contenu_auto\" type=\"text\"  value=\"$contenu_auto\" size=\"40\">
        </div></td>
	  ";
		if ($type=="cours") echo "<td width=\"15%\"><select name=\"type\" ><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="TP") echo "<td width=\"15%\"><select name=\"type\" ><option>TP</option><option>cours</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="TD") echo "<td width=\"15%\"><select name=\"type\" ><option>TD</option><option>cours</option><option>TP</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="activité") echo "<td width=\"15%\"><select name=\"type\" ><option>activité</option><option>cours</option><option>TP</option><option>TD</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";		
		if ($type=="devoir") echo "<td width=\"15%\"><select name=\"type\" ><option>devoir</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="devoir maison") echo "<td width=\"15%\"><select name=\"type\" ><option>devoir maison</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";       
		if ($type=="interrogation") echo "<td width=\"15%\"><select name=\"type\" ><option>interrogation</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="animation") echo "<td width=\"15%\"><select name=\"type\" ><option>animation</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="révision") echo "<td width=\"15%\"><select name=\"type\" ><option>révision</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
        if ($type=="exercice") echo "<td width=\"15%\"><select name=\"type\" ><option>exercice</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>document</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="aucun") echo "<td width=\"15%\"><select name=\"type\" ><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>en ligne</option><option>salle info</option></select></td>";
	    if ($type=="document") echo "<td width=\"15%\"><select name=\"type\" ><option>document</option><option>exercice</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>en ligne</option><option>salle info</option><option>aucun</option></select></td>";
		if ($type=="en ligne") echo "<td width=\"15%\"><select name=\"type\" ><option>en ligne</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>salle info</option><option>aucun</option></select></td>";
	    if ($type=="salle info") echo "<td width=\"15%\"><select name=\"type\" ><option>salle info</option><option>en ligne</option><option>cours</option><option>TP</option><option>TD</option><option>activité</option><option>devoir</option><option>devoir maison</option><option>interrogation</option><option>animation</option><option>révision</option><option>exercice</option><option>document</option><option>aucun</option></select></td>";
	    
	  echo"
	    </div></td>
	  <td width=\"5%\"><div align=\"center\">
          <input name=\"ordre_auto\" type=\"text\"  value=\"$ordre_auto\" size=\"2\"></div></td>";
	 if ($accueil=="0") 	echo "<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\"></font></div></td><td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\" ></font></div></td>";
     if ($accueil=="1") 	echo "<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\" checked></font></div></td><td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\" ></font></div></td>";
	 if ($accueil=="2") 	echo "<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"accueil\" type=\"checkbox\" value=\"1\"></font></div></td><td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> <input name=\"invisible\" type=\"checkbox\" value=\"1\" checked ></font></div></td>";
     echo"
	</tr>
  </table>
  <table width=\"100%\">
  <tr>";
  
if ( isset($_GET['id_page_sous_titre']))
{
echo "<td width=\"30%\"><div align=\"right\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]\"> Suppresion de la base de données </a></font></div></td>";
if (file_exists($url_auto)) echo "<td width=\"30%\"><div align=\"left\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&id_page_sous_titre=$_GET[id_page_sous_titre]&del_fichier=ok\">Cliquer ici pour supprimer aussi le fichier<a></font></div></td>";
}
else
{
echo "<td width=\"30%\"><div align=\"right\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]\">Suppresion de la base de données </a></font></div></td> ";
if (file_exists($url_auto)) echo "<td width=\"30%\"><div align=\"left\"> <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=page&del_auto=ok&id_auto=$id_auto&id_page=$_GET[id_page]&del_fichier=ok\">Cliquer ici pour supprimer aussi le fichier<a></font></div></td>";
}
echo"
   <td width=\"40%\"><input type=\"submit\" name=\"Submit\" value=\"Modifier\"></td>
  </tr>
  </table>
</form>
";
}

// fin : affichage du contenu automatique et des formulaires de modification dans la division

}

// fin : affichage des divisions



//affichage bas de page
$bas=style($bas);
echo "<div align=\"center\"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong> Visualisation du contenu HTML en bas de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> </font></div>";

echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$bas</font><hr>";

			message('- Deux options pour le contenu automatique : <br>option 1 :  vous pouvez télécharger ( avec Gest\'classe ) un fichier dans le dossier - documents - en précisant éventuellement le chemin d\'accès à ce fichier et en utilisant le bouton - parcourir -.<br>
			option 2 :  Vous pouvez préciser une url de téléchargement vers un fichier déjà existant ou téléchargé en utilisant un logiciel ftp ou à partir de la rubrique - Gérer le dossier documents - ( dans ce cas il faut cocher l\'onglet - url - )<br>- Pour la suppression d\'un fichier, il est possible de choisir l\'option : - Cliquer ici pour supprimer aussi le fichier - ( en même temps que le lien du contenu automatique ) . Vous pouvez aussi supprimer, renommer ou déplacer  un fichier à partir de la rubrique - Gérer le dossier documents - <br> - L\'onglet - page d\'accueil - permet d\'afficher le contenu automatique sur la page d\'accueil.<br> - L\'onglet - invisible - permet de ne pas afficher le contenu automatique dans le site ( partie commune ).<br>- Attention, la gestion des fichiers peut être inutilisable sur certains serveurs ... dans ce cas,il faut utiliser un logiciel ftp.');


//fin : affichage bas de page
?>
