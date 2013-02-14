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

//c'est le titre de la page de l'élève
echo "
<table width=\"100%\" border=\"0\" bgcolor=\"#$couleur2\">
  <tr>
    <td><div align=\"left\"><font color=\"#$couleur8\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">
	> <a href=\"index.php?page=eleveok\"><font color=\"#$couleur8\">Espace de $_SESSION[nom_eleve] $_SESSION[prenom_eleve]</font></a>
	  </tr>
</table>";
?> 

