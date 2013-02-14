<? 
################################################################################
##                      -=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-                    ##
##                               Gest'classe_v7_plus                          ##                               
##             Logiciel (php/Mysql)  destiné aux enseignants                  ##
##                      -=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-                    ##
##                                                                            ##
## -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-    ##
##                                                                            ##
##     Copyright (c) 2003-2008 by Lux Pierre (luxpierre@hotmail.com)             ##
##                          http://gestclasse.free.fr                         ##
##                                                                            ##
##   This program is free software. You can redistribute it and/or modify     ##
##   it under the terms of the GNU General Public License as published by     ##
##   the Free Software Foundation.                                            ##
################################################################################

titre_page("liens");

// affichage du haut de page
$sql="select  *  FROM gc_contenu_page where id_page='1000'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$haut=style($rang['haut']);
$bas=style($rang['bas']);
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$haut</font>";
//fin : affichage du haut de page


			//affichage de la liste des divisions		
			$sql="select  count(id_division)  FROM gc_division_page where id_page='1000'";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$nb=$rang['0'];
			if ( $nb<>"0")
			{
			$sql="select  *  FROM gc_division_page where id_page='1000' ORDER BY ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo "<div align=\"center\"><form name=\"divisions\"><select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">";
			while($rang=mysql_fetch_array($resultat))
			{
			$id_division=$rang['id_division'];
			$nom_division=$rang['nom_division'];
			echo "<option value=\"#$id_division\">$nom_division</option>";
			}
			echo "</select></div></form>";
			}
			//fin : affichage de la liste des divisions
			
// affichage des divisions
$sql="select  *  FROM gc_division_page where id_page='1000' order by ordre ";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_division=$rang['id_division'];
$nom_division=$rang['nom_division'];
$contenu=$rang['contenu'];
$contenu=style($rang['contenu']);
$ordre=$rang['ordre'];
echo "<a name=\"$id_division\"></a>";
titre_division(" $nom_division ");
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$contenu<br></font>";




//affichage des liens 
$sql1="select  *  FROM gc_lien where id_division='$id_division' order by ordre";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_lien=$rang1['id_lien'];
$nom_lien=$rang1['nom'];
$url=$rang1['url'];
$descriptif=style($rang1['descriptif']);
$ordre_lien=$rang1['ordre'];
echo
"
<table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" >
  <tr bgcolor=\"#$couleur1\"> 
    <td ><div align=\"left\"><img src=\"images/config/lien.gif\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url\" target=\"blank\">$nom_lien</a></td>
  </tr>
   <tr bgcolor=\"#$couleur1\"> 
    <td ><div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $descriptif</td>
  </tr>
</table>
<br>



";
}
// fin affichage des liens 

}

// fin affichage des divisions

//affichage bas de page
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$bas</font>";
//fin : affichage bas de page
?>