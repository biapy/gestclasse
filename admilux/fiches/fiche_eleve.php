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

// protection 
session_start();
$id_eleve=$_GET['id_eleve'];

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}
include("../../commun/texte.php");
include("../../commun/fonction.php");

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




include ("../../commun/connect.php");
echo"
<html>
<head>
<title>fiche élève</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link rel=\"stylesheet\" href=\"../commun/style.css\" type=\"text/css\">
</head>
<body>
";
//modification des informations sur les élèves
if (isset($_GET['modif']) and $_GET['modif']=="ok")
{
$sql="UPDATE gc_eleve SET  login='$_POST[login]' , passe='$_POST[passe]' , nom='$_POST[nom]', prenom='$_POST[prenom]' , naissance='$_POST[naissance]', adresse='$_POST[adresse]', tel='$_POST[tel]', prof_pere='$_POST[prof_pere]', prof_mere='$_POST[prof_mere]', classe_red='$_POST[classe_red]', moy_avant='$_POST[moy_avant]', com_eleve='$_POST[com_eleve]', com_prof='$_POST[com_prof]', appreciation='$_POST[appreciation]' where id_eleve='$_GET[id_eleve]'";
mysql_db_query($dbname,$sql,$id_link);
echo"<div align=\"center\"><font color=\"#000000\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">Les modifications ont été faites</font></div>\n";
}


//la fiche de l'élève

	  $sql="select  *  FROM gc_eleve where id_eleve='$_GET[id_eleve]'";
	  $resultat=mysql_db_query($dbname,$sql,$id_link);
	  while($rang=mysql_fetch_array($resultat)){
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
		if ($rang['trim1']==99) $trim1="";
		else $trim1=$rang['trim1'];
		if ($rang['trim2']==99) $trim2="";
		else $trim2=$rang['trim2'];
		if ($rang['trim3']==99) $trim3="";
		else $trim3=$rang['trim3'];
		if ($rang['trim4']==99) $trim4="";
		else $trim4=$rang['trim4'];

if (!isset($_GET['impression']))
echo"
<br>

<form name=\"classe\" method=\"post\" action=\"fiche_eleve.php?id_eleve=$id_eleve&modif=ok\">
  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"bordure\">
    <tr> 
      <td width=\"30%\"> <div align=\"center\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../photo_classe/$id_eleve.jpg\" ></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><br> identifiant dans la bdd :  $id_eleve</font></div></td>
      <td><div align=\"center\"><font > 
          <input type=\"submit\" name=\"Submit\" value=\"Modification\"><a href=\"fiche_eleve.php?id_eleve=$id_eleve&impression=ok\"><img src=\"../../images/config/impression.gif\" align=\"absmiddle\" border=\"0\"></a>
          </font></div>
		
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
    </tr>
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
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"> 
          Commentaire suppl&eacute;mentaire :</font><br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">De l'élève</font></div></td>
      <td><textarea name=\"com_eleve\" cols=\"60\" rows=\"6\" wrap=\"VIRTUAL\" id=\"com_eleve\">$com_eleve</textarea> 
      </td>
    </tr>
	<tr> 
      <td bgcolor=\"#F0F0F0\" ><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Appréciation :</font><br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Cette appréciation est uniquement consultable par le professeur</font></td>
      <td bgcolor=\"#F0F0F0\"> <textarea name=\"appreciation\" cols=\"60\" rows=\"10\" wrap=\"VIRTUAL\" id=\"com_prof\">$appreciation</textarea> 
      </td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" ><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Commentaire du professeur :</font><br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Ce commentaire apparait dans la rubrique de l'élève </font></td>
      <td bgcolor=\"#F0F0F0\"> <textarea name=\"com_prof\" cols=\"60\" rows=\"10\" wrap=\"VIRTUAL\" id=\"com_prof\">$com_prof</textarea> 
      </td>
    </tr>

  </table>
</form>
";
else
echo"
<br>

  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"bordure\">
    <tr> 
      <td width=\"30%\"> <div align=\"center\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"../photo_classe/$id_eleve.jpg\" ></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><br> identifiant dans la bdd :  $id_eleve</font></div></td>
	<td><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">$nom $prenom</font></td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Login 
          : </font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $login</font></td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Mot 
          de passe :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $passe</font></td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Date 
          de naissance :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $naissance</font></td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Adresse 
          :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $adresse</font></td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">T&eacute;l&eacute;phone et mail 
          des parents :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $tel</font></td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Profession 
          du p&egrave;re :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $prof_pere</font></td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Profession 
          de la m&egrave;re :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $prof_mere</font></td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Classe(s) 
          redoubl&eacute;e(s) :</font></div></td>
	  <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $classe_red</font></td>
    </tr>
    <tr> 
      <td bgcolor=\"#F0F0F0\" > <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">Moyenne 
           de l'an dernier et nom du professeur :</font></div></td>
	 <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $moy_avant</font></td>
    </tr>
    <tr> 
      <td> <div align=\"left\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"> 
          Commentaire suppl&eacute;mentaire :</font><br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">De l'élève</font></div></td>
      <td><font  size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $com_eleve</font></td>
    </tr>
  </table>
";
}

//les notes

				echo 
				"
				<a name=\"$id_eleve\"></a>
				<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"3\" cellpadding=\"0\" class=\"borduregrise\" bgcolor=\"#FFFFFF\">
				";
				for ($t=1 ; $t<=3 ; $t++)
				{  
				  echo "
       			  <tr >
				  <td><table><tr>
				  <td width=\"50\" bgcolor=\"#EBEBEB\"><font face=\"Arial, Helvetica, sans-serif\" size=\"2\" color=\"#000000\">trim $t : </font></td>";
				$sql1="select gc_notes.note, gc_devoir.nom, gc_notes.com_note FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim$t' and gc_devoir.coef<>'0' ) ";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				while($rang1=mysql_fetch_array($resultat1))
				{
				$note=$rang1['0'];
				if ($note==99) $note="<font color=\"#3399FF\">ABS</font>";
				if ($note==98) $note="<font color=\"#3399FF\">NN</font>";
			    if ($note<10) $note="<font color=\"#ff0000\">$note</font>";
				$nom_devoir=$rang1['1'];
				$com_note=$rang1['2'];
				echo"<td> <font face=\"Arial, Helvetica, sans-serif\" size=\"1\"><strong>&nbsp; $nom_devoir : </strong></font><font color=\"#0000CC\" face=\"Arial, Helvetica, sans-serif\" size=\"1\"> $note  </font></td>";
				}
				echo"</td></td></table></tr>";
				$sql2="select gc_devoir.nom, gc_notes.com_note FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim$t' ) ";
				$resultat2=mysql_db_query($dbname,$sql2,$id_link);
				while($rang2=mysql_fetch_array($resultat2))
				{
				$nom_devoir=$rang2['0'];
				$com_note=$rang2['1'];
				if ($com_note<>'') echo "<tr><td><font face=\"Arial, Helvetica, sans-serif\" size=\"1\" ><font face=\"Arial, Helvetica, sans-serif\" color=\"#0000CC\">$nom_devoir : </font>$com_note</font></td></tr>";
				}
				
				}
				
	if ($trim1<10) $trim1="<font color=\"#ff0000\">$trim1</font>";
	if ($trim2<10) $trim2="<font color=\"#ff0000\">$trim2</font>";
	if ($trim3<10) $trim3="<font color=\"#ff0000\">$trim3</font>";
	if ($trim4<10) $trim4="<font color=\"#ff0000\">$trim4</font>";
	$appreciation1=style($appreciation);
	$com_prof1=style($com_prof);
			
				echo"
				<tr><td>
				<table width=\"100%\" border=\"0\">
				  <tr bgcolor=\"#EBEBEB\"> 
					<td width=\"20%\" ><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Moyennes 
					  </font></td>
					<td width=\"20%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">trim 1 : 
					  <font color=\"#0000CC\">$trim1</font></font></td>
					<td width=\"20%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">trim 2 : 
					  <font color=\"#0000CC\">$trim2</font></font></td>
					<td width=\"20%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">trim 3 : 
					  <font color=\"#0000CC\">$trim3</font></font></td>
					<td width=\"20%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">g&eacute;n&eacute;rale 
					  : <font color=\"#0000CC\">$trim4</font></font></td>
				  </tr>
				</table>
				</td></tr>
				<tr><td><font face=\"Arial, Helvetica, sans-serif\" size=\"1\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#0000CC\" size=\"2\">Appreciation :<br></font> $appreciation1</font></td></tr>
				<tr><td><font face=\"Arial, Helvetica, sans-serif\" size=\"1\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#0000CC\" size=\"2\">Commentaire <font size=\"1\" > ( apparaît dans la rubrique de l'élève )</font> :<br></font> $com_prof1</font></td></tr>
				<br></table>
				";

			

?>
</body>
</html>
