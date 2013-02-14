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


titre_page("Gestion des rubriques");

//suppression d'un titre

if ( isset($_GET['supp_titre']) and $_GET['supp_titre']=="ok")
{
	  $sql="select  titre  FROM gc_page where id_page='$_GET[id_page]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $titre2=$rang['titre'];
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer la rubrique '.$titre2.' définitivement de la base de données et toutes les sous-rubriques dépendant de cette rubrique');
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=plan&supp_titre=ok&id_page=$_GET[id_page]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=plan\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 { 
	 $sql="DELETE FROM gc_page WHERE id_page='$_GET[id_page]' or sous_titre_de='$_GET[id_page]'";
	 mysql_db_query($dbname,$sql,$id_link);
	 message('la rubrique '.$titre2.' et toutes les sous-rubriques dépendant de cette rubrique ont été supprimées définitivement de la base de données');
	 }
	 
}

//suppression d'un sous titre
if ( isset($_GET['supp_sous_titre']) and $_GET['supp_sous_titre']=="ok")
{
	  $sql="select  titre,sous_titre_de  FROM gc_page where id_page='$_GET[id_page_sous_titre]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $titre2=$rang['titre'];
	  $sous_titre_de=$rang['sous_titre_de'];
	  $sql="select  titre FROM gc_page where id_page='$sous_titre_de'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $sous_titre_de=$rang['titre'];
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer la sous-rubrique '.$titre2.' de la rubrique '.$sous_titre_de);
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=plan&supp_sous_titre=ok&id_page_sous_titre=$_GET[id_page_sous_titre]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=plan\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 { 
	 $sql="DELETE FROM gc_page WHERE id_page='$_GET[id_page_sous_titre]'";
	 mysql_db_query($dbname,$sql,$id_link);
	 message('la sous-rubrique '.$titre2.' de la rubrique '.$sous_titre_de.' a été supprimée définitivement de la base de données');
	 }
	 
}



// affichage du formulaire pour ajouter un titre
echo "
<table width=\"100%\"  border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" bgcolor=\"#$couleur1\">
    <form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=plan&ajout_titre=ok\">
	<tr> 
      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Ajouter une
        rubrique : </strong></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
        <input type=\"submit\" name=\"Submit2\" value=\"ok\">
        </font></td>
    </tr>
    <tr> 
      <td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font> 
          <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
          <input type=\"text\" name=\"ordre_titre\" size=\"1\" value=\"\">
          titre</font> 
          <input name=\"titre\" type=\"text\" size=\"30\">
        </div></td>
    </tr>
	";

                echo "<tr><td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> Rubrique concernant uniquement la classe de </font><select name=\"classe\">";
                $sql="select  classe  from gc_classe";
                $resultat=mysql_db_query($dbname,$sql,$id_link);
				echo"<option>aucune restriction</option>";
                while($rang=mysql_fetch_array($resultat))
                {
                $classe=$rang[classe];
                echo"<option>$classe</option>";
				}
                echo "</select></div></td></tr>";

echo"</form></table><hr><br>";
			
//affichage des titres et des sous titres
$sql="select  titre, id_page, classe, ordre  FROM gc_page where sous_titre_de='0' order by ordre";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while( $rang=mysql_fetch_array($resultat))
{
echo "<table width=\"100%\" bgcolor=\"#$couleur1\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" align=\"center\"><tr>";
$titre=$rang['titre'];
$id_page=$rang['id_page']; 
$ordre=$rang['ordre']; 
$classe_titre=$rang['classe']; 
echo "<td width=\"200\">
		<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
			<tr>
				<td width=\"170\">
					<img src=\"images/config/lien.gif\"><a href=\"admi.php?page_admi=page&id_page=$id_page\"><font face=\"Arial, Helvetica, sans-serif\" >$titre</font></a>
				</td>
				<td >
					<a href=\"admi.php?page_admi=plan&supp_titre=ok&id_page=$id_page\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>
				</td>
			</tr>
		</table>
	 <td>";

echo 
"
<td>
<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=plan&modif_titre=ok&id_page=$id_page\">
  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font>
  <input type=\"text\" name=\"ordre\" size=\"1\" value=\"$ordre\">
  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">titre</font>
  <input type=\"text\" name=\"titre_modif\" size=\"30\" value=\"$titre\">
";
                echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> concernant </font><select name=\"classe\">";
                $sql2="select  classe  from gc_classe";
                $resultat2=mysql_db_query($dbname,$sql2,$id_link);
				echo"<option>$classe_titre</option>";
				echo"<option>aucune restriction</option>";
                while($rang2=mysql_fetch_array($resultat2))
                {
                $classe=$rang2[classe];
                if ($classe_titre<>$classe) echo"<option>$classe</option>";
				}
                echo "</select>";
echo " <input type=\"submit\" name=\"Submit\" value=\"modifier\"></form></td></table>";

// ajout d'un sous titre

echo "
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tr>
	<td width=\"200\" bgcolor=\"#$couleur1\">
		<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=plan&ajout_sous_titre=ok&id_page=$id_page\">
         <div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Ajouter une 
          sous rubrique</strong></font></div>
	</td>
	<td>
        <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font>
		<input type=\"text\" name=\"ordre\" size=\"1\" value=\"\">
		<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">titre</font>
		<input name=\"sous_titre\" type=\"text\" size=\"30\">
		<input type=\"submit\" name=\"Submit\" value=\"ajouter\">
	</td>
</tr>
";

                echo "<tr><td width=\"200\" bgcolor=\"#$couleur1\"></td><td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> Rubrique concernant uniquement la classe de </font><select name=\"classe\">";
                $sql1="select  classe  from gc_classe";
                $resultat1=mysql_db_query($dbname,$sql1,$id_link);
				echo"<option>aucune restriction</option>";
                while($rang1=mysql_fetch_array($resultat1))
                {
                $classe=$rang1[classe];
				echo"<option>$classe</option>";
				}
                echo "</select></td></tr>";

echo"</table></form>" ;

//affichage des sous titre
	$sql1="select  titre, id_page, ordre , classe  FROM gc_page where sous_titre_de='$id_page' order by ordre";
	$resultat1=mysql_db_query($dbname,$sql1,$id_link);
	$cpt=1;
	while( $rang1=mysql_fetch_array($resultat1))
	{
	if ($cpt=="1") echo"<img src=\"images/config/sous_rubriques.gif\">";
	$cpt++;
	$sous_titre=$rang1['titre'];
	$id_page_sous_titre=$rang1['id_page']; 
	$ordre_sous_titre=$rang1['ordre']; 
	$classe_sous_titre=$rang1['classe']; 
	echo "
	<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
  	
	<tr>
    	<td width=\"200\" bgcolor=\"#$couleur1\">
			<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
			<tr>
				<td width=\"170\">
					<a href=\"admi.php?page_admi=page&id_page=$id_page&id_page_sous_titre=$id_page_sous_titre\"><font face=\"Arial, Helvetica, sans-serif\" >$sous_titre</font></a>
				</td>
				<td >

					<a href=\"admi.php?page_admi=plan&supp_sous_titre=ok&id_page_sous_titre=$id_page_sous_titre\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>
				</td>
			</tr>
			</table>
		</td>
    	<td>
		<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=plan&modif_titre=ok&id_page=$id_page_sous_titre\">
    		<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">ordre</font>
  			<input type=\"text\" name=\"ordre\" size=\"1\" value=\"$ordre_sous_titre\">			
			<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">titre</font>
			<input type=\"text\" name=\"titre_modif\" value=\"$sous_titre\">";
			
                echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> concernant </font><select name=\"classe\">";
                $sql2="select  classe  from gc_classe";
                $resultat2=mysql_db_query($dbname,$sql2,$id_link);
				echo"<option>$classe_sous_titre</option>";
				echo"<option>aucune restriction</option>";
                while($rang2=mysql_fetch_array($resultat2))
                {
                $classe=$rang2[classe];
                if ($classe_sous_titre<>$classe) echo"<option>$classe</option>";
				}
                echo "</select>";
				
		echo"<input type=\"submit\" name=\"Submit\" value=\"modifier\"></form></td>	</tr></table>";
	} 
echo "<hr>";
} 
message('- Si vous supprimez une rubrique, seule la référence à cette rubrique dans la table gc_page est supprimée.<br>- Vous pouvez restreindre l\'accès d\'une rubrique à une classe : dans ce cas il est nécessaire que l\'élève se connecte pour accèder à la rubrique.<br>- Si vous êtes connecté en tant que professeur, vous pouvez accèder à toutes les rubriques du site.');
?>
