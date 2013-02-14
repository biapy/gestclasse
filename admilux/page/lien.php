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

titre_page("Gestion des liens");
echo"<br>";
// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


//formatage des textes
if (isset($_POST['haut'])) $_POST['haut']=texte($_POST['haut']);
if (isset($_POST['bas'])) $_POST['bas']=texte($_POST['bas']);
if (isset($_POST['nom_lien'])) $_POST['nom_lien']=texte($_POST['nom_lien']);
if (isset($_POST['url'])) $_POST['url']=texte($_POST['url']);
if (isset($_POST['descriptif'])) $_POST['descriptif']=texte($_POST['descriptif']);
if (isset($_POST['nom_division'])) $_POST['nom_division']=texte($_POST['nom_division']);
if (isset($_POST['contenu_division'])) $_POST['contenu_division']=texte($_POST['contenu_division']);

//Modification contenu : haut et bas de page
if ( isset($_GET['modif_contenu']) and $_GET['modif_contenu']=="ok")
{
$sql="UPDATE gc_contenu_page SET  haut='$_POST[haut]',bas='$_POST[bas]' where id_page='1000'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout contenu : haut et bas de page
if ( isset($_GET['ajout_contenu']) and  $_GET['ajout_contenu']=="ok")
{
$sql="INSERT INTO gc_contenu_page( haut, bas, id_page ) VALUES ('$_POST[haut]','$_POST[bas]', '1000')";
mysql_db_query($dbname,$sql,$id_link);
};

//Modification du lien
if ( isset($_GET['modif_lien']) and $_GET['modif_lien']=="ok")
{
$sql="UPDATE gc_lien SET  nom='$_POST[nom_lien]',url='$_POST[url]',descriptif='$_POST[descriptif]',ordre='$_POST[ordre_lien]' where id_lien='$_GET[id_lien]'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout d'un lien
if ( isset($_GET['ajout_lien']) and $_GET['ajout_lien']=="ok")
{
$sql="INSERT INTO gc_lien( nom, url, descriptif, ordre, id_division ) VALUES ('$_POST[nom_lien]','$_POST[url]', '$_POST[descriptif]','$_POST[ordre_lien]','$_GET[id_division]' )";
mysql_db_query($dbname,$sql,$id_link);
};


//suppression d'un lien

if (isset($_GET['del_lien']) and $_GET['del_lien']=="ok")
{
	  $sql="select  nom,url  FROM gc_lien where id_lien='$_GET[id_lien]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $nom=$rang['nom'];
	  $url=$rang['url'];
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer le lien '.$nom.' : '.$url.' définitivement de la base de données ');
	  
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=lien&del_lien=ok&id_lien=$_GET[id_lien]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=lien\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 {
	 	$sql="DELETE FROM gc_lien WHERE id_lien='$_GET[id_lien]'";
		mysql_db_query($dbname,$sql,$id_link);	
	 	message('Le lien '.$nom.' : '.$url.' a été supprimé définitivement de la base de données');
	 }
}


//Modification d'une division
if ( isset($_GET['modif_division']) and $_GET['modif_division']=="ok")
{
$sql="UPDATE gc_division_page SET  nom_division='$_POST[nom_division]',id_page='1000',ordre='$_POST[ordre_division]',contenu='$_POST[contenu_division]' where id_division='$_GET[id_division]'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout d'une division
if ( isset($_GET['ajout_division']) and $_GET['ajout_division']=="ok")
{
$sql="INSERT INTO gc_division_page( nom_division, id_page, ordre, contenu ) VALUES ('$_POST[nom_division]','1000', '$_POST[ordre_division]','$_POST[contenu_division]' )";
mysql_db_query($dbname,$sql,$id_link);
};


//suppression d'une division et des liens associés à la division

if (isset($_GET['del_division']) and $_GET['del_division']=="ok")
{
	  $sql="select  nom_division  FROM gc_division_page where id_division='$_GET[id_division]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $nom_division=$rang['nom_division'];
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer la division '.$nom_division.' et les liens associés à cette division définitivement de la base de données ');
	  
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=lien&del_division=ok&id_division=$_GET[id_division]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=lien\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 {
	 	$sql="DELETE FROM gc_division_page WHERE id_division='$_GET[id_division]'";
		mysql_db_query($dbname,$sql,$id_link); 
		$sql="DELETE FROM gc_lien WHERE id_division='$_GET[id_division]'";
		mysql_db_query($dbname,$sql,$id_link); 	
	 	message('La divion '.$nom_division.' et les liens associés à cette division ont été supprimés définitivement de la base de données');
	 }
}

//les max pour les liens dasn la page après un ajout
$sql="select max(id_lien) from gc_lien";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$max_id_lien=$rang['0']+1;

$sql="select max(id_division) from gc_division_page";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$max_id_division=$rang['0']+1;

			//affichage de la liste des divisions		
			$sql="select  count(id_division)  FROM gc_division_page where id_page='1000'";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$nb=$rang[0];
			if ( $nb<>"0")
			{
			$sql="select  *  FROM gc_division_page where id_page='1000' ORDER BY ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo "<div align=\"center\"><form name=\"divisions\"><select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">";
			while($rang=mysql_fetch_array($resultat))
			{
			$id_division=$rang[id_division];
			$nom_division=$rang[nom_division];
			echo "<option value=\"#$id_division\">$nom_division</option>";
			}
			echo "</select></div></form>";
			}
			//fin : affichage de la liste des divisions

//formulaire d'ajout et de modification : haut et bas de page
$sql="select  *  FROM gc_contenu_page where id_page='1000'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$haut=$rang['haut'];
$bas=$rang['bas'];

echo "<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">";
if (isset($haut)  or isset($bas)) 
{
echo "
	<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=lien&modif_contenu=ok\">
	  <tr> 
      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Modifier le contenu HTML en haut de la page et en bas de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
        <input type=\"submit\" name=\"Submit2\" value=\"Modifier\">
        </font></td>
     </tr>
";
}
else 
{
echo "
	 <form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=lien&ajout_contenu=ok\">
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
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu HTML haut</font> 
		  <textarea name=\"haut\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"40\">$haut</textarea>
		  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">contenu HTML bas</font> 
		  <textarea name=\"bas\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"40\">$bas</textarea>
	 </td>
    </tr>

  </form>
</table>
<br>
";
//fin : formulaire d'ajout : haut et bas de page

//affichage haut de page

$haut1=style($haut);
echo "<div align=\"center\"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong> Visualisation du contenu HTML en haut de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> </font></div>";
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$haut1</font>";
echo "<hr>";
//fin : affichage haut de page

//formulaire d'ajout d'une division

echo "
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
    <form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=lien&ajout_division=ok#$max_id_division\">
	  <tr> 
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
		  <textarea name=\"contenu_division\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"60\"></textarea>
	 </td>
    </tr>

  </form>
</table>
<br>
";

// affichage des divisions
$sql="select  *  FROM gc_division_page where id_page='1000' order by ordre ";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_division=$rang['id_division'];
$nom_division=$rang['nom_division'];
$contenu=$rang['contenu'];
$contenu1=style($rang['contenu']);
$ordre=$rang['ordre'];
echo "<a name=\"$id_division\"></a>";
titre_division(" $nom_division <a href=\"admi.php?page_admi=lien&del_division=ok&id_division=$id_division\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>");
echo "
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
    <form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=lien&modif_division=ok&id_division=$id_division#$id_division\">
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
<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$contenu1</font>
<br>
";


 // formulaire d'ajout d'un lien
echo"
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
  <tr>
    <td >
<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=lien&ajout_lien=ok&id_division=$id_division#$max_id_lien\">
        <p><strong><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Ajouter un 
          lien dans la division $nom_division : <input type=\"submit\" name=\"Submit\" value=\"Ajouter\"></font></strong> </p>
        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr> 
      			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom</font></div></td>
      			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">url</font></div></td>
      			<td width=\"55%\"><div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">descriptif</font></div></td>
      			<td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font></div></td>
		  </tr>
		  <tr>
            <td width=\"20%\"><div align=\"center\"><input name=\"nom_lien\" type=\"text\"  size=\"20\"></div></td>
            <td width=\"25%\"><div align=\"center\"><input name=\"url\" type=\"text\"  size=\"25\"></div></td>
			<td width=\"55%\"><textarea name=\"descriptif\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"50\"></textarea></td>
            <td width=\"5%\"><div align=\"center\"><input name=\"ordre_lien\" type=\"text\"  size=\"2\"></div></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
<br>
";
// fin formulaire d'ajout d'un lien

//affichage des liens et des formulaires de modification
$sql1="select  *  FROM gc_lien where id_division='$id_division' order by ordre";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_lien=$rang1['id_lien'];
$nom_lien=$rang1['nom'];
$url=$rang1['url'];
$descriptif=$rang1['descriptif'];
$descriptif1=style($rang1['descriptif']);
$ordre_lien=$rang1['ordre'];

echo
"
<a name=\"$id_lien\"></a>
<table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" >
  <tr bgcolor=\"#$couleur1\"> 
    <td ><div align=\"left\"><img src=\"images/config/lien.gif\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url\" target=\"blank\">$nom_lien</a></td>
  </tr>
   <tr bgcolor=\"#$couleur1\"> 
    <td ><div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=lien&del_lien=ok&id_lien=$id_lien\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a> $descriptif1</td>
  </tr>
</table>
<br>

<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=lien&modif_lien=ok&id_lien=$id_lien#$id_lien\">
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
    <tr> 
      <td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">nom</font></div></td>
      <td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">url</font></div></td>
      <td width=\"55%\"><div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">descriptif</font></div></td>
      <td width=\"5%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font></div></td>
    </tr>
    <tr> 
      <td width=\"20%\"><div align=\"center\">
          <input name=\"nom_lien\" type=\"text\"  value=\"$nom_lien\" size=\"20\">
        </div></td>
      <td width=\"20%\"><div align=\"center\">
          <input name=\"url\" type=\"text\"  value=\"$url\" size=\"25\">
        </div></td>

     <td width=\"55%\"><textarea name=\"descriptif\" rows=\"4\" wrap=\"VIRTUAL\" cols=\"50\">$descriptif</textarea></td>
      <td width=\"5%\"><div align=\"center\">
          <input name=\"ordre_lien\" type=\"text\"  value=\"$ordre_lien\" size=\"2\">
        </div></td>
    </tr>
  </table>
  <p align=\"center\"> 
    <input type=\"submit\" name=\"Submit\" value=\"Modifier\">
  </p>
</form>



";
}
// fin affichage des liens et des formulaires de modification 

}

// fin affichage des divisions

//affichage bas de page
$bas1=style($bas);
echo "<div align=\"center\"> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong> Visualisation du contenu HTML en bas de la page</strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> </font></div>";
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$bas1</font>";
echo "<hr>";

//fin : affichage bas de page
?>