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
session_start();
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

include("../../commun/connect.php");
include("../../commun/texte.php");
include("../../commun/fonction.php");

?>
<link href="../../commun/style.css" rel="stylesheet" type="text/css">
<p><img src="../../images/config/logogestclasse.gif" width="110" height="25" align="absmiddle"> 
  <a href="../../commun/style_gestclasse.php" target="_blank"><font color="#999999" size="2" face="Arial, Helvetica, sans-serif">Les 
  styles de Gest'classe</font></a></p>
  
<?

$jour=$_GET['jour'];
$date_francais=date_francais(getdate($jour));
echo "<p align=\"center\"><font size=\"3\" face=\"Arial, Helvetica, sans-serif\">$date_francais</font></p>";



//suppression d'un commentaire
if (isset($_GET['del_commentaire']))
{
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message2('Voulez-vous vraiment supprimer ce commentaire définitivement de la base de données');
	  echo "<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../images/config/lien.gif\"  align=\"absmiddle\"><a href=\"commentaire.php?del_commentaire=ok&id_agenda=$_GET[id_agenda]&jour=$jour&del_confirmation=ok\">OUI</a></font>";
      echo "<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../../images/config/lien.gif\" align=\"absmiddle\"><a href=\"commentaire.php?jour=$jour\">NON</a></font></p>";
	  }
	  if (isset($_GET['del_confirmation']) and $_GET['del_confirmation']='ok') 
	  {
	  $sql="delete  from gc_agenda where id_agenda='$_GET[id_agenda]'";
	  mysql_db_query($dbname,$sql,$id_link);
	  message2('Le commentaire a définitivement été supprimé de la base de données');
	  }
}

//modification d'un commentaire en cours ...
if (isset($_GET['modifier_commentaire']) and $_GET['modifier_commentaire']=="ok")
{
	 $sql="select *  from gc_agenda where id_agenda='$_GET[id_agenda]'";
	 $resultat=mysql_db_query($dbname,$sql,$id_link);
	 $rang=mysql_fetch_array($resultat);
	 $modif_type=$rang['type'];
	 $modif_commentaire=$rang['commentaire'];
	 $modif_site=$rang['site'];
	 
}

//modifier le commentaire
if (isset($_GET['modifier_le_commentaire']) and $_GET['modifier_le_commentaire']=="ok")
{
	$_POST['commentaire']=texte($_POST['commentaire']);
	if ( isset($_POST['site']) and $_POST['site']=='prof') $site='non';
	if ( isset($_POST['site']) and $_POST['site']=='site') $site='ok';
	if ( isset($_POST['site']) and $_POST['site']=='classe') $site=$_POST['classe'];
	if ($site<>'de :')
	{
	$sql="UPDATE gc_agenda SET type='$_POST[type]', commentaire='$_POST[commentaire]', site='$site' where id_agenda='$_GET[id_agenda]' ";
	mysql_db_query($dbname,$sql,$id_link);
	}
	else message2 ("Il faut sélectionner une classe");
	 
}

//ajouter un commentaire
if (isset($_GET['ajout_commentaire']) and $_GET['ajout_commentaire']=="ok")
{
	$_POST['commentaire']=texte($_POST['commentaire']);
	if ( isset($_POST['site']) and $_POST['site']=='prof') $site='non';
	if ( isset($_POST['site']) and $_POST['site']=='site') $site='ok';
	if ( isset($_POST['site']) and $_POST['site']=='classe') $site=$_POST['classe'];
	if ($site<>'de :')
	{
	$sql="INSERT INTO gc_agenda ( date, type, commentaire, site ) VALUES ('$_GET[jour]','$_POST[type]','$_POST[commentaire]','$site')";
	mysql_db_query($dbname,$sql,$id_link);
	}
	else message2 ("Il faut sélectionner une classe");
}

if (isset($_GET['modifier_commentaire']) and $_GET['modifier_commentaire']=="ok") echo "<form name=\"form1\" method=\"post\" action=\"commentaire.php?modifier_le_commentaire=ok&jour=$jour&id_agenda=$_GET[id_agenda]\">";
else echo "<form name=\"form1\" method=\"post\" action=\"commentaire.php?ajout_commentaire=ok&jour=$jour\">";
?> 

<form name=\"form1\" method=\"post\" action=\"commentaire.php?ajout_commentaire=ok&jour=$jour\">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr bgcolor="#F4F4F4"> 
      <td width="100"><font face="Arial, Helvetica, sans-serif">Type</font></td>
      <td><div align="left"> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Aucun 
                  </font></div></td>
              <td width="7%"> <div align="center"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">A 
                  faire </font></div></td>
              <td width="7%"> <div align="center"><font color="#FFCC00" size="1" face="Arial, Helvetica, sans-serif">R&eacute;union</font></div></td>
              <td width="7%"> <div align="center"><font color="#FFCC00" size="1" face="Arial, Helvetica, sans-serif">Rencontres 
                  parents-profs</font></div></td>
              <td width="7%"> <div align="center"><font color="#FFCC00" size="1" face="Arial, Helvetica, sans-serif">Rendez-vous</font></div></td>
              <td width="7%"> <div align="center"><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">Conseil 
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  </font><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">Arr&ecirc;t 
                  des notes</font></div></td>
              <td width="7%"> <div align="center"><font color="#990099" size="1" face="Arial, Helvetica, sans-serif">Devoir</font></div></td>
              <td width="7%"> <div align="center"><font color="#990099" size="1" face="Arial, Helvetica, sans-serif">Examen 
                  blanc </font></div></td>
              <td width="7%"> <div align="center"><font color="#990099" size="1" face="Arial, Helvetica, sans-serif">Examen</font></div></td>
              <td width="7%"> <div align="center"><font color="#000099" size="1" face="Arial, Helvetica, sans-serif">Formation</font></div></td>
              <td width="7%"> <div align="center"><font color="#339900" size="1" face="Arial, Helvetica, sans-serif">Sortie</font></div></td>
              <td><div align="center"><font color="#0000FF" size="1" face="Arial, Helvetica, sans-serif">D&eacute;but 
                  des cours </font></div></td>
              <td><div align="center"><font color="#0000FF" size="1" face="Arial, Helvetica, sans-serif">Fin 
                  des cours</font></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input name="type" type="radio" value="aucun" <? if ( !isset($modif_type) or (isset($modif_type) and $modif_type=='aucun' )) echo "checked" ?> >
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="faire" <? if ( isset($modif_type) and $modif_type=='faire' ) echo "checked" ?> >
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="reunion" <? if ( isset($modif_type) and $modif_type=='reunion' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="parents_profs" <? if ( isset($modif_type) and $modif_type=='parents_profs' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="rdv" <? if ( isset($modif_type) and $modif_type=='rdv' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="conseil" <? if ( isset($modif_type) and $modif_type=='conseil' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="arret_notes" <? if ( isset($modif_type) and $modif_type=='arret_notes' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="devoir" <? if ( isset($modif_type) and $modif_type=='devoir' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="blanc" <? if ( isset($modif_type) and $modif_type=='blanc' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="examen" <? if ( isset($modif_type) and $modif_type=='examen' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="formation" <? if ( isset($modif_type) and $modif_type=='formation' ) echo "checked" ?>>
                  </font></div></td>
              <td width="7%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="sortie" <? if ( isset($modif_type) and $modif_type=='sortie' ) echo "checked" ?>>
                  </font></div></td>
              <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="debut_cours" <? if ( isset($modif_type) and $modif_type=='debut_cours' ) echo "checked" ?>>
                  </font></div></td>
              <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                  <input type="radio" name="type" value="fin_cours" <? if ( isset($modif_type) and $modif_type=='fin_cours' ) echo "checked" ?>>
                  </font></div></td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </div></td>
    </tr>
    <tr bgcolor="#F4F4F4"> 
      <td width="100"><font face="Arial, Helvetica, sans-serif">Commentaire</font></td>
      <td valign="middle"> 
        <div align="left"> 
          <p><font face="Arial, Helvetica, sans-serif">&nbsp; 
            <textarea name="commentaire" cols="60" wrap="VIRTUAL" > <? if (isset($modif_commentaire)) echo $modif_commentaire ?></textarea>
            </font><font size="1" face="Arial, Helvetica, sans-serif"><br>
            - Tous les commentaires sont affich&eacute;s dans l'agenda de l'espace 
            prof</font><font face="Arial, Helvetica, sans-serif">. <br>
            <font size="1">- Pour consulter les commentaires affich&eacute;s dans 
            l'agenda de la classe, les &eacute;l&egrave;ves doivent se connecter.</font></font></p>
          <table width="100%" border="0" cellspacing="0">
		     <tr>
              <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">Afficher uniquement dans l'agenda du professeur </font><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input name="site" type="radio" value="prof" <? if ( !isset($modif_site) or (isset($modif_site) and $modif_site=='non')) echo "checked" ?> >
                </font></td>
            </tr>
            <tr>
              <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">Afficher 
                dans l'agenda du site </font><font size="1" face="Arial, Helvetica, sans-serif"><img src="image/site.gif" width="24" height="16" align="baseline"> 
                <input name="site" type="radio" value="site" <? if ( isset($modif_site) and $modif_site=='ok') echo "checked" ?> >
                </font></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="300" align="left" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Afficher 
                      dans l'agenda de la classe <img src="image/classe.gif" width="24" height="16" align="baseline"> 
                      <input name="site" type="radio" value="classe" <? if ( isset($modif_site) and $modif_site<>'ok' and $modif_site<>'non') echo "checked" ?>></font>
					</td>
                    <td  valign="bottom">
          						<select name="classe">
								<? if ( isset($modif_site) and $modif_site<>'ok' and $modif_site<>'non') echo "<option value=\"$modif_site\">$modif_site</option>"; ?>
           						 <option>de :</option>
            					<?
								$sql="select  classe  from gc_classe";
								$resultat=mysql_db_query($dbname,$sql,$id_link);
								while($rang=mysql_fetch_array($resultat))
								{
								$classe=$rang[classe];
								echo "<option value=\"$classe\">$classe</option>";
								}
								?>
         						 </select></td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
  <p align="center"> 
  <?
  if (isset($_GET['modifier_commentaire']) and $_GET['modifier_commentaire']=="ok") echo "<input type=\"submit\" name=\"Submit2\" value=\"Modifier\">";
  else echo "<input type=\"submit\" name=\"Submit2\" value=\"Envoyer\">";
  ?>
  </p>
</form>
<?
	  // affichage des commentaires
	  $sql="select  *  from gc_agenda where date>('$jour'-7202) and date<('$jour'+7202) order by id_agenda";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat))
	  {
	  $id_agenda=$rang['id_agenda'];
	  $type=$rang['type'];
	  $site=$rang['site'];
	  $commentaire=style($rang['commentaire']);
	  if (isset($_GET['modifier_commentaire']) and $_GET['modifier_commentaire']=="ok" and isset($_GET['id_agenda']) and $_GET['id_agenda']==$id_agenda) echo "<table><tr bgcolor=\"#F4F4F4\" ><td>";
	  echo "<a href=\"commentaire.php?modifier_commentaire=ok&id_agenda=$id_agenda&jour=$jour\"><img src=\"../../images/config/modifier.gif\" border=\"0\" align=\"absmiddle\" title=\"modifier\" ></a> ";
	  echo " <a href=\"commentaire.php?del_commentaire=ok&id_agenda=$id_agenda&jour=$jour\"><img src=\"../../images/config/pdel.gif\" border=\"0\" align=\"absmiddle\" title=\"supprimer\" ></a><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
       switch ($type)
			{
			case "aucun": echo "$commentaire";  break;
			case "faire": echo "<img src=\"image/afaire.gif\" align=\"absmiddle\">$commentaire";  break;
			case "reunion": echo "<img src=\"image/reunion.gif\" align=\"absmiddle\">$commentaire";  break;
			case "parents_profs": echo "<img src=\"image/parents_profs.gif\" align=\"absmiddle\">$commentaire";  break;
			case "rdv": echo "<img src=\"image/rendez_vous.gif\" align=\"absmiddle\">$commentaire";  break;
			case "conseil": echo "<img src=\"image/conseil.gif\" align=\"absmiddle\">&nbsp;$commentaire";  break;
			case "arret_notes": echo "<img src=\"image/arret_notes.gif\" align=\"absmiddle\">$commentaire";  break;
			case "devoir": echo "<img src=\"image/devoir.gif\" align=\"absmiddle\">$commentaire";  break;
			case "blanc": echo "<img src=\"image/examen_blanc.gif\" align=\"absmiddle\">$commentaire";  break;
			case "examen": echo "<img src=\"image/examen.gif\" align=\"absmiddle\">$commentaire";  break;
			case "formation": echo "<img src=\"image/formation.gif\" align=\"absmiddle\">$commentaire";  break;
			case "sortie": echo "<img src=\"image/sortie.gif\" align=\"absmiddle\">$commentaire";  break;
			case "debut_cours": echo "<img src=\"image/debut_cours.gif\" align=\"absmiddle\">$commentaire";  break;
			case "fin_cours": echo "<img src=\"image/fin_cours.gif\" align=\"absmiddle\">$commentaire";  break;	
			}
			echo "</font>";
			if ($site=='ok') echo "<img src=\"image/site.gif\" align=\"absmiddle\">";
			if ($site<>'non' and $site<>'ok') echo "<img src=\"image/classe.gif\" align=\"absmiddle\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$site</font>";
			if (isset($_GET['modifier_commentaire']) and $_GET['modifier_commentaire']=="ok" and isset($_GET['id_agenda']) and $_GET['id_agenda']==$id_agenda) echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" color=\"#0000FF\">   >> En cours de modification ... </font></table></tr></td>";
			else echo "<br>";
	  }
?>

