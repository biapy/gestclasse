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
echo "<div align=\"left\"><font color=\"#FF6600\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;&nbsp;";
if ($etat_fiche=="on")
echo" &nbsp;&gt;<a href=\"index.php?page=eleveok&eleve_lien=information\">Voir et modifier mes informations</a>";
if ($etat_notes=="on")
echo "&nbsp;&gt; <a href=\"index.php?page=eleveok&eleve_lien=notes\">Voir mes résultats</a>";
if ($etat_trombi=="on") echo"&nbsp;&gt; <a href=\"index.php?page=eleveok&eleve_lien=trombi\">Voir le trombinoscope de la classe</a>";
echo "</font> </div>";
?>