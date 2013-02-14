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
include("../../commun/connect.php");
include("../../commun/config.php");
include("../../commun/fonction.php"); 
?>
<link href="../../commun/style.css" rel="stylesheet" type="text/css">
<?

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

//formatage des textes
if (isset($_POST['login'])) $_POST['login']=texte($_POST['login']);
if (isset($_POST['passe'])) $_POST['passe']=texte($_POST['passe']);
if (isset($_POST['nom'])) $_POST['nom']=texte($_POST['nom']);
if (isset($_POST['prenom'])) $_POST['prenom']=texte($_POST['prenom']);
if (isset($_POST['naissance'])) $_POST['naissance']=texte($_POST['naissance']);
if (isset($_POST['adresse'])) $_POST['adresse']=texte($_POST['adresse']);
if (isset($_POST['tel'])) $_POST['tel']=texte($_POST['tel']);
if (isset($_POST['prof_pere'])) $_POST['prof_pere']=texte($_POST['prof_pere']);
if (isset($_POST['prof_mere'])) $_POST['prof_mere']=texte($_POST['prof_mere']);
if (isset($_POST['classe_red'])) $_POST['classe_red']=texte($_POST['classe_red']);
if (isset($_POST['moy_avant'])) $_POST['moy_avant']=texte($_POST['moy_avant']);
if (isset($_POST['com_eleve'])) $_POST['com_eleve']=texte($_POST['com_eleve']);
if (isset($_POST['com_prof'])) $_POST['com_prof']=texte($_POST['com_prof']);
if (isset($_POST['appreciation'])) $_POST['appreciation']=texte($_POST['appreciation']);

titre_page_impression("Fiches des élèves de   $_GET[choix_classe]");





// le formulaire pour chaque élève
if (isset($_GET['choix_classe']))
{
	  $sql="select  *  FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat))
	  {
	    $id_eleve=$rang['id_eleve'];	
		$login=$rang['login'];
		$passe=$rang['passe'];
		$maj_eleve=$rang['maj_eleve'];
		$nom=$rang['nom'];
		$prenom=$rang['prenom'];
		$naissance=$rang['naissance'];
		$adresse=$rang['adresse'];
		$tel=$rang['tel'];
		$prof_pere=$rang['prof_pere'];
		$prof_mere=$rang['prof_mere'];
		$classe_red=$rang['classe_red'];
		$moy_avant=$rang['moy_avant'];
		$com_eleve=style($rang['com_eleve']);
		$com_prof=style($rang['com_prof']);
		$appreciation=style($rang['appreciation']);

echo"
<br>
<a name=\"$id_eleve\" id=\"$id_eleve\"></a> 
  
<table width=\"90%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"bordure\">
  <tr> 
    <td width=\"30%\"> <div align=\"center\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\"><img src=\"../../admilux/photo_classe/$id_eleve.jpg\" ></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><br>
        identifiant dans la bdd : $id_eleve</font></div></td>
    <td><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\" >$nom $prenom <br><br>login: $login - mot de passe : $passe  </font></td>
  </tr>
  <tr> 
    <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Date 
        de naissance :</font></div></td>
    <td bgcolor=\"#F0F0F0\"><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\"> 
      $naissance</font></td>
  </tr>
  <tr> 
    <td> <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Adresse 
        :</font></div></td>
    <td><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\">$adresse</font></td>
  </tr>
  <tr> 
    <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">T&eacute;l&eacute;phone 
        et mail des parents :</font></div></td>
    <td bgcolor=\"#F0F0F0\"><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\"> 
      $tel</font></td>
  </tr>
  <tr> 
    <td> <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Profession 
        du p&egrave;re :</font></div></td>
    <td><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\">$prof_pere</font></td>
  </tr>
  <tr> 
    <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Profession 
        de la m&egrave;re :</font></div></td>
    <td bgcolor=\"#F0F0F0\"><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\"> 
      $prof_mere</font></td>
  </tr>
  <tr> 
    <td> <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Classe(s) 
        redoubl&eacute;e(s) :</font></div></td>
    <td><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\">$classe_red</font></td>
  </tr>
  <tr> 
    <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Moyenne 
        de l'an dernier et nom du professeur :</font></div></td>
    <td bgcolor=\"#F0F0F0\"><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\"> 
      $moy_avant</font></td>
  </tr>
  <tr> 
    <td> <div align=\"left\"><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Un 
        commentaire suppl&eacute;mentaire :</font></div></td>
    <td><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\">$com_eleve </font></td>
  </tr>
  <tr> 
    <td bgcolor=\"#F0F0F0\" ><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Appréciation 
      </font></td>
    <td bgcolor=\"#F0F0F0\"><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\"> 
      $appreciation</font></td>
  </tr>
  <tr bgcolor=\"#FFFFFF\"> 
    <td ><font  size=\"1\"  face=\"Arial, Helvetica, sans-serif\">Commentaire du professeur</font><br> 
      <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"></font></td>
    <td><font size=\"1\"  face=\"Arial, Helvetica, sans-serif\"> $com_prof</font></td>
  </tr>
</table>

";
}
}
?>
<div align="right"><br>
  <img src="../../images/config/logogestclasse.gif" ></div>
