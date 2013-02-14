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

titre_page("Plan du site");


//affichage des titres et des sous titres


$sql="select  titre, id_page, classe  FROM gc_page where sous_titre_de='0' order by ordre";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while( $rang=mysql_fetch_array($resultat))
{
if (subStr($couleur5,0,2)=="im") echo "<br><table width=\"75%\" class=\"bordure\" background=\"$couleur5\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" align=\"center\"><tr><td>";
else echo "<br><table width=\"75%\" class=\"bordure\" bgcolor=\"$couleur5\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" align=\"center\"><tr><td>";

$titre=$rang['titre'];
$id_page=$rang['id_page'];
$classe=$rang['classe'];

if (isset($_SESSION['classe_active']))
{
if ($classe=="aucune restriction") echo "<img src=\"images/config/lien.gif\" ><a href=\"index.php?page=page&id_page=$id_page\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$titre</font></a></tr></td>";
else if ($classe==$_SESSION['classe_active']) echo "<img src=\"images/config/lien.gif\" ><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" ><a href=\"index.php?page=page&id_page=$id_page\">$titre</a> </font> <font face=\"Arial, Helvetica, sans-serif\" size=\"1\" >( Rubrique réservée à la classe $classe )  </font></tr></td>";
else echo "<img src=\"images/config/lien.gif\" ><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" color=\"#999999\" >$titre </font> <font face=\"Arial, Helvetica, sans-serif\" size=\"1\" color=\"#999999\" >( Rubrique réservée à la classe $classe )  </font></tr></td>";
}
else if (isset($_SESSION['admilogin']))
{
if ($classe=="aucune restriction") echo "<img src=\"images/config/lien.gif\" ><a href=\"index.php?page=page&id_page=$id_page\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$titre</font></a></tr></td>";
else echo "<img src=\"images/config/lien.gif\" ><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" ><a href=\"index.php?page=page&id_page=$id_page\">$titre </a></font> <font face=\"Arial, Helvetica, sans-serif\" size=\"1\" >( Rubrique réservée à la classe $classe )  </font></tr></td>";
}
else
{
if ($classe=="aucune restriction") echo "<img src=\"images/config/lien.gif\" ><a href=\"index.php?page=page&id_page=$id_page\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$titre</font></a></tr></td>";
else echo "<img src=\"images/config/lien.gif\" ><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" color=\"#999999\">$titre </font> <font face=\"Arial, Helvetica, sans-serif\" size=\"1\" color=\"#999999\" >( Rubrique réservée à la classe $classe )  </font></tr></td>";
}
echo "</table>";
//les sous titre
	$sql1="select  titre, id_page,classe  FROM gc_page where sous_titre_de='$id_page'";
	$resultat1=mysql_db_query($dbname,$sql1,$id_link);
	while( $rang1=mysql_fetch_array($resultat1))
	{
	$sous_titre=$rang1['titre'];
	$id_page_sous_titre=$rang1['id_page']; 
	$classe=$rang1['classe'];
	echo "<table width=\"65%\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td > - ";

		if (isset($_SESSION['classe_active']))
		{
		if ($classe=="aucune restriction") echo "<a href=\"index.php?page=page&id_page=$id_page&id_page_sous_titre=$id_page_sous_titre\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$sous_titre</font></a></td>";
		else if ($classe==$_SESSION['classe_active']) echo "<a href=\"index.php?page=page&id_page=$id_page&id_page_sous_titre=$id_page_sous_titre\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$sous_titre</font></a><font face=\"Arial, Helvetica, sans-serif\" size=\"1\" > ( Rubrique réservée à la classe $classe )  </font></td>";
		else echo "<font face=\"Arial, Helvetica, sans-serif\" size=\"2\" color=\"#999999\">$sous_titre</font><font face=\"Arial, Helvetica, sans-serif\" size=\"1\" color=\"#999999\"> ( Rubrique réservée à la classe $classe )  </font></td>";
		}
		else if (isset($_SESSION['admilogin']))
		{
		if ($classe=="aucune restriction") echo "<a href=\"index.php?page=page&id_page=$id_page&id_page_sous_titre=$id_page_sous_titre\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$sous_titre</font></a></td>";
		else echo "<a href=\"index.php?page=page&id_page=$id_page&id_page_sous_titre=$id_page_sous_titre\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$sous_titre</font></a> </font><font face=\"Arial, Helvetica, sans-serif\" size=\"1\" > ( Rubrique réservée à la classe $classe )  </font></td>";
		}
		else
		{
		if ($classe=="aucune restriction") echo "<a href=\"index.php?page=page&id_page=$id_page&id_page_sous_titre=$id_page_sous_titre\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" >$sous_titre</font></a></td>";
		else echo "<font face=\"Arial, Helvetica, sans-serif\" size=\"2\" color=\"#999999\">$sous_titre</font><font face=\"Arial, Helvetica, sans-serif\" size=\"1\" color=\"#999999\"> ( Rubrique réservée à la classe $classe )  </font></td>";
		}
	
    echo"</tr></table>";

	} 
} 
?>
