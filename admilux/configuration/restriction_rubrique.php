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

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

// traitement du formulaire
if (isset($_GET['valide_restriction']) and $_GET['valide_restriction']=="ok")
{
if  (!isset($_POST['plan'])) $_POST['plan']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[plan]' where nom='plan'";
mysql_db_query($dbname,$sql,$id_link);

if  (!isset($_POST['lien'])) $_POST['lien']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[lien]' where nom='lien'";
mysql_db_query($dbname,$sql,$id_link);

if  (!isset($_POST['agenda'])) $_POST['agenda']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[agenda]' where nom='agenda'";
mysql_db_query($dbname,$sql,$id_link);

if  (!isset($_POST['mail'])) $_POST['mail']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[mail]' where nom='mail'";
mysql_db_query($dbname,$sql,$id_link);

if  (!isset($_POST['fiche'])) $_POST['fiche']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[fiche]' where nom='fiche'";
mysql_db_query($dbname,$sql,$id_link);

if  (!isset($_POST['notes'])) $_POST['notes']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[notes]' where nom='notes'";
mysql_db_query($dbname,$sql,$id_link);

if  (!isset($_POST['trombi'])) $_POST['trombi']="off";
$sql="UPDATE gc_restriction SET etat='$_POST[trombi]' where nom='trombi'";
mysql_db_query($dbname,$sql,$id_link);


if  (isset($_POST['cahier']))
{
$sql="UPDATE gc_restriction SET etat='$_POST[cahier]' where nom='cahier'";
mysql_db_query($dbname,$sql,$id_link);
}
}

for($i=1;$i<=8;$i++)
{
$sql="select  etat  FROM gc_restriction where id_restriction='$i'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$etat[$i]=$rang['etat'];
}
?>
<form name="form1" method="post" action="admi.php?page_admi=config&sous_titre=restriction&valide_restriction=ok">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td><hr>
        <font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">S&eacute;lectionnez 
        les rubriques que vous voulez afficher dans l'espace commun.</font>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Plan 
              du site :</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="plan" type="checkbox" value="on" <? if ($etat[1]=="on") echo "checked" ?> >
              </font></td>
          </tr>
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Lien 
              :</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="lien" type="checkbox" id="lien" value="on" <? if ($etat[2]=="on") echo "checked" ?>>
              </font></td>
          </tr>
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Agenda 
              : </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="agenda" type="checkbox" id="agenda" value="on" <? if ($etat[3]=="on") echo "checked" ?>>
              </font></td>
          </tr>
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Mail 
              :</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="mail" type="checkbox" id="mail" value="on" <? if ($etat[5]=="on") echo "checked" ?>>
              </font></td>
          </tr>
        </table>
        <hr>
        <font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">S&eacute;lectionnez 
        les rubriques que vous voulez afficher dans l'espace &eacute;l&egrave;ve.</font> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">La 
              fiche de l'&eacute;l&egrave;ve : </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="fiche" type="checkbox" id="fiche" value="on" <? if ($etat[6]=="on") echo "checked" ?>>
              </font></td>
          </tr>
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Les 
              notes : </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="notes" type="checkbox" id="notes" value="on" <? if ($etat[7]=="on") echo "checked" ?>>
              </font></td>
          </tr>
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Le 
              Trombinoscope :</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="trombi" type="checkbox" id="trombinoscope" value="on" <? if ($etat[8]=="on") echo "checked" ?>>
              </font></td>
          </tr>
        </table>
        <hr>
        <font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">S&eacute;lectionnez 
        l'affichage que vous souhaitez pour le cahier de texte.</font> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Dans 
              l'espace commun : </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="cahier" type="radio" value="commun"  <? if ($etat[4]=="commun") echo "checked" ?>>
              <font size="1">( ne n&eacute;cessite pas de se connecter )</font></font></td>
          </tr>
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Dans 
              l'espace &eacute;l&egrave;ve uniquement :</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="radio" name="cahier" value="eleve" <? if ($etat[4]=="eleve") echo "checked" ?>>
              <font size="1">( n&eacute;cessite de se connecter )</font> </font></td>
          </tr>
        </table>
        <p>
          <input type="submit" name="Submit" value="Envoyer">
        </p>
        <p>&nbsp; </p></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </form>
<p>&nbsp;</p>
