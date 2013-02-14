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

include ("../commun/connect.php");
include("mot_de_passe.php");
include("../commun/texte.php");
$login=strip_tags(texte(($_POST['login'])));
$passe=strip_tags(texte(($_POST['passe'])));

// espace prof
if ( $login == LOGIN_PROF and $passe == PASSE_PROF )
{
	session_start();
	session_register("admilogin");
	session_register("admipasse");
	$_SESSION['admilogin'] =$login;
	$_SESSION['admipasse'] =$passe;
	if(isset($_COOKIE['test']))
		header('location: ../admi.php');
	else
	 {
		echo"
<p align=\"center\"><em><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"> <font size=\"5\">La session ne peut pas d&eacute;marrer.</font></font></em></p>
<div align=\"center\"><font size=\"5\" face=\"Arial, Helvetica, sans-serif\"><a href=\"../index.php\">Cliquez ici</a></font></div>
<p align=\"center\"><font size=\"3\"><em><font face=\"Arial, Helvetica, sans-serif\">Si ça ne fonctionne toujours pas, modifiez éventuellement  
  le niveau de s&eacute;curit&eacute; du navigateur. </font></em></font><em><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><br>
  </font></em></p><br>
  
  ";
 	 }    

}

//espace eleve

else 
{
session_start();
$sql="select  * FROM gc_eleve where login='$login' and passe='$passe'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);

//mot de passe et login correct
if ( isset($rang['login']) and $login==$rang['login'] and isset($rang['passe']) and $passe==$rang['passe'] )
{
//declaration des variables de la session
session_register("id_eleve");
session_register("login");
session_register("passe");
session_register("maj_eleve");
session_register("nom_eleve");
session_register("prenom_eleve");
session_register("classe_active");
session_register("naissance");
session_register("adresse");
session_register("tel");
session_register("prof_pere");
session_register("prof_mere");
session_register("classe_red");
session_register("moy_avant");
session_register("com_eleve");
session_register("com_prof");

$_SESSION['id_eleve']=$rang['id_eleve'];
$_SESSION['login']=$rang['login'];
$_SESSION['passe']=$rang['passe'];
$_SESSION['maj_eleve']=$rang['maj_eleve'];
$_SESSION['nom_eleve']=$rang['nom'];
$_SESSION['prenom_eleve']=$rang['prenom'];
$_SESSION['classe_active']=$rang['classe'];
$_SESSION['naissance']=$rang['naissance'];
$_SESSION['adresse']=$rang['adresse'];
$_SESSION['tel']=$rang['tel'];
$_SESSION['prof_pere']=$rang['prof_pere'];
$_SESSION['prof_mere']=$rang['prof_mere'];
$_SESSION['classe_red']=$rang['classe_red'];
$_SESSION['moy_avant']=$rang['moy_avant'];
$_SESSION['com_eleve']=$rang['com_eleve'];
$_SESSION['com_prof']=$rang['com_prof'];

//insertion dans la table connexion
$sql="INSERT INTO gc_connexion (id_eleve) VALUES ('$_SESSION[id_eleve]')";
mysql_db_query($dbname,$sql,$id_link);

//cookies accepté
if(isset($_COOKIE['test']))
{
	header('location: ../index.php?page=eleveok');
}	
//cookies non accepté
else
	 {
		echo"
<p align=\"center\"><em><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"> <font size=\"5\">La session ne peut pas d&eacute;marrer.</font></font></em></p>
<div align=\"center\"><font size=\"5\" face=\"Arial, Helvetica, sans-serif\"><a href=\"../index.php\">Cliquez ici</a></font></div>
<p align=\"center\"><font size=\"3\"><em><font face=\"Arial, Helvetica, sans-serif\">Si ça ne fonctionne toujours pas, modifiez éventuellement  
  le niveau de s&eacute;curit&eacute; du navigateur. </font></em></font><em><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><br>
  </font></em></p><br>
  
  ";
 	 }    

}
else
//mauvaise identification
{
header('location: ../index.php?page=passe&message=erreur');
} 
};
?> 
