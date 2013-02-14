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

titre_page("Cahier de texte de $_GET[classe]");
// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


//formatage des textes
if (isset($_POST['commentaire'])) $_POST['commentaire']=texte($_POST['commentaire']);

//ajout d'un jour dans le cahier de texte
if ( isset($_GET['ajout_jour']) and $_GET['ajout_jour']=='ok')
{
	$jour=date_francais(getdate($_POST['index_jour']));
	$sql="select  jour  FROM gc_cahier_texte where jour='$jour' and classe='$_GET[classe]' and type='jour' ";
	$resultat=mysql_db_query($dbname,$sql,$id_link);
	$rang=mysql_fetch_array($resultat);
	If (isset ($rang['jour'])) message('Ce jour a été déjà été sélectionné : sortez le éventuellement des archives pour ajouter des commentaires');
	else
	{
	$sql="INSERT INTO gc_cahier_texte ( id_jour, classe , commentaire , type, pour , jour , archive) VALUES ('$_POST[index_jour])','$_GET[classe]','jour','jour','jour','$jour','0')";
	mysql_db_query($dbname,$sql,$id_link);
	}
}

//suppression d'un commentaire sur la classe
if (isset($_GET['del_com']))
{
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  if (isset($_GET['com']) and $_GET['com']=='jour')  
	  {
	  message('Voulez-vous vraiment supprimer le jour -'.$_GET['jour'].'- et tous les commentaires de ce jour définitivement de la base de données');
	  echo "<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"?page_admi=cahier_texte&classe=$_GET[classe]&del_com=$_GET[del_com]&jour=$_GET[jour]&del_confirmation=ok&com=jour\">OUI</a></font>";
      }
	  else 
	  {
	  message('Voulez-vous vraiment supprimer ce commentaire  de -'.$_GET['jour'].'- définitivement de la base de données');
	  echo"<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"?page_admi=cahier_texte&classe=$_GET[classe]&del_com=$_GET[del_com]&jour=$_GET[jour]&del_confirmation=ok\">OUI</a></font>";
	  }
      echo "<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"?page_admi=cahier_texte&classe=$_GET[classe]\">NON</a></font></p>";
	  }
	 if (isset($_GET['del_confirmation']) and $_GET['del_confirmation']='ok') 
	 {
	 if (isset($_GET['com']) and $_GET['com']=='jour')
	 {
	 $sql="delete  FROM gc_cahier_texte where id_com_classe=$_GET[del_com] or jour=$_GET[del_com]";
	 mysql_db_query($dbname,$sql,$id_link);
	 message('Le jour -'.$_GET['jour'].'- et tous les commentaires de ce jour ont définitivement été supprimés de la base de données');
	 }
	 else
	 {
	 $sql="delete  FROM gc_cahier_texte where id_com_classe=$_GET[del_com]";
	 mysql_db_query($dbname,$sql,$id_link);
	 message('Le commentaire de -'.$_GET['jour'].'- a définitivement été supprimé de la base de données');
	 }
	 }
}



//ajout d'un commentaire
if (isset($_GET['ajout_commentaire']) and $_GET['ajout_commentaire']=="ok")
{
	if (isset($_POST['pour_ou']) and $_POST['pour_ou']<>"") $_POST['pour']=$_POST['pour_ou'];
	$sql="INSERT INTO gc_cahier_texte ( classe , commentaire , type, pour , jour , archive) VALUES ('$_GET[classe]','$_POST[commentaire]','$_POST[type]', '$_POST[pour]','$_GET[jour]','0')";
	mysql_db_query($dbname,$sql,$id_link);
}

//archiver ou rétablir un jour
if (isset($_GET['archive']))
{
$sql="UPDATE gc_cahier_texte SET archive='$_GET[archive]' where id_com_classe='$_GET[id_com_classe]'";
mysql_db_query($dbname,$sql,$id_link);
}


	//index d'aujourd'hui
	$aujour=getdate(time());
	$j=$aujour["mday"];
	$m=$aujour["mon"];
	$a=$aujour["year"];
	$index_jour=mktime(0,0,0,$m,$j,$a)+50000;//Pour éviter les pb de décallage horaire
?>
<form name="form1" method="post" action="?page_admi=cahier_texte&classe=<? echo $_GET['classe'] ?>&ajout_jour=ok">
  <table width="700" align="center" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td> 
            <?
			echo "<select name=\"index_jour\">";
			$ce_jour=$index_jour;
			$index_jour=$index_jour+15*86400;
			for($i=1;$i<=75;$i++)
				{
					$date_francais=date_francais(getdate($index_jour));
					if ($ce_jour==$index_jour) echo "<option value=\"$index_jour\" selected >$date_francais</option>";
					else echo "<option value=\"$index_jour\" >$date_francais</option>";
					$index_jour=$index_jour-86400;
				}
			echo "</select>";
			?>
        <input type="submit" name="Submit2" value="Choix du jour">
        <font size="2" face="Arial, Helvetica, sans-serif"> <img src="images/config/lien.gif"> 
        <a href="?page_admi=archive&classe=<? echo $_GET['classe'] ?>">Voir les 
        archives</a> <img src="images/config/lien.gif"> <a href="admilux/cahier_texte/bloc_notes.php?classe=<? echo $_GET['classe'] ?>" target="_blank">Commentaires, messages ...</a><br>
		</td>
    </tr>
  </table>
</form>

<a href="commun/style_gestclasse.php" target="_blank"><font color="#999999" size="2" face="Arial, Helvetica, sans-serif"><br>
</font></a> 
<? 
//fin : ajout d'un jour




//affichage des jours et des formulaires pour ajouter un commentaire sur la classe 
$sql1="select  *  FROM gc_cahier_texte where (classe='$_GET[classe]' and type='jour' and archive='0') ORDER BY id_jour DESC";
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
while($rang1=mysql_fetch_array($resultat1))
{
$id_com_classe=$rang1['id_com_classe'];	
$jour1=$rang1['jour'];
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"200\" >";
titre_division($jour1);
echo "</td><td width=\"200\" ><div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\" ><img src=\"images/config/lien.gif\"> <a href=\"?page_admi=cahier_texte&classe=$_GET[classe]&del_com=$id_com_classe&jour=$jour1&com=jour\"> Supprimer <img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a></font></div></td>";
echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\" ><img src=\"images/config/lien.gif\"> <a href=\"?page_admi=cahier_texte&classe=$_GET[classe]&archive=1&id_com_classe=$id_com_classe\">Archiver </a></font></td></tr></table>";
include('com_classe.php');
}

?>
