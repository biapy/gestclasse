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

include('admilux/agenda/date_francais.php');


titre_page("Agenda");
// modification de la date de fin
if (isset($_POST['fj']) and $_POST['fj']<>'' and isset($_POST['fm']) and $_POST['fm']<>'' and isset($_POST['fa']) and $_POST['fa']<>'')
{
$fin=mktime(0,0,0,$_POST['fm'],$_POST['fj'],$_POST['fa']);
$sql="REPLACE INTO gc_agenda ( id_agenda,date,type,commentaire,site ) VALUES (1,'$fin','date_fin','date_fin','non')";
mysql_db_query($dbname,$sql,$id_link);
}

// insertion d'une date de vacances
if (isset($_POST['vdj']) and $_POST['vdj']<>'' and isset($_POST['vdm']) and $_POST['vdm']<>'' and isset($_POST['vda']) and $_POST['vda']<>'' and isset($_POST['vfj']) and $_POST['vfj']<>'' and isset($_POST['vfm']) and $_POST['vfm']<>'' and isset($_POST['vfa']) and $_POST['vfa']<>'')
{
$fin_vacances=mktime(0,0,0,$_POST['vfm'],$_POST['vfj'],$_POST['vfa']);
$debut_vacances=mktime(0,0,0,$_POST['vdm'],$_POST['vdj'],$_POST['vda']);
if ($debut_vacances<=$fin_vacances)
{
$sql="INSERT INTO gc_vacances( debut_vacances,fin_vacances) VALUES ('$debut_vacances','$fin_vacances')";
mysql_db_query($dbname,$sql,$id_link);
}
}

//suppression d'une date de vacances

if (isset($_GET['del_vacances']) and $_GET['del_vacances']=="ok")
{
	  $sql="select  *  FROM gc_vacances where id_vacances='$_GET[id_vacances]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $debut_vacances=date_francais(getdate($rang['debut_vacances']));
	  $fin_vacances=date_francais(getdate($rang['fin_vacances']));
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer les vacances du '.$debut_vacances.' au '.$fin_vacances.' définitivement de la base de données ');
	  if (isset($_GET['debut1']))
	  echo "
	  <p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=agenda&del_vacances=ok&id_vacances=$_GET[id_vacances]&debut1=$_GET[debut1]&del_confirmation=ok\">OUI</a></font>
	  <font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=agenda&debut1=$_GET[debut1]\">NON</a></font></p>
	  ";
	  else
	  echo "
	  <p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=agenda&del_vacances=ok&id_vacances=$_GET[id_vacances]&del_confirmation=ok\">OUI</a></font>
	  <font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=agenda\">NON</a></font></p>
	  "; 
	  }
	 if (isset($_GET['del_confirmation'])) 
	 {
	 	$sql="DELETE from gc_vacances WHERE id_vacances='$_GET[id_vacances]'";
		mysql_db_query($dbname,$sql,$id_link); ; 	
	 	message('Les vacances du '.$debut_vacances.' au '.$fin_vacances.' ont été supprimées définitivement de la base de données');
	 }
}

	

//date de début de l'agenda
if (isset($_GET['debut1'])) 
{
$debut=$_GET['debut1'] ;
$date_de_debut=getdate($debut);
$dj=$date_de_debut["mday"];
$dm=$date_de_debut["mon"];
$da=$date_de_debut["year"];
}
else if (isset($_POST['dj']) and $_POST['dj']<>'' and isset($_POST['dm']) and $_POST['dm']<>'' and isset($_POST['da']) and $_POST['da']<>'')
{
$dj=$_POST['dj'];
$dm=$_POST['dm'];
$da=$_POST['da'];
$_GET['debut1']=mktime(0,0,0,$dm,$dj,$da)+50000;//Pour éviter les pb de décallage horaire
$debut=$_GET['debut1'];
}
else
{
$debut=time();
$date_de_debut=getdate($debut);
$dj=$date_de_debut["mday"];
$dm=$date_de_debut["mon"];
$da=$date_de_debut["year"];
$debut=mktime(0,0,0,$dm,$dj,$da)+50000;
$debut1=$debut;
}

//date de fin de l'agenda
$sql="select  date  from gc_agenda where id_agenda='1'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
if (!isset($rang['date']))   $fin=time()+5356800; //ajout de 2 mois
else  $fin=$rang['date'];
if ($fin<time()) 
{
$fin=$debut+5356800;//ajout de 2 mois
message('N\'oubliez pas de modifier la date de fin de l\'agenda . Par défaut la date de fin et la date du jour + deux mois ');
}
$date_de_fin=getdate($fin);
$fj=$date_de_fin["mday"];
$fm=$date_de_fin["mon"];
$fa=$date_de_fin["year"];
?> 
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <td width="250" valign="top"> 
      <form action="admi.php?page_admi=agenda" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td> 
              <div align="left"></div>
              <table width="220" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100" height="20" valign="top"  > 
				  <?
				  if (isset($_GET['debut1']))
                  echo"<div align=\"left\"><font face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"admi.php?page_admi=agenda&debut1=$_GET[debut1]\"><font color=\"#FF6600\" size=\"2\">Actualiser</font></a></font></div></td>";
				  else
				  echo"<div align=\"left\"><font face=\"Arial, Helvetica, sans-serif\">&nbsp;<a href=\"admi.php?page_admi=agenda&debut1=$debut\"><font color=\"#FF6600\" size=\"2\">Actualiser</font></a></font></div></td>";
				  ?>
                  <td width="40" height="20"> 
                    <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">jour</font></div></td>
                  <td width="40" height="20"> 
                    <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">mois</font></div></td>
                  <td width="40" height="20"> 
                    <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">ann&eacute;e</font></div></td>
                </tr>
                <tr> 
                  <td width="100"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    &nbsp;d&eacute;but de l'agenda</font></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="dj" type="text"  value="<? echo $dj ?>" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="dm" type="text"  value="<? echo $dm ?>" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="da" type="text"  value="<? echo $da ?>" size="3">
                      </font></div></td>
                </tr>
                <tr> 
                  <td width="100"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;fin 
                    de l'agenda</font></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="fj" type="text" value="<? echo $fj ?>" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="fm" type="text" value="<? echo $fm ?>" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="fa" type="text"  value="<? echo $fa ?>" size="3">
                      </font></div></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td> <div align="left"> &nbsp;
<input type="submit" name="Submit22" value="Modifier">
                <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </font></div></td>
          </tr>
        </table>
      </form></td>
    <td width="252" valign="top"> 

<? if (isset($_GET['debut1']))
   echo " <form action=\"admi.php?page_admi=agenda&debut1=$_GET[debut1]\" method=\"post\">";
   else
   echo " <form action=\"admi.php?page_admi=agenda\" method=\"post\">";
   ?>        
        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr> 
            <td> 
              <table width="220" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100" height="20"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="40" height="20"> 
                    <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">jour</font></div></td>
                  <td width="40" height="20"> 
                    <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">mois</font></div></td>
                  <td width="40" height="20"> 
                    <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">ann&eacute;e</font></div></td>
                </tr>
                <tr> 
                  <td width="100"><font size="1" face="Arial, Helvetica, sans-serif">d&eacute;but 
                    des vacances</font></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="vdj" type="text" id="vdj5" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="vdm" type="text" id="vdm5" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="vda" type="text" id="vda5" size="3">
                      </font></div></td>
                </tr>
                <tr> 
                  <td width="100"><font size="1" face="Arial, Helvetica, sans-serif"> 
                    fin des vacances</font></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="vfj" type="text" id="vfj5" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="vfm" type="text" id="vfm5" size="3">
                      </font></div></td>
                  <td width="40"> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <input name="vfa" type="text" id="vfa5" size="3">
                      </font></div></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td> <div align="left"> 
                <input type="submit" name="Submit2" value="Ajouter">
              </div></td>
          </tr>
        </table>
      </form></td>
    <td valign="top"> <br>
      <?
	  // affichage des dates de vacances
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
	  $debut_des_vacances=date_francais(getdate($debut_vacances));
	  $fin_des_vacances=date_francais(getdate($fin_vacances));
	  $fin_vac[$nb_vacances]=$fin_vacances;
	  if ( $debut<$fin_vacances )
	  {
	  if (isset($_GET['debut1']))
	  echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=agenda&del_vacances=ok&id_vacances=$id_vacances&debut1=$_GET[debut1]\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>  du $debut_des_vacances au $fin_des_vacances </font><br> ";
	  else
	  echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=agenda&del_vacances=ok&id_vacances=$id_vacances\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a>  du $debut_des_vacances au $fin_des_vacances </font><br> "; 
	  }
	  }
	?>
    </td>
  </tr>
</table>
  <?

// affichage de l'agenda
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
	if (subStr($couleur5,0,2)=="im") echo"<td width=\"20%\" valign=\"top\" class=\"borduredroite\" background=\"$couleur5\"><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\">  <font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/agenda/commentaire.php?jour=$debut\" target=\"_blank\">$jour $date $mois</a></font></td>";
	else echo"<td width=\"20%\" valign=\"top\" class=\"borduredroite\" bgcolor=\"#$couleur5\"><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\">  <font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/agenda/commentaire.php?jour=$debut\" target=\"_blank\">$jour $date $mois</a></font></td>";
}
else echo"<td width=\"20%\" valign=\"top\" class=\"borduredroite\"><img src=\"images/config/sous_titre.gif\"  align=\"absmiddle\">  <font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/agenda/commentaire.php?jour=$debut\" target=\"_blank\">$jour $date $mois</a></font></td>";
echo "
    <td width=\"80%\" valign=\"top\" >";
	
	// affichage des commentaires
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
			if ($site=='ok') echo "<img src=\"admilux/agenda/image/site.gif\" align=\"absmiddle\">";
			if ($site<>'non' and $site<>'ok') echo "<img src=\"admilux/agenda/image/classe.gif\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$site</font>";
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
	   echo "<img src=\"admilux/agenda/image/classe.gif\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=cahier_texte&classe=$classe\">$classe</a></font><br>";
	  
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
