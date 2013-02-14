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

include('admilux/agenda/date_francais.php');


titre_page("Agenda");
echo "<br>";
if (!isset($_SESSION['classe_active']) and !isset($_SESSION['admilogin'])) message("Connectez-vous pour consulter les dates importantes de votre classe");


//debut de l'agenda
$debut=time();
$date_de_debut=getdate($debut);
$dj=$date_de_debut["mday"];
$dm=$date_de_debut["mon"];
$da=$date_de_debut["year"];
$debut=mktime(0,0,0,$dm,$dj,$da)+50000;



//date de fin de l'agenda
$sql="select  date  from gc_agenda where id_agenda='1'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$fin=$rang['date'];
$date_de_fin=getdate($fin);
$fj=$date_de_fin["mday"];
$fm=$date_de_fin["mon"];
$fa=$date_de_fin["year"];
?> 
<?

// affichage de l'agenda
if ($fin=='')  $fin=time()+5356800; //ajout de 2 mois
if ($fin<time()) $fin=$debut+5356800;//ajout de 2 mois
$nb_vacances=0;
$sql="select  *  from gc_vacances";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$nb_vacances++;
$id_vacances=$rang['id_vacances'];
$debut_vacances=$rang['debut_vacances'];
$fin_vacances=$rang['fin_vacances'];
$debut_vac[$nb_vacances]=$debut_vacances;
$fin_vac[$nb_vacances]=$fin_vacances;
}

while ($debut<$fin+86400)
{
$date_du_jour=getdate($debut); 
$vacances="non";
if($nb_vacances<>0)
{
	for($i=1;$i<=$nb_vacances;$i++)
	{
		if ($debut>=$debut_vac[$i] and $debut<$fin_vac[$i]+86400)
		{
		$vacances="ok";
		$i=$nb_vacances;
		}
	}
}
if ($vacances=='ok') $couleur=$couleur1;
else $couleur='#ffffff';
$date=$date_du_jour["mday"];
$jour=jour_fr($date_du_jour["weekday"]);
if (!isset($mois)) 
{
	if (subStr($couleur5,0,2)=="im") echo "<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"borduregrise\"><tr ><td background=\"$couleur5\"><p align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">".mois_fr($date_du_jour['month'])."</font></p></td></tr>";
	else echo "<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"borduregrise\"><tr bgcolor=\"#$couleur5\"  ><td><p align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">".mois_fr($date_du_jour['month'])."</font></p></td></tr>";
}
if ( isset($mois) and mois_fr($mois)<>mois_fr($date_du_jour["month"]))  
{
	if (subStr($couleur5,0,2)=="im") echo "</table><br><table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"borduregrise\"><tr ><td background=\"$couleur5\"><p align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">".mois_fr($date_du_jour['month'])."</font></p></td></tr>";
	else echo "</table><br><table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"borduregrise\"><tr bgcolor=\"#$couleur5\" ><td><p align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">".mois_fr($date_du_jour['month'])."</font></p></td></tr>";
}
$mois=mois_fr($date_du_jour["month"]);

echo "
<tr bgcolor=\"$couleur\"><td class=\"bordurehaute\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>";
if ($jour=='dimanche') 
{
	if (subStr($couleur5,0,2)=="im") echo"<td width=\"20%\" valign=\"top\" class=\"borduredroite\" background=\"$couleur5\"><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\">  <font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">$jour $date $mois</font></td>";
	else echo"<td width=\"20%\" valign=\"top\" class=\"borduredroite\" bgcolor=\"#$couleur5\"><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\">  <font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">$jour $date $mois</font></td>";
}
else echo"<td width=\"20%\" valign=\"top\" class=\"borduredroite\"><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\">  <font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">$jour $date $mois</font></td>";
echo "
    <td width=\"80%\" valign=\"top\" >";

// affichage des commentaires connecté en tant que prof
if (isset($_SESSION['admilogin']) and isset($_SESSION['admipasse']) and $_SESSION['admilogin']==LOGIN_PROF  and $_SESSION['admipasse']==PASSE_PROF ) 
{
	  $sql="select  *  from gc_agenda where date>('$debut'-7202) and date<('$debut'+7202) order by id_agenda";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat))
	  {
	  $id_agenda=$rang['id_agenda'];
	  $type=$rang['type'];
	  $commentaire=style($rang['commentaire']);
	  $site=$rang['site'];
	  switch ($type)
			{
			case "aucun": echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$commentaire</font>" ; break;
			case "faire": echo "<img src=\"admilux/agenda/image/afaire.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "reunion": echo "<img src=\"admilux/agenda/image/reunion.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "parents_profs": echo "<img src=\"admilux/agenda/image/parents_profs.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "rdv": echo "<img src=\"admilux/agenda/image/rendez_vous.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "conseil": echo "<img src=\"admilux/agenda/image/conseil.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$commentaire</font>" ; break;
			case "arret_notes": echo "<img src=\"admilux/agenda/image/arret_notes.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "devoir": echo "<img src=\"admilux/agenda/image/devoir.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "blanc": echo "<img src=\"admilux/agenda/image/examen_blanc.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "examen": echo "<img src=\"admilux/agenda/image/examen.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "formation": echo "<img src=\"admilux/agenda/image/formation.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "sortie": echo "<img src=\"admilux/agenda/image/sortie.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "debut_cours": echo "<img src=\"admilux/agenda/image/debut_cours.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "fin_cours": echo "<img src=\"admilux/agenda/image/fin_cours.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
				}
			if ($site<>'non' and $site<>'ok') echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> : $site</font>";
			echo "<br>";
 }
 //sélection des messages postés dans le cahier de texte
      $date=$jour." ".$date." ".$mois;
 	  $sql="select  id_com_classe,classe,commentaire,type,jour  from gc_cahier_texte where pour='$date' and (type='faire' or type='dm' or type='devoir_venir')";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat))
	  { 
	  $id_com_classe=$rang['id_com_classe'];
	  $classe=$rang['classe'];
	  $commentaire=$rang['commentaire'];
	  $type=style($rang['type']);
	  $jour=style($rang['jour']);
	  $sql1="select  jour  from gc_cahier_texte where id_com_classe='$jour'";
	  $resultat1=mysql_db_query($dbname,$sql1,$id_link);
	  $rang1=mysql_fetch_array($resultat1);
	  $jour=style($rang1['jour']);
	  switch ($type)
			{
			case "faire": echo "<img src=\"admilux/agenda/image/afaire.gif\" align=\"absmiddle\" title=\"message posté dans le cahier de texte le $jour\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$commentaire</font>" ; break;
			case "dm": echo "<img src=\"admilux/agenda/image/dm.gif\" align=\"absmiddle\" title=\"message posté dans le cahier de texte le $jour\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "devoir_venir": echo "<img src=\"admilux/agenda/image/devoir.gif\" align=\"absmiddle\" title=\"message posté dans le cahier de texte le $jour\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
		   }
            echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> : $classe</font><br>";
			}
}	
// affichage des commentaires connecté en tant qu'élève	

else
{	
	
	  $sql="select  *  from gc_agenda where date>('$debut'-7202) and date<('$debut'+7202)  order by id_agenda";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat))
	  {
	  $id_agenda=$rang['id_agenda'];
	  $type=$rang['type'];
	  $commentaire=style($rang['commentaire']);
	  $site=$rang['site'];
	  if ($site=='ok' or (isset($_SESSION['classe_active']) and $site==$_SESSION['classe_active']))
	  {
	  switch ($type)
			{
			case "aucun": echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$commentaire</font>" ; break;
			case "faire": echo "<img src=\"admilux/agenda/image/afaire.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "reunion": echo "<img src=\"admilux/agenda/image/reunion.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "parents_profs": echo "<img src=\"admilux/agenda/image/parents_profs.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "rdv": echo "<img src=\"admilux/agenda/image/rendez_vous.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "conseil": echo "<img src=\"admilux/agenda/image/conseil.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$commentaire</font>" ; break;
			case "arret_notes": echo "<img src=\"admilux/agenda/image/arret_notes.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "devoir": echo "<img src=\"admilux/agenda/image/devoir.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "blanc": echo "<img src=\"admilux/agenda/image/examen_blanc.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "examen": echo "<img src=\"admilux/agenda/image/examen.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "formation": echo "<img src=\"admilux/agenda/image/formation.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "sortie": echo "<img src=\"admilux/agenda/image/sortie.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "debut_cours": echo "<img src=\"admilux/agenda/image/debut_cours.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
			case "fin_cours": echo "<img src=\"admilux/agenda/image/fin_cours.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font>" ; break;
				}
			echo "<br>";
		}
		}
 	  //sélection des messages postés dans le cahier de texte
      $date=$jour." ".$date." ".$mois;
 	  $sql2="select  id_com_classe,classe,commentaire,type,jour  from gc_cahier_texte where pour='$date' and (type='faire' or type='dm' or type='devoir_venir')";
	  $resultat2=mysql_db_query($dbname,$sql2,$id_link);
	  while($rang2=mysql_fetch_array($resultat2))
	  { 
	  $id_com_classe=$rang2['id_com_classe'];
	  $classe=$rang2['classe'];
	  $commentaire=$rang2['commentaire'];
	  $type=style($rang2['type']);
	  $jour=style($rang2['jour']);
	  $sql1="select  jour  from gc_cahier_texte where id_com_classe='$jour'";
	  $resultat1=mysql_db_query($dbname,$sql1,$id_link);
	  $rang1=mysql_fetch_array($resultat1);
	  $jour=style($rang1['jour']);
	  if ((isset($_SESSION['classe_active']) and $classe==$_SESSION['classe_active']))
	  switch ($type)
			{
			case "faire": echo "<img src=\"admilux/agenda/image/afaire.gif\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$commentaire</font><br>" ; break;
			case "dm": echo "<img src=\"admilux/agenda/image/dm.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font><br>" ; break;
			case "devoir_venir": echo "<img src=\"admilux/agenda/image/devoir.gif\" align=\"absmiddle\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font><br>" ; break;
		   }

	  }
}
echo "
	</td>
  </tr>
</table>
</td></tr>";

$debut=$debut+86400;
} 
echo "</table>";
?>
