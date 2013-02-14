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

include('commun/config.php');

// affichage du formulaire de modifications
echo"

<form name=\"form2\" method=\"post\" action=\"admi.php?page_admi=config&sous_titre=design&design=ok\">
<table width=\"100%\" border=\"0\" bgcolor=\"#$couleur1\">
   <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur du fond du haut de page</font></td>
    <td><input name=\"fond_haut_page\" type=\"text\" value=\"$fond_haut_page\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> pour insérer une image : images/image.gif</font></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur du fond des formulaires de modification de l'espace admi, des tableaux générés automatiquement et du fond des vacances de l'agenda </font></td>
    <td><input name=\"couleur1\" type=\"text\" value=\"$couleur1\"></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur du contour</font></td>
    <td><input name=\"couleur2\" type=\"text\" value=\"$couleur2\"></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur par défaut des textes</font></td>
    <td><input name=\"couleur3\" type=\"text\" value=\"$couleur3\"></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur par défaut des liens hypertextes</font></td>
    <td><input name=\"couleur4\" type=\"text\" value=\"$couleur4\"></td>
  </tr>
    <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur du fond des titres du plan, et du fond des mois et dimanches de l'agenda</font></td>
    <td><input name=\"couleur5\" type=\"text\" value=\"$couleur5\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> pour insérer une image : images/image.gif</font></td>
  </tr>
   <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur des boutons variables</font></td>
    <td><input name=\"couleur6\" type=\"text\" value=\"$couleur6\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> pour insérer une image : images/image.gif</font></td>
  </tr>
      <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur du fond du titre de la page active et des divisions</font></td>
    <td><input name=\"couleur7\" type=\"text\" value=\"$couleur7\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> pour insérer une image : images/image.gif</font></td>
  </tr>
      <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur des textes de la bordure, du titre de la page active et des divisions</font></td>
    <td><input name=\"couleur8\" type=\"text\" value=\"$couleur8\"></td>
  </tr>
    <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> Couleur du fond</font></td>
    <td><input name=\"fond\" type=\"text\" value=\"$fond\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> pour insérer une image : images/image.gif</font></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;</font></td>
    <td><input type=\"submit\" name=\"Submit\" value=\"Envoyer\"></td>
  </tr>

</table>
</form>
";
//fin : affichage du formulaire  de modifications


?>
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"><a href="admilux/configuration/couleur.php" target="_blank">S&eacute;lectionner 
  un code couleur</a> <img src="images/config/lien.gif" align="absmiddle"><a href="admilux/configuration/arborescence/arb.php" target="_blank">G&eacute;rer 
  le dossier images</a></font></div>
