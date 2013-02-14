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

// protection 
session_start();
include ("../../commun/connect.php");
include("../../commun/config.php");
include("../../commun/fonction.php"); 

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\">
font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

titre_page_impression("Mots de passe des élèves de   $_GET[choix_classe]");
?>
<link href="../../commun/style.css" rel="stylesheet" type="text/css">
<br>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#EAEAEA"> 
          <td width="10%" class="borduredroitebleue"> 
            <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Identifiant</font></div></td>
          <td width="24%" class="borduredroitebleue"> 
            <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Nom</font></div></td>
          <td width="24%" class="borduredroitebleue"> 
            <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Pr&eacute;nom</font></div></td>
          <td width="19%" class="borduredroitebleue"> 
            <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Login</font></div></td>
          <td width="19%"> 
            <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Mot 
              de passe</font></div></td>
        </tr>
      </table></td>
  </tr>
<?

$sql="select  *  FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
	    $id_eleve=$rang['id_eleve'];	
		$login=$rang['login'];
		$passe=$rang['passe'];
		$nom=$rang['nom'];
		$prenom=$rang['prenom'];
		echo"
		  <tr>
    <td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr> 
          <td width=\"10%\" class=\"borduredroitebleue\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$id_eleve</font></div></td>
          <td width=\"24%\" class=\"borduredroitebleue\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom</font></div></td>
          <td width=\"24%\" class=\"borduredroitebleue\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$prenom</font></div></td>
          <td width=\"19%\" class=\"borduredroitebleue\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$login</font></div></td>
          <td width=\"19%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$passe</font></div></td>
        </tr>
      </table></td>
  </tr>
  ";		
}
?>

</table>
<div align="right"><br>
  <img src="../../images/config/logogestclasse.gif" ></div>