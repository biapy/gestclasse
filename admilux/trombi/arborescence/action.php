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
session_start();
include("../../../commun/fonction.php");
include("../../../commun/connect.php");
?>

<link href="../../../commun/style.css" rel="stylesheet" type="text/css"> 

<body bgcolor="#F2F2F2" >
<div align="center"><font size="3" face="Arial, Helvetica, sans-serif" >Gestion du dossier photo_classe</font></div>
<br>
<?
// protection 


if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

if (isset($_GET['fichier'])) 
{
$fichier_affichage=substr($_GET['fichier'],19);
$extension=strRpos($fichier_affichage,".");
$id_eleve=substr($fichier_affichage,0,$extension);


$sql="select  nom,prenom,classe  FROM gc_eleve where id_eleve='$id_eleve'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$nom=$rang['nom'];
$prenom=$rang['prenom'];
$classe=$rang['classe'];
		
if (!file_exists($_GET['fichier']))
	{
	message3("L'image spécifié n'existe pas... actualisez l'arborescence du dossier document");
	exit();
    }

}



//Renommer une image 
if ( isset($_GET['action']) and ($_GET['action']=="renommer_fichier" ))
{
	if (!(file_exists($_GET['fichier']))) message3("L'image $_GET[fichier] n'existe pas . Sélectionnez une image valide ");
	else 
	{
	$nouveau_nom1=$_POST['nouveau_nom'];
	$pos=strRpos($_POST['nouveau_nom'],"/");
	$_POST['nouveau_nom']="../../photo_classe/".$_POST['nouveau_nom'];


	$pos_nouvelle_extension=strRpos($_POST['nouveau_nom'],".");
	$nouvelle_extension=substr($_POST['nouveau_nom'],$pos_nouvelle_extension);

	$pos_ancienne_extension=strRpos($_GET['fichier'],".");
	$ancienne_extension=substr($_GET['fichier'],$pos_ancienne_extension);

	if($nouvelle_extension==$ancienne_extension)
	{
			if( $pos=='0')
			{
				if (file_exists($_POST['nouveau_nom'])) message3("L'image  - $nouveau_nom1 - existe déjà");
				else
				{
					if(rename($_GET['fichier'],$_POST['nouveau_nom'])) 
						{
						message3("L'image  - $fichier_affichage - a été renommé - $nouveau_nom1 - ");
						$_GET['fichier']=$_POST['nouveau_nom'];
						$fichier_affichage=substr($_GET['fichier'],9);
						}
					else message3("Impossible de renommer l'image - $_GET[fichier] - ");
				}
			}
			else message3("Le chemin n'est pas valide");
	}
	else message3("Il ne faut pas changer l'extension du fichier");
	}
}
//fin : renommer une image


//Supprimer une image
if ( isset($_GET['action']) and $_GET['action']=="del_fichier" )
{
if(isset($_GET['del_fichier_confirmation']) and $_GET['del_fichier_confirmation']='ok')
{
	if (file_exists($_GET['fichier']))
	{	
	if(unlink($_GET['fichier'])) message3("L'image  - $fichier_affichage - a été supprimé définitivement");
	else message3("Impossible de supprimer l'image - $fichier_affichage - ");
	}
	else
	message3("L'image  - $fichier_affichage - n'existe pas");
}
else
{
message3("voulez-vous vraiment supprimer l'image $fichier_affichage définitivement");
echo"
<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../../images/config/lien.gif\"  align=\"absmiddle\"><a href=\"action.php?action=del_fichier&fichier=$_GET[fichier]&del_fichier_confirmation=ok\">OUI</a></font>
<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../../images/config/lien.gif\" align=\"absmiddle\"><a href=\"action.php\">NON</a></font></p>
";
}
}
//fin : supprimer une image

//ajouter une image
if (  isset($_GET['action']) and $_GET['action']=="ajouter_fichier"  )
	{
	$content_dir = "../../photo_classe/";// dossier où sera déplacé l'image
    $tmp_file = $_FILES['fichier_auto']['tmp_name'];
		if( !is_uploaded_file($tmp_file) )
    	{
        message3("L'image $tmp_file est introuvable ");
		
		exit();
    	}

    // on vérifie maintenant l'extension
    $name_file = $_FILES['fichier_auto']['name'];
	$pos_extension=strRpos($name_file,".");
	$extension=substr($name_file,$pos_extension);
	if ($extension<>".jpg")
	{
        message3("Le fichier n'est pas une image .jpg");
		
		exit();
    }

    // on copie l'image dans le dossier de destination
    
	$name_file1 = $_FILES['fichier_auto']['name'];
	$name_file=$content_dir ."/". $name_file;

		if (file_exists($name_file))
		{
		message3("L'image spécifié existe déjà...");
		
		exit();
    	}

		if( !move_uploaded_file($tmp_file, $name_file) )
    	{
        message3("Impossible de copier l'image dans $content_dir");
		
		exit();
    	}
		else message3("L'image $name_file1 a été téléchargé dans le dossier - photo_classe -");
	}
//fin : ajouter une image


//formulaire pour les actions sur les fichiers
if (isset($_GET['fichier']) and !isset($_GET['del_fichier_confirmation']))
{
echo"
<table width=\"90%\" align=\"center\" bgcolor=\"#F4F4F4\" border=\"0\"><tr ><td class=\"bordure\">
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >
<p><img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Supprimer 
  l'image : $fichier_affichage <a href=\"action.php?action=del_fichier&fichier=$_GET[fichier]\"><img src=\"../../../images/config/pdel.gif\" align=\"absmiddle\" border=\"0\"></a></p>
<form name=\"form1\" method=\"post\" action=\"action.php?action=renommer_fichier&fichier=$_GET[fichier]\">
  <img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Renommer ou déplacer l'image : $fichier_affichage <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nouveau chemin : 
  <input name=\"nouveau_nom\" size=\"50\" type=\"text\" id=\"nouveau_nom\" value=\"$fichier_affichage\" >
  <input type=\"submit\" name=\"Submit\" value=\"Renommer\">
</form>
<p><div align=\"center\"><img src=\"$_GET[fichier]\" > <font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >$classe : $nom $prenom</font></div></p>
</td></tr></table>
</font>
";
}
echo"<br><br><br>
<table width=\"90%\" align=\"center\" bgcolor=\"#F4F4F4\" border=\"0\"><tr ><td class=\"bordure\">
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >
<form name=\"form1\" method=\"post\" action=\"action.php?action=ajouter_fichier\" enctype=\"multipart/form-data\">
  <img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Télécharger une image dans le dossier <br>
  <input name=\"fichier_auto\" type=\"file\"  size=\"20\">
  <input type=\"submit\" name=\"Submit2\" value=\"Télécharger\">
</form>
</font>
</td></tr></table>
";
echo"<br><br>";
message3("- Pour visualiser, supprimer ou renommer une image, s&eacute;lectionnez l'image concern&eacute;e.<br>
  - Extension acceptée pour les téléchargements : .jpg <br>
- Les photos doivent se présenter sous la forme identifiant.jpg ( ex 123.jpg )
<br>- Les attributs de taille ont été supprimés des balises. Il est bien sûr préférable que les photos aient la même dimension : 100 par 75 donne un bon résultat  
 ");

?>
