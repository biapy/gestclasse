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

function jour_fr($jour)
{
switch ($jour) 
{
case "Monday": $jour='lundi' ; break;
case "Tuesday": $jour='mardi' ; break;
case "Wednesday": $jour='mercredi' ; break;
case "Thursday": $jour='jeudi' ; break;
case "Friday": $jour='vendredi' ; break;
case "Saturday": $jour='samedi' ; break;
case "Sunday": $jour='dimanche' ; break;
}
return $jour;
}

function mois_fr($mois)
{
switch ($mois) 
{
case "January": $mois='janvier' ; break;
case "February": $mois='février' ; break;
case "March": $mois='mars' ; break;
case "April": $mois='avril' ; break;
case "May": $mois='mai' ; break;
case "June": $mois='juin' ; break;
case "July": $mois='juillet' ; break;
case "August": $mois='aout' ; break;
case "September": $mois='septembre' ; break;
case "October": $mois='octobre' ; break;
case "November": $mois='novembre' ; break;
case "December": $mois='décembre' ; break;
}
return $mois;
}
?>