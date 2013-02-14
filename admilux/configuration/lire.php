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
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="75%" border="0" align="center">
  <tr>
    <td><p><font size="1"><font size="2" face="Arial, Helvetica, sans-serif">Php 
        est normalement configur&eacute; par d&eacute;faut pour ajouter \ devant 
        certains caract&egrave;res.<br>
        Si cette configuration n'est pas faite, vous aurez, par exemple, des probl&egrave;mes 
        avec les apostrophes dans les formulaires et vous n'arriverez pas &agrave; 
        valider les formulaires.<br>
        Pour </font><font size="1"><font size="2" face="Arial, Helvetica, sans-serif">&eacute;ventuellement</font></font> 
        <font size="2" face="Arial, Helvetica, sans-serif">rem&eacute;dier au 
        probl&egrave;me, il faut modifier le fichier commun/texte.php</font></font>.</p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Vous pouvez modifier 
        ce fichier manuellement ou le modifier en cliquant sur un des liens ci-dessous.</font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" width="19" height="9" align="absmiddle"><a href="admi.php?page_admi=config&sous_titre=lire&aj=ok">Ajouter 
        des \</a></font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" width="19" height="9" align="absmiddle"><a href="admi.php?page_admi=config&sous_titre=lire&naj=ok">Ne 
        pas ajouter des \</a></font></p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp; </p>
<div align="center"><font size="4" face="Arial, Helvetica, sans-serif">
<? echo texte("résultat : '")?>
</font></div>
