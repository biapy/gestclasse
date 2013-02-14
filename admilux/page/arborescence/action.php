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
?>

<link href="../../../commun/style.css" rel="stylesheet" type="text/css"> 

<body bgcolor="#F2F2F2" >
<div align="center"><font size="3" face="Arial, Helvetica, sans-serif" >Gestion du dossier documents</font></div>
<br>
<?
// protection 


if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

if (isset($_GET['dossier'])) 
{
$dossier_affichage=substr($_GET['dossier'],9);
if (!file_exists($_GET['dossier']))
	{
	message3("Le dossier spécifié n'existe pas... actualisez l'arborescence du dossier document");
	exit();
    }
}
if (isset($_GET['fichier'])) 
{
$fichier_affichage=substr($_GET['fichier'],9);
if (!file_exists($_GET['fichier']))
	{
	message3("Le fichier spécifié n'existe pas... actualisez l'arborescence du dossier document");
	exit();
    }
}
//Créer un nouveau dossier
if ( isset($_GET['action']) and $_GET['action']=="creer" )
{
if ( $_GET['dossier']=="../../../documents/" ) $nouveau_dossier=$_GET['dossier'].$_POST['nouveau_dossier'];
else $nouveau_dossier=$_GET['dossier']."/".$_POST['nouveau_dossier'];

if (file_exists($nouveau_dossier)) message3("Le dossier  - $nouveau_dossier - existe déjà");
else
{
if(mkdir($nouveau_dossier)) message3("Le dossier  - $nouveau_dossier - a été créer");
else message3("Impossible de créer le dossier - $nouveau_dossier - . Le répertoire n'est peut_être pas vide ");
}
}
//fin : créer un nouveau dossier

//Renommer un dossier 
if ( isset($_GET['action']) and ($_GET['action']=="renommer_dossier" ))
{
if ( $_GET['dossier']=="../../../documents/" ) message3("Vous ne pouvez pas renommer le dossier - documents -");
else if (!(file_exists($_GET['dossier']))) message3("Le dossier $_GET[dossier] n'existe pas . Sélectionnez un dossier valide ");
else 
{
$nouveau_nom1=$_POST['nouveau_nom'];
$_POST['nouveau_nom']="../../../".$_POST['nouveau_nom'];
$pos=strRpos($_POST['nouveau_nom'],"/");
$chemin=substr($_POST['nouveau_nom'],0,$pos);
$pos_document=substr($_POST['nouveau_nom'],0,19);

if( file_exists($chemin) and $pos_document=="../../../documents/")
{
if (file_exists($_POST['nouveau_nom'])) message3("Le dossier  - $nouveau_nom1 - existe déjà");
else
{
if(rename($_GET['dossier'],$_POST['nouveau_nom'])) 
	{
	message3("Le dossier  - $dossier_affichage - a été renommé - $nouveau_nom1 - ");
	$_GET['dossier']=$_POST['nouveau_nom'];
	$dossier_affichage=substr($_GET['dossier'],9);
	}
else message3("Impossible de renommer le dossier - $_GET[dossier] - ");
}
}
else message3("Le chemin n'est pas valide");
}
}
//fin : renommer un dossier

//Renommer un fichier 
if ( isset($_GET['action']) and ($_GET['action']=="renommer_fichier" ))
{
	if (!(file_exists($_GET['fichier']))) message3("Le fichier $_GET[fichier] n'existe pas . Sélectionnez un fichier valide ");
	else 
	{
	$nouveau_nom1=$_POST['nouveau_nom'];
	$_POST['nouveau_nom']="../../../".$_POST['nouveau_nom'];
	$pos=strRpos($_POST['nouveau_nom'],"/");
	$chemin=substr($_POST['nouveau_nom'],0,$pos);
	$pos_document=substr($_POST['nouveau_nom'],0,19);

	$pos_nouvelle_extension=strRpos($_POST['nouveau_nom'],".");
	$nouvelle_extension=substr($_POST['nouveau_nom'],$pos_nouvelle_extension);

	$pos_ancienne_extension=strRpos($_GET['fichier'],".");
	$ancienne_extension=substr($_GET['fichier'],$pos_ancienne_extension);

	if($nouvelle_extension==$ancienne_extension)
	{
			if( file_exists($chemin) and $pos_document=="../../../documents/")
			{
				if (file_exists($_POST['nouveau_nom'])) message3("Le fichier  - $nouveau_nom1 - existe déjà");
				else
				{
					if(rename($_GET['fichier'],$_POST['nouveau_nom'])) 
						{
						message3("Le fichier  - $fichier_affichage - a été renommé - $nouveau_nom1 - ");
						$_GET['fichier']=$_POST['nouveau_nom'];
						$fichier_affichage=substr($_GET['fichier'],9);
						}
					else message3("Impossible de renommer le fichier - $_GET[fichier] - ");
				}
			}
			else message3("Le chemin n'est pas valide");
	}
	else message3("Il ne faut pas changer l'extension du fichier");
	}
}
//fin : renommer un fichier

//Supprimer un  dossier
if ( isset($_GET['action']) and $_GET['action']=="del_dossier" )
{
if($_GET['dossier']=="../../../documents/")
		{
 		message3("Vous ne pouvez pas supprimer ce dossier");
		
		exit();
    	}
if(isset($_GET['del_dossier_confirmation']) and $_GET['del_dossier_confirmation']='ok')
{
	if (file_exists($_GET['dossier']))
	{
	$cpt=1;
	$rep=opendir($_GET['dossier']);
		 while($nomfichier=@readdir($rep))
			{
			$cpt++;
			}
	closedir($rep);
	if ($cpt<=3)
	{	
	if(rmdir($_GET['dossier'])) message3("Le dossier  - $dossier_affichage - a été supprimé définitivement");
	else message3("Impossible de supprimer le dossier - $dossier_affichage - ");
	}
	else
	message3("Le dossier  - $dossier_affichage - n'a pas été supprimé . Il n'est pas vide"); 
	}
	else
	message3("Le dossier  - $dossier_affichage - n'existe pas");
}
else
{
message3("voulez-vous vraiment supprimer le dossier $dossier_affichage définitivement");
echo"
<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../../images/config/lien.gif\"  align=\"absmiddle\"><a href=\"action.php?action=del_dossier&dossier=$_GET[dossier]&del_dossier_confirmation=ok\">OUI</a></font>
<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../../images/config/lien.gif\" align=\"absmiddle\"><a href=\"action.php\">NON</a></font></p>
";
}
}
//fin : supprimer un dossier

//Supprimer un  fichier
if ( isset($_GET['action']) and $_GET['action']=="del_fichier" )
{
if(isset($_GET['del_fichier_confirmation']) and $_GET['del_fichier_confirmation']='ok')
{
	if (file_exists($_GET['fichier']))
	{	
	if(unlink($_GET['fichier'])) message3("Le fichier  - $fichier_affichage - a été supprimé définitivement");
	else message3("Impossible de supprimer le fichier - $fichier_affichage - ");
	}
	else
	message3("Le fichier  - $fichier_affichage - n'existe pas");
}
else
{
message3("voulez-vous vraiment supprimer le fichier $fichier_affichage définitivement");
echo"
<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../../images/config/lien.gif\"  align=\"absmiddle\"><a href=\"action.php?action=del_fichier&fichier=$_GET[fichier]&del_fichier_confirmation=ok\">OUI</a></font>
<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../../images/config/lien.gif\" align=\"absmiddle\"><a href=\"action.php\">NON</a></font></p>
";
}
}
//fin : supprimer un fichier

//ajouter un fichier
if (  isset($_GET['action']) and $_GET['action']=="ajouter_fichier"  )
	{
	$content_dir = $_GET['dossier'];// dossier où sera déplacé le fichier
    $tmp_file = $_FILES['fichier_auto']['tmp_name'];
		if( !is_uploaded_file($tmp_file) )
    	{
        message3("Le fichier $tmp_file est introuvable ");
		
		exit();
    	}

    // on vérifie maintenant l'extension
    $name_file = $_FILES['fichier_auto']['name'];
	$pos_extension=strRpos($name_file,".");
	$extension=substr($name_file,$pos_extension);
	if ($extension==".php" or $extension==".exe" )
	{
        message3("Le fichier n'est pas un document");
		
		exit();
    }

    // on copie le fichier dans le dossier de destination
    
	$name_file1 = $_FILES['fichier_auto']['name'];
	$name_file=$content_dir ."/". $name_file;

		if (file_exists($name_file))
		{
		message3("Le fichier spécifié existe déjà...");
		
		exit();
    	}

		if( !move_uploaded_file($tmp_file, $name_file) )
    	{
        message3("Impossible de copier le fichier dans $content_dir");
		
		exit();
    	}
		else message3("Le fichier $name_file1 a été téléchargé dans le dossier $dossier_affichage");
	}
//fin : ajouter un fichier

//formulaire pour les actions sur les dossiers
if (isset($_GET['dossier']) and !isset($_GET['del_dossier_confirmation']))
{
echo"
<table width=\"90%\" align=\"center\" bgcolor=\"#F4F4F4\" border=\"0\"><tr ><td class=\"bordure\">
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >
<p><img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Supprimer 
  le dossier : $dossier_affichage <a href=\"action.php?action=del_dossier&dossier=$_GET[dossier]\"><img src=\"../../../images/config/pdel.gif\" align=\"absmiddle\" border=\"0\"></a> ( Le dossier doit être vide )</p>
<form name=\"form1\" method=\"post\" action=\"action.php?action=renommer_dossier&dossier=$_GET[dossier]\">
  <img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Renommer ou déplacer le 
  dossier : $dossier_affichage <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nouveau chemin : 
  <input name=\"nouveau_nom\" size=\"50\" type=\"text\" id=\"nouveau_nom\" value=\"$dossier_affichage\" >
  <input type=\"submit\" name=\"Submit\" value=\"Renommer\">
</form>
<form name=\"form1\" method=\"post\" action=\"action.php?action=creer&dossier=$_GET[dossier]\">
  <img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Cr&eacute;er 
  un nouveau dossier dans le dossier : $dossier_affichage <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nouveau dossier : 
  <input name=\"nouveau_dossier\" type=\"text\" id=\"nouveau_dossier\">
  <input type=\"submit\" name=\"Submit2\" value=\"Cr&eacute;er\">
</form>
<form name=\"form1\" method=\"post\" action=\"action.php?action=ajouter_fichier&dossier=$_GET[dossier]\" enctype=\"multipart/form-data\">
  <img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Télécharger un fichier dans le dossier : $dossier_affichage <br> 
  <input name=\"fichier_auto\" type=\"file\"  size=\"20\">
  <input type=\"submit\" name=\"Submit2\" value=\"Télécharger\">
</form>
</font>
</td></tr></table>
";
}

//formulaire pour les actions sur les fichiers
if (isset($_GET['fichier']) and !isset($_GET['del_fichier_confirmation']))
{
echo"
<table width=\"90%\" align=\"center\" bgcolor=\"#F4F4F4\" border=\"0\"><tr ><td class=\"bordure\">
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >
<p><img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Supprimer 
  le fichier : $fichier_affichage <a href=\"action.php?action=del_fichier&fichier=$_GET[fichier]\"><img src=\"../../../images/config/pdel.gif\" align=\"absmiddle\" border=\"0\"></a></p>
<form name=\"form1\" method=\"post\" action=\"action.php?action=renommer_fichier&fichier=$_GET[fichier]\">
  <img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\">Renommer ou déplacer le 
  fichier : $fichier_affichage <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nouveau chemin : 
  <input name=\"nouveau_nom\" size=\"50\" type=\"text\" id=\"nouveau_nom\" value=\"$fichier_affichage\" >
  <input type=\"submit\" name=\"Submit\" value=\"Renommer\">
</form>
<p><img src=\"../../../images/config/lien.gif\" width=\"19\" height=\"9\"><a href=\"$_GET[fichier]\">Voir ou télécharger  le fichier</a></p>
</td></tr></table>
</font>
";
}
echo"<br><br>";
message3("- Pour supprimer, renommer 
  ou d&eacute;placer, s&eacute;lectionnez le dossier ou le fichier concern&eacute;.<br>
  - Pour t&eacute;l&eacute;charger un fichier, s&eacute;lectionnez le dossier 
  dans lequel vous voulez t&eacute;l&eacute;charger un fichier.<br>
  - Pour cr&eacute;er un dossier, s&eacute;lectionnez le dossier dans le quel 
  vous voulez cr&eacute;er le nouveau dossier.<br>- Gest'classe traîte jusqu'à six niveaux d'arborescence
<br>- L'arborescence apparaît entièrement avec Mozilla Firefox et apparaît sous forme de \"déroulement\" avec IE.
<br>- Pour voir les modifications, n'oubliez pas d'actualiser l'arborescence du dossier -documents-");
?>
