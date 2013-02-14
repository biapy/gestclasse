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


//formatage des textes
if (isset($_POST['login'])) $_POST['login']=texte($_POST['login']);
if (isset($_POST['passe'])) $_POST['passe']=texte($_POST['passe']);
if (isset($_POST['nom'])) $_POST['nom']=texte($_POST['nom']);
if (isset($_POST['prenom'])) $_POST['prenom']=texte($_POST['prenom']);
if (isset($_POST['naissance'])) $_POST['naissance']=texte($_POST['naissance']);
if (isset($_POST['adresse'])) $_POST['adresse']=texte($_POST['adresse']);
if (isset($_POST['tel'])) $_POST['tel']=texte($_POST['tel']);
if (isset($_POST['prof_pere'])) $_POST['prof_pere']=texte($_POST['prof_pere']);
if (isset($_POST['prof_mere'])) $_POST['prof_mere']=texte($_POST['prof_mere']);
if (isset($_POST['classe_red'])) $_POST['classe_red']=texte($_POST['classe_red']);
if (isset($_POST['moy_avant'])) $_POST['moy_avant']=texte($_POST['moy_avant']);
if (isset($_POST['com_eleve'])) $_POST['com_eleve']=texte($_POST['com_eleve']);
if (isset($_POST['com_prof'])) $_POST['com_prof']=texte($_POST['com_prof']);
if (isset($_POST['appreciation'])) $_POST['appreciation']=texte($_POST['appreciation']);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td colspan="2" > 
      <? 
	//la liste des classes
if (isset($_GET['choix_classe'])) titre_page("Fiches des élèves de   $_GET[choix_classe]");
else titre_page('Fiches des élèves de  ')

	?>
    </td>
  </tr>
  <tr> 
    <td height="50"> <form name="classe">
        <div align="center"> 
          <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
            <option>de :</option>
            <?
			$sql="select  classe  from gc_classe";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$classe=$rang[classe];
			echo "<option value=\"?page_admi=les_fiches&choix_classe=$classe\">$classe</option>";
			}
			?>
          </select>
	  <? if (isset($_GET['choix_classe'])) echo " <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/fiches/impression.php?choix_classe=$_GET[choix_classe]&impression=ok\" target=\"_blank\">  <img src=\"images/config/impression.gif\" align=\"absmiddle\" border=\"0\" ></a> <a href=\"admilux/fiches/mdp.php?choix_classe=$_GET[choix_classe]\" target=\"_blank\"> > voir les mots de passe</a></font>";?>
      </div></form>


  <?


//la liste des élèves 

if (isSet($_GET['choix_classe']))
{
    // menu des éléve
?>
  <tr> 
    <td >
        <div align="center">
		<form name="eleve">
          <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
            <?
			$sql="select  *  FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$id_eleve=$rang[id_eleve];
			$nom=$rang[nom];
			$prenom=$rang[prenom];
			echo "<option value=\"#$id_eleve\">$nom $prenom</option>";
			}
			?>
          </select>
        </form>
      </div>

<?
}
echo "	</td>
  </tr>
</table>";


//modification des informations sur les élèves
if (isset($_GET['id_modification']))
{
include ("commun/connect.php");
$sql="UPDATE gc_eleve SET  login='$_POST[login]' , passe='$_POST[passe]' , nom='$_POST[nom]', prenom='$_POST[prenom]' , naissance='$_POST[naissance]', adresse='$_POST[adresse]', tel='$_POST[tel]', prof_pere='$_POST[prof_pere]', prof_mere='$_POST[prof_mere]', classe_red='$_POST[classe_red]', moy_avant='$_POST[moy_avant]', com_eleve='$_POST[com_eleve]', com_prof='$_POST[com_prof]', appreciation='$_POST[appreciation]' where id_eleve='$_GET[id_modification]'";
mysql_db_query($dbname,$sql,$id_link);
echo"<div align=\"center\"><font color=\"#000000\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">Les modifications ont été faites</font></div>\n";
}

//suppression d'un élève
if (isset($_GET['del']))
{
	  $sql="select  nom,prenom  FROM gc_eleve where id_eleve='$_GET[del]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  $rang=mysql_fetch_array($resultat);
	  $nom_del=$rang['nom'];
	  $prenom_del=$rang['prenom'];
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer l\'élève '.$nom_del.' '.$prenom_del.' et ses notes définitivement de la base de données');
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"?page_admi=les_fiches&choix_classe=$_GET[choix_classe]&del=$_GET[del]&del_confirmation=ok\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"?page_admi=les_fiches&choix_classe=$_GET[choix_classe]\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation']) and $_GET['del_confirmation']='ok') 
	 {
	 include("commun/connect.php");
	 $sql="delete  FROM gc_eleve where id_eleve=$_GET[del]";
	 mysql_db_query($dbname,$sql,$id_link);
	 $sql="delete  FROM gc_notes where id_eleve=$_GET[del]";
	 mysql_db_query($dbname,$sql,$id_link);
	 message('L\'élève '.$nom_del.' '.$prenom_del.' a définitivement été supprimé de la base de données');
	 }
}


	// le formulaire pour chaque élève
if (isset($_GET['choix_classe']))
{
	  $sql="select  *  FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat))
	  {
	    $id_eleve=$rang['id_eleve'];	
		$login=$rang['login'];
		$passe=$rang['passe'];
		$maj_eleve=$rang['maj_eleve'];
		$nom=$rang['nom'];
		$prenom=$rang['prenom'];
		$naissance=$rang['naissance'];
		$adresse=$rang['adresse'];
		$tel=$rang['tel'];
		$prof_pere=$rang['prof_pere'];
		$prof_mere=$rang['prof_mere'];
		$classe_red=$rang['classe_red'];
		$moy_avant=$rang['moy_avant'];
		$com_eleve=$rang['com_eleve'];
		$com_prof=$rang['com_prof'];
		$appreciation=$rang['appreciation'];

echo"
<br>
<a name=\"$id_eleve\" id=\"$id_eleve\"></a> 
<form name=\"classe\" method=\"post\" action=\"?page_admi=les_fiches&id_modification=$id_eleve&choix_classe=$_GET[choix_classe]#$id_eleve\">
  <table width=\"90%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"bordure\">
    <tr> 
      <td width=\"30%\"> <div align=\"center\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"admilux/photo_classe/$id_eleve.jpg\" ></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><br> identifiant dans la bdd :  $id_eleve</font></div></td>
      <td><div align=\"center\"><font > 
          <input type=\"submit\" name=\"Submit\" value=\"Modification\">
          </font><a href=\"#haut\"><img src=\"images/config/hautdepage.gif\" border=\"0\" ></a></div>
		  <a href=\"?page_admi=les_fiches&choix_classe=$_GET[choix_classe]&del=$id_eleve\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> ( supprimer l'élève et les notes de l'élève )</font>
		  </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\"> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Nom 
          : </font></div></td>
      <td bgcolor=\"#F0F0F0\"><font > 
        <input name=\"nom\" type=\"text\"  value=\"$nom\" size=\"80\" >
        </font></td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Prénom 
          :</font></div></td>
      <td><input name=\"prenom\" type=\"text\"  value=\"$prenom\" size=\"80\" > 
      </td>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Login 
          : </font></div></td>
      <td bgcolor=\"#F0F0F0\"> <font > 
        <input name=\"login\" type=\"text\" value=\"$login\" size=\"80\" >
        </font> </td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Mot 
          de passe :</font></div></td>
      <td> <input name=\"passe\" type=\"text\" value=\"$passe\" size=\"80\" > </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Date 
          de naissance :</font></div></td>
      <td bgcolor=\"#F0F0F0\"> <input name=\"naissance\" type=\"text\" id=\"naissance\" value=\"$naissance\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Adresse 
          :</font></div></td>
      <td><input name=\"adresse\" type=\"text\" id=\"adresse\" value=\"$adresse\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">T&eacute;l&eacute;phone et mail 
          des parents :</font></div></td>
      <td bgcolor=\"#F0F0F0\"> <input name=\"tel\" type=\"text\" id=\"tel\" value=\"$tel\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Profession 
          du p&egrave;re :</font></div></td>
      <td><input name=\"prof_pere\" type=\"text\" id=\"prof_pere\" value=\"$prof_pere\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Profession 
          de la m&egrave;re :</font></div></td>
      <td bgcolor=\"#F0F0F0\"> <input name=\"prof_mere\" type=\"text\" id=\"prof_mere\" value=\"$prof_mere\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Classe(s) 
          redoubl&eacute;e(s) :</font></div></td>
      <td><input name=\"classe_red\" type=\"text\" id=\"classe_red\" value=\"$classe_red\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Moyenne 
           de l'an dernier et nom du professeur :</font></div></td>
      <td bgcolor=\"#F0F0F0\"> <input name=\"moy_avant\" type=\"text\" id=\"moy_avant\" value=\"$moy_avant\" size=\"80\" > 
      </td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Un 
          commentaire suppl&eacute;mentaire :</font></div></td>
      <td><textarea name=\"com_eleve\" cols=\"60\" rows=\"6\" wrap=\"VIRTUAL\" id=\"com_eleve\">$com_eleve</textarea> 
      </td>
    </tr>
	<tr> 
      <td bgcolor=\"#F0F0F0\" ><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Appréciation :</font><br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Cette appréciation est uniquement consultable par le professeur</font></td>
      <td bgcolor=\"#F0F0F0\"> <textarea name=\"appreciation\" cols=\"60\" rows=\"6\" wrap=\"VIRTUAL\" id=\"com_prof\">$appreciation</textarea> 
      </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" ><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Commentaire du professeur</font><br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">( Ce commentaire apparait dans la rubrique de l'élève )</font></td>
      <td bgcolor=\"#F0F0F0\"> <textarea name=\"com_prof\" cols=\"60\" rows=\"4\" wrap=\"VIRTUAL\" id=\"com_prof\">$com_prof</textarea> 
      </td>
    </tr>
  </table>
</form>
";
}
}
?>

