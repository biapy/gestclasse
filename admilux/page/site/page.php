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

//page active
if (isset($_GET['id_page_sous_titre']) and $_GET['id_page_sous_titre']<>null) $id_page_active=$_GET['id_page_sous_titre'];
else $id_page_active=$_GET['id_page'] ;

$sql="select  titre,classe  FROM gc_page where id_page='$_GET[id_page]'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$titre=$rang['titre'];
$classe=$rang['classe'];

// déclaration de la fonction traitant les types de contenu automatique
function contenu_auto ($type,$couleur1,$url_auto,$nom_auto,$contenu_auto)
{
if ($type=='cours') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/cours.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='TD') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/td.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='TP') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/tp.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='activité') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/activite.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='devoir') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/devoir.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='devoir maison') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/dm.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='interrogation') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/i.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}
if ($type=='animation') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/animation.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}

if ($type=='révision') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/revision.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}


if ($type=='exercice') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/exercice.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}

if ($type=='document') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/document.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}

if ($type=='en ligne') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/en_ligne.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}

if ($type=='salle info') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td width=\"10%\"><div align=\"center\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/info.gif\" border=\"0\"></a></div></td>    
    <td width=\"90%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;- $nom_auto  $contenu_auto</font></td>
  </tr>
</table>";
}

if ($type=='aucun') 
{ 
echo "
<table width=\"80%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">
  <tr bgcolor=\"#$couleur1\">
    <td ><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank >$nom_auto</a>
       &nbsp;$contenu_auto</font><div></td>
  </tr>
</table>";
} 
}
// fin fontion contenu_auto

?>


    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td >
		<?
		if ( $classe<>"aucune restriction" )titre_page("$classe - $titre");
		else titre_page($titre);
		 ?>
		 </td> 
	  </tr>
	  <tr>
        <td>
			<?
			// affichage des sous titres
			if (isset($_SESSION['classe_active'])) ($sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='$_GET[id_page]' and (classe='$_SESSION[classe_active]' or classe='aucune restriction') order by ordre");
			else if (isset($_SESSION['admilogin'])) ($sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='$_GET[id_page]' order by ordre");
			else $sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='$_GET[id_page]' and classe='aucune restriction' order by ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo"<table align=\"left\" ><tr>";
			while($rang=mysql_fetch_array($resultat))
			{
			$id_page_sous_titre1=$rang['id_page']; 
			$sous_titre=$rang['titre'];
			$classe1=$rang['classe'];
			if (isset($_GET['id_page_sous_titre']) and $id_page_sous_titre1==$_GET['id_page_sous_titre'])
			{
			if (isset($_SESSION['admilogin']) and $classe1<>"aucune restriction") sous_titre("<font size=\"1\">$classe1 :</font> $sous_titre","selection");
			else sous_titre("$sous_titre","selection");
			}
			else
			{
			if (isset($_SESSION['admilogin']) and $classe1<>"aucune restriction") sous_titre("<font size=\"1\">$classe1 :</font> $sous_titre","index.php?page=page&id_page=$_GET[id_page]&id_page_sous_titre=$id_page_sous_titre1");
			else sous_titre("$sous_titre","index.php?page=page&id_page=$_GET[id_page]&id_page_sous_titre=$id_page_sous_titre1");
			}
		
			}
			echo "<tr></table>";
		  	?>
	  </td>
      </tr>
    </table>
		

          
            <?
			//affichage de la liste des divisions		
			$sql="select  count(id_division)  FROM gc_division_page where id_page='$id_page_active'";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$nb=$rang[0];
			if ( $nb<>"0")
			{
			$sql="select  *  FROM gc_division_page where id_page='$id_page_active' ORDER BY ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo "<div align=\"center\"><form name=\"divisions\"><select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">";
			while($rang=mysql_fetch_array($resultat))
			{
			$id_division=$rang[id_division];
			$nom_division=$rang[nom_division];
			echo "<option value=\"#$id_division\">$nom_division</option>";
			}
			echo "</select></div></form>";
			}
			?>
  	
<p> 
  <?


//affichage haut de page
$sql="select  *  FROM gc_contenu_page where id_page='$id_page_active'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$haut=$rang['haut'];
$bas=$rang['bas'];
$haut=style($haut);
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$haut</font>";


//affichage du contenu automatique dans la page
$sql1="select  *  FROM gc_contenu_auto where id_division='$id_page_active' and sans_division='1' and accueil<>'2' order by ordre";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_auto=$rang1['id_auto'];
$type=$rang1['type'];
if ($rang1['nom']<>'' and $type<>'aucun') $nom_auto=$rang1['nom'].' : ';
else $nom_auto=$rang1['nom'];
$url_auto=$rang1['url'];
if ($rang1['contenu']<>'' and $type=='aucun') $contenu_auto=': '.$rang1['contenu'];
else $contenu_auto=$rang1['contenu'];
$ordre_auto=$rang1['ordre'];

contenu_auto ($type,$couleur1,$url_auto,$nom_auto,$contenu_auto);
}
// fin : affichage du contenu automatique  dans la page


//fin : affichage haut de page


// affichage des divisions
$sql="select  *  FROM gc_division_page where id_page='$id_page_active' order by ordre ";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_division=$rang['id_division'];
$nom_division=$rang['nom_division'];
$contenu=$rang['contenu'];
$ordre=$rang['ordre'];
echo "<a name=\"$id_division\"></a>";
titre_division(" $nom_division ");
$contenu=style($contenu);
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$contenu</font>";



//affichage du contenu automatique 
$sql1="select  *  FROM gc_contenu_auto where id_division='$id_division' and sans_division='0' and accueil<>'2' order by ordre";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$type=$rang1['type'];
if ($rang1['nom']<>'' and $type<>'aucun') $nom_auto=$rang1['nom'].' : ';
else $nom_auto=$rang1['nom'];
$url_auto=$rang1['url'];
if ($rang1['contenu']<>'' and $type=='aucun') $contenu_auto=': '.$rang1['contenu'];
else $contenu_auto=$rang1['contenu'];
$ordre_auto=$rang1['ordre'];

contenu_auto ($type,$couleur1,$url_auto,$nom_auto,$contenu_auto);
}
// fin : affichage du contenu automatique et des formulaires de modification

}

// fin : affichage des divisions



//affichage bas de page

$bas=style($bas);
echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">$bas</font>";


//fin : affichage bas de page
 
?>
