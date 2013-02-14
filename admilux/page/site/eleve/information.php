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

titre_page("Mes informations");

//formatage des textes
if (isset($_POST['login'])) $_POST['login']=texte($_POST['login']);
if (isset($_POST['passe'])) $_POST['passe']=texte($_POST['passe']);
if (isset($_POST['naissance'])) $_POST['naissance']=texte($_POST['naissance']);
if (isset($_POST['adresse'])) $_POST['adresse']=texte($_POST['adresse']);
if (isset($_POST['tel'])) $_POST['tel']=texte($_POST['tel']);
if (isset($_POST['prof_pere'])) $_POST['prof_pere']=texte($_POST['prof_pere']);
if (isset($_POST['prof_mere'])) $_POST['prof_mere']=texte($_POST['prof_mere']);
if (isset($_POST['classe_red'])) $_POST['classe_red']=texte($_POST['classe_red']);
if (isset($_POST['moy_avant'])) $_POST['moy_avant']=texte($_POST['moy_avant']);
if (isset($_POST['com_eleve'])) $_POST['com_eleve']=texte($_POST['com_eleve']);

if ( isset($_POST['envoi']) and $_POST['envoi']=="ok")
{
include ("commun/connect.php");
$sql="UPDATE gc_eleve SET  login='$_POST[login]' , passe='$_POST[passe]', naissance='$_POST[naissance]', adresse='$_POST[adresse]', tel='$_POST[tel]', prof_pere='$_POST[prof_pere]', prof_mere='$_POST[prof_mere]', classe_red='$_POST[classe_red]', moy_avant='$_POST[moy_avant]', com_eleve='$_POST[com_eleve]' where id_eleve='$_SESSION[id_eleve]'";
mysql_db_query($dbname,$sql,$id_link);
message('les modifications ont &eacute;t&eacute;s faites');

$sql="select  * FROM gc_eleve where id_eleve='$_SESSION[id_eleve]'";
//on remplace les informations
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$_SESSION['login']=strip_tags($rang['login']);
$_SESSION['passe']=strip_tags($rang['passe']);
$_SESSION['maj_eleve']=strip_tags($rang['maj_eleve']);
$_SESSION['naissance']=strip_tags($rang['naissance']);
$_SESSION['adresse']=strip_tags($rang['adresse']);
$_SESSION['tel']=strip_tags($rang['tel']);
$_SESSION['prof_pere']=strip_tags($rang['prof_pere']);
$_SESSION['prof_mere']=strip_tags($rang['prof_mere']);
$_SESSION['classe_red']=strip_tags($rang['classe_red']);
$_SESSION['moy_avant']=strip_tags($rang['moy_avant']);
$_SESSION['com_eleve']=strip_tags($rang['com_eleve']);
$_SESSION['com_prof']=$rang['com_prof'];

// dernière modification
$sql="INSERT INTO gc_modification ( id_eleve) VALUES ('$_SESSION[id_eleve]')";
mysql_db_query($dbname,$sql,$id_link);

}

?> 


<form name="form1" method="post" action="index.php?page=eleveok&eleve_lien=information">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Login 
          : 
          <input type="hidden" name="envoi" value="ok" >
          </font></div></td>
      <td><input name="login" type="text"  value="<? echo $_SESSION['login'] ?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Mot 
          de passe :</font></div></td>
      <td><input name="passe" type="text" id="passe" value="<? echo $_SESSION['passe']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Date 
          de naissance :</font></div></td>
      <td><input name="naissance" type="text"  value="<? echo $_SESSION['naissance']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Adresse 
          :</font></div></td>
      <td><input name="adresse" type="text"  value="<? echo $_SESSION['adresse']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">T&eacute;l&eacute;phone 
          et mail des parents :</font></div></td>
      <td><input name="tel" type="text"  value="<? echo $_SESSION['tel']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Profession 
          du p&egrave;re :</font></div></td>
      <td><input name="prof_pere" type="text"  value="<? echo $_SESSION['prof_pere']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Profession 
          de la m&egrave;re :</font></div></td>
      <td><input name="prof_mere" type="text"  value="<? echo $_SESSION['prof_mere']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Classe(s) 
          redoubl&eacute;e(s) :</font></div></td>
      <td><textarea name="classe_red" cols="60" rows="2" wrap="VIRTUAL" ><? echo $_SESSION['classe_red'] ?></textarea></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Moyenne 
           de l'an dernier et nom du professeur :</font></div></td>
      <td><input name="moy_avant" type="text"  value="<? echo $_SESSION['moy_avant']?>" size="80"></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Un 
          commentaire suppl&eacute;mentaire :</font></div></td>
      <td><textarea name="com_eleve" cols="60" rows="10" wrap="VIRTUAL" ><? echo $_SESSION['com_eleve']?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><p>&nbsp;</p>
        <p>
          <input type="submit" name="Submit" value="Modifier">
        </p></td>
    </tr>
  </table>
</form>
