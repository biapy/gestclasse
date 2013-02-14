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



//eleve déja connecté
if ( isset($_SESSION['id_eleve']) ) 
{ 
include ("eleve/index.php"); 
exit;
}

//incrémentation du test du nb d'erreurs
$_SESSION['auth']++;
// message si erreur ou deconnexion
if ($_GET['message']=="erreur" and $_SESSION['auth']!=3) echo "<br><br><p align=\"center\"><font color=\"#000066\" size=\"6\" face=\"Arial, Helvetica, sans-serif\">Erreur!
<br><br>Essayez à nouveau</strong></font></p>";


//message d'erreur si plus de trois tests
if ($_SESSION['auth']==3)
{
$_SESSION['auth']=1;
echo "<br><br><div align=\"center\"><font color=\"#000066\" size=\"6\" face=\"Arial, Helvetica, sans-serif\">Vous 
	n'avez pas acc&egrave;s &agrave; cet espace</font></div>
";
}
?>


