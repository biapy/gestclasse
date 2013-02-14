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

 titre_page("Les dernières fiches modifiées par les élèves ");
 
 // protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


 if (!isset($_POST['mod'])) $mod=10;
 else $mod=$_POST['mod'];
 ?>
<table width="90%" border="0" align="center">
  <tr>
    <td valign="top"> 
      <form name="form1" method="post" action="?page_admi=modification">
        <font size="2" face="Arial, Helvetica, sans-serif">
        <input type="submit" name="Submit" value="Voir">
        les 
        <input name="mod" type="text" 
		<? 
		echo "value=\"$mod\"";
		?>
		; size="5">
        derni&egrave;res fiches modifi&eacute;es</font> 
      </form>
      <p>&nbsp;</p>

<?

$sql="select  MAX(id_modification) from gc_modification";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$max=$rang[0];
$min=$max-$mod;

if ($max<>0)
{
$sql="select  gc_eleve.id_eleve, gc_eleve.nom, gc_eleve.prenom , gc_eleve.classe, UNIX_TIMESTAMP(gc_modification.date) FROM gc_eleve,gc_modification where gc_modification.id_modification>$min and gc_modification.id_modification<=$max and gc_eleve.id_eleve=gc_modification.id_eleve ";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_eleve=$rang[0];
$nom=$rang[1];
$prenom=$rang[2];
$classe=$rang[3];
$maj=$rang[4];
echo "<p><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> - $classe : <a href=\"admilux/fiches/fiche_eleve.php?id_eleve=$id_eleve\" target=\"_blank\">$nom 
  $prenom</a></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> - Dernière modification "; 
  echo date_francais(getdate($maj));
  echo heure(getdate($maj));
echo "</font></p>";
}
}
?>

	</td>
  </tr>
</table>

