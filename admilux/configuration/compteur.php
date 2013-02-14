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

//modification du compteur 
if (isset($_GET['modif_compteur']) and  $_GET['modif_compteur']=='ok')
{
	$fichier = "cpt.txt";
    $visites=$_POST['cpt'];

    $fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero
    if (!$fp) {
        echo "Impossible d'ouvrir $fichier en ecriture";
        exit;
    }
    fputs($fp, $visites);
    fclose($fp);
	$_SESSION['compteur_visites']=$visites;
}

echo "
<div align=\"center\">
  <p>&nbsp;</p>
  <p><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">nombre de visites :
  ";
include('cpt.txt');  
echo"</font></p></div>";

?>
 
<form name="form1" method="post" action="admi.php?page_admi=config&sous_titre=compteur&modif_compteur=ok">
  <div align="center"> 
    <input type="text" name="cpt">
    &nbsp; 
    <input type="submit" name="Submit" value="Modifier le compteur">
  </div>
</form>

<?
message('- Le compteur est incrémenté de 1 à chaque vistite du site et non pas à chaque passage sur la page d\'accueil.
<br>- Pour annuler une visite du professeur, il suffit de se connecter en tant que professeur puis de repasser par la page d\'accueil du site.');
?>