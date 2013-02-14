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
include ("../../commun/connect.php");
include("../../commun/texte.php");
include("../../commun/fonction.php");

?>
<link href="../../commun/style.css" rel="stylesheet" type="text/css">
<?

//formatage du texte
if (isset($_POST['contenu'])) $_POST['contenu']=texte($_POST['contenu']);

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


//suppression d'un message
if (isset($_GET['del_bloc']))
{
	 $sql="delete  from gc_bloc_notes where id_bloc=$_GET[del_bloc]";
	 mysql_db_query($dbname,$sql,$id_link);
}


//titre de la page

echo "<table width=\"100%\"><tr><td width=\"40%\" ><img src=\"../../images/config/logogestclasse.gif\" align=\"absmiddle\" > <a href=\"../../commun/style_gestclasse.php\" target=\"_blank\"><font color=\"#999999\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Les 
  styles de Gest'classe</font></a> <a href=\"../../FCKeditor/_samples/html/index.htm\" target=\"_blank\"><font color=\"#999999\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Editeur HTML</font></a></td><td width=\"60%\" ><font size=\"4\" face=\"Arial, Helvetica, sans-serif\" color=\"#000033\" >$_GET[classe] : Commentaires, messages ...
  </font></td></table>";


//insertion d'un message
if (isset($_POST['contenu']))
{

$sql="INSERT INTO gc_bloc_notes (classe,contenu,type) VALUES ('$_GET[classe]','$_POST[contenu]','$_POST[message_type]')";
mysql_db_query($dbname,$sql,$id_link);

}


//Affichage des messages

$sql="select id_bloc,contenu,type,UNIX_TIMESTAMP(date) from gc_bloc_notes where classe='$_GET[classe]' order by id_bloc";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_bloc=$rang[0];
$contenu=style($rang[1]);
$type_message=$rang[2];
$date=$rang[3];

echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
echo date_francais(getdate($date));
echo heure(getdate($date));
if ($type_message==$_GET['classe']) echo "<font color=\"#FF0000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"> : Affiché 
dans l'espace des élèves de la classe</font>";
echo "<br><a href=\"bloc_notes.php?classe=$_GET[classe]&del_bloc=$id_bloc\"><img src=\"../../images/config/pdel.gif\"  border=\"0\"></a>&nbsp;&nbsp; $contenu</font> <br><br>";
}

	
//Formulaire pour insérer un message
echo"
<form name=\"form1\" method=\"post\" action=\"bloc_notes.php?classe=$_GET[classe]\">
  <div align=\"center\">
    <p>
      <textarea name=\"contenu\" cols=\"100\" rows=\"5\" wrap=\"VIRTUAL\"></textarea>
      <br>
	  <font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Afficher dans l'espace des élèves de la classe</font> 
      <input type=\"checkbox\" name=\"message_type\" value=\"$_GET[classe]\">
      <br>
      <input type=\"submit\" name=\"Submit\" value=\"Envoyer\">
    </p>
  </div>
</form>
";

?>

