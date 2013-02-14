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

titre_page("Cahier de texte de $_GET[classe] - Les archives");
?>

<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        Afficher les archives &agrave; partir de : </font></div></td>
  </tr>
  <tr> 
    <td width="200"> 
      <?
	echo "<form name=\"classe\">
        <div align=\"center\"> 
          <select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">
            <option>à partir de : </option>";
           
			$sql="select  *  FROM gc_cahier_texte where type='jour' and classe='$_GET[classe]' and archive='1' ORDER BY id_jour ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$jour=$rang[jour];
			$id_jour=$rang[id_jour];
			echo "<option value=\"index.php?page=cahier_texte_archive&classe=$_GET[classe]&voir=$id_jour\">$jour</option>";
			}
	echo "</select></div></form> ";
	?>
      </td>
  </tr>
</table>


<?

if ( isset($_GET['voir']))
{

//affichage des jours 

$sql1="select  *  FROM gc_cahier_texte where (classe='$_GET[classe]' and type='jour' and archive='1' and id_jour>='$_GET[voir]' ) ORDER BY id_jour";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_com_classe=$rang1['id_com_classe'];	
$jour=$rang1['jour'];
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"200\">";
titre_division($jour);
echo "</tr></table>";
include('com_classe_archive.php');
}
}?>




