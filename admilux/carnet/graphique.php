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


function graphique($note,$table,$selection,$select)
{
include("commun/connect.php");
if ($table=='gc_eleve') $image='histogramme.gif';
else $image='histogramme2.gif';
for ($i=0;$i<=20;$i++)
{
$sql="select count($note)*10 from $table where round($note)='$i' and $selection='$select'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$n[$i]=$rang[0];
}
echo"
<table border=\"0\">
  <tr valign=\"bottom\"> 
    <td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[0]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[1]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[2]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[3]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[4]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[5]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[6]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[7]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[8]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[9]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[10]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[11]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[12]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[13]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[14]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[15]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[16]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[17]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[18]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[19]\"></td>
<td width=\"10\"> <img src=\"images/config/$image\" width=\"10\" height=\"$n[20]\"></td>
<td width=\"40\"> <div align=\"center\"><img src=\"images/config/$image\" width=\"10\" height=\"10\"></div></td>
  </tr>
  <tr> 
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">0</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">1</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">2</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">3</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">4</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">5</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">6</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">7</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">8</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">9</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">10</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">11</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">12</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">13</font></div></td>

    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">14</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">15</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">16</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">17</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">18</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">19</font></div></td>
    <td width=\"10\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">20</font></div></td>
    <td width=\"40\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">unit&eacute;</font></div></td>
  </tr>
</table>
";
}
?>