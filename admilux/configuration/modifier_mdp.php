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

//modification 
if (isset($_GET['modif_mdp']) and  $_GET['modif_mdp']=='ok')
{
	$fichier = "session/mot_de_passe.php";
	$ecrire="<?\ndefine(\"LOGIN_PROF\",\"$_POST[nouveau_login]\");\ndefine(\"PASSE_PROF\",\"$_POST[nouveau_mdp]\");\n?>";
    $fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero
    if (!$fp) {
        echo "Impossible d'ouvrir $fichier en ecriture";
        exit;
    }
    fputs($fp, $ecrire);
    fclose($fp);
	$_SESSION['admilogin']=$_POST['nouveau_login'];
	$_SESSION['admipasse']=$_POST['nouveau_mdp'];
}

?>
<p align="center">&nbsp;</p>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><p align="left"><font size="4" face="Arial, Helvetica, sans-serif">Login 
        actuel : <? echo $_SESSION['admilogin'] ?></font></p>
      <p align="left"><font size="4" face="Arial, Helvetica, sans-serif">Mot de 
        passe actuel : <? echo $_SESSION['admipasse'] ?></font></p>
      <p align="left">&nbsp;</p>
      <form name="form1" method="post" action="admi.php?page_admi=config&sous_titre=passe&modif_mdp=ok">
        <p align="left"><font size="4" face="Arial, Helvetica, sans-serif">N</font><font size="4" face="Arial, Helvetica, sans-serif">ouveau 
          login :</font> 
          <input name="nouveau_login" type="text" id="nouveau_login">
        </p>
        <p align="left"><font size="4" face="Arial, Helvetica, sans-serif">Nouveau 
          mot de passe :</font> 
          <input name="nouveau_mdp" type="text" id="nouveau_mdp">
        </p>
        <p align="left">&nbsp; </p>
        <p> 
          <input type="submit" name="Submit" value="Modifier">
        </p>
          </form></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
