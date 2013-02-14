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


session_start();
include("commun/connect.php");
include("commun/test.php");
include("session/mot_de_passe.php");
//protection de la page

if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']) or $_SESSION['admilogin']<>LOGIN_PROF  or $_SESSION['admipasse']<>PASSE_PROF )
{
echo "<div align=\"left\"><img src=\"images/config/logogestclasse.gif\"></div><br><div align=\"center\"><font size=\"6\" face=\"Arial, Helvetica, sans-serif\">Acc&egrave;s interdit ou session expirée</font></div><br>";
				  // formulaire de connexion
				if (!isset($_SESSION['admilogin']) and $_SESSION['auth']<>2)
					{
	
						echo "
						<table width=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
						<form name=\"form1\" method=\"post\" action=\"session/login.php\">
						<strong><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Login</font></strong> 
						<input name=\"login\" type=\"password\" size=\"10\" >
						<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>Mot de passe</strong></font>
						<input name=\"passe\" type=\"password\" size=\"10\" >
						<input type=\"submit\" name=\"Submit\" value=\"ok\">
						</table>
						</form>
						";

					}	

exit;
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gest'classe - espace professeur</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<link href="commun/style.css" rel="stylesheet" type="text/css">
</head>
<?

//design
if(isset($_GET['design']) and $_GET['design']=="ok")
{ 
$sql="UPDATE gc_config SET  fond_haut_page='$_POST[fond_haut_page]' , couleur1='$_POST[couleur1]' , couleur2='$_POST[couleur2]', fond='$_POST[fond]' , couleur3='$_POST[couleur3]', couleur4='$_POST[couleur4]', couleur5='$_POST[couleur5]', couleur6='$_POST[couleur6]', couleur7='$_POST[couleur7]', couleur8='$_POST[couleur8]'";
mysql_db_query($dbname,$sql,$id_link);
}
 if(isset($_GET['sous_titre']) and $_GET['sous_titre']=="lire") include("admilux/configuration/valider_lire.php");
 include("commun/config.php");
 include("commun/fonction.php"); 
 include("commun/texte.php"); 
 include("admilux/carnet/graphique.php"); 



// formatage des textes

if (isset($_POST['titre_modif'])) $_POST['titre_modif']=texte($_POST['titre_modif']);
if (isset($_POST['titre'])) $_POST['titre']=texte($_POST['titre']);
if (isset($_POST['sous_titre'])) $_POST['sous_titre']=texte($_POST['sous_titre']);

?>
<a name="haut"></a> 

<?

echo "<body text=\"#$couleur3\"  bgproperties=\"fixed\" link=\"#$couleur4\" vlink=\"#$couleur4\" alink=\"#$couleur4\" leftmargin=\"0\"  topmargin=\"0\"";
if (subStr($fond,0,2)=="im") echo "background=\"$fond\">";
else echo "bgcolor=\"#$fond\">";

//mise à jour
if (isset($_GET['maj']) and $_GET['maj']=="ok")
{
$aujour=getdate(time());
$mise_a_jour=date_francais($aujour)." ".$aujour['year'];
$sql="UPDATE gc_config SET  maj='$mise_a_jour'";
mysql_db_query($dbname,$sql,$id_link);
$maj=$mise_a_jour;
}


//Modification du titre ou du sous titre d'une page 
if (isset($_GET['modif_titre']) and $_GET['modif_titre']=="ok")
{
$sql="UPDATE gc_page SET  titre='$_POST[titre_modif]',ordre='$_POST[ordre]',classe='$_POST[classe]' where id_page='$_GET[id_page]'";
mysql_db_query($dbname,$sql,$id_link);
}

//ajout d'un titre
if (isset($_GET['ajout_titre']) and $_GET['ajout_titre']=="ok")
{
$sql="INSERT INTO gc_page ( titre, ordre, classe ) VALUES ('$_POST[titre]','$_POST[ordre_titre]','$_POST[classe]')";
mysql_db_query($dbname,$sql,$id_link);
};


//ajout d'un sous titre
if ( isset($_GET['ajout_sous_titre']) and $_GET['ajout_sous_titre']=="ok")
{
$sql="INSERT INTO gc_page ( titre, sous_titre_de, ordre, classe ) VALUES ('$_POST[sous_titre]','$_GET[id_page]','$_POST[ordre]','$_POST[classe]')";
mysql_db_query($dbname,$sql,$id_link);
};


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="7" bgcolor="#<? echo $couleur2; ?>"></td>
    <td height="7" bgcolor="#<? echo $couleur2; ?>"></td>
    <td width="7" bgcolor="#<? echo $couleur2; ?>"></td>
  </tr>
  <tr>
    <td width="7" bgcolor="#<? echo $couleur2; ?>"></td>
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="600" valign="top"> 
            <?
		  if (subStr($fond_haut_page,0,2)=="im") echo "<table width=\"100%\" border=\"0\" background=\"$fond_haut_page\" cellspacing=\"0\"  cellpadding=\"0\">";
		  else echo "<table width=\"100%\" border=\"0\" bgcolor=\"#$fond_haut_page\" cellspacing=\"0\"  cellpadding=\"0\">";
		  ?>
        <tr> 
                <td><table width="100%" border="0" cellspacing="0"  cellpadding="0">
                    <tr > 
                      
                <td width="200" valign="middle"> 
                  <div align="left"><img src="images/config/logogestclasse.gif" width="110" height="25" ></div></td>
                      
                <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td><a href="admi.php?page_admi=config"><img src="images/config/config.gif"  border="0" align="absmiddle"></a></td>
                      <td><a href="admi.php?page_admi=plan"><img src="images/config/rubriques.gif"  border="0" align="absmiddle"></a></td>
                      <td><a href="admi.php?page_admi=lien"><img src="images/config/liens.gif"  border="0" align="absmiddle"></a></td>
                      <td><a href="admi.php?page_admi=agenda"><img src="images/config/agenda.gif"   border="0" align="absmiddle"></a></td>
                      <td><a href="admi.php?page_admi=notes_tableau"><img src="images/config/carnet.gif"  border="0" align="absmiddle"></a></td>
                      <td><a href="admi.php?page_admi=trombi"><img src="images/config/trombi.gif"  border="0" align="absmiddle"></a></td>
                      <td><a href="admi.php?page_admi=les_fiches"><img src="images/config/fiches.gif"  border="0" align="absmiddle"></a></td>
                    </tr>
                  </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td><table width="100%" border="0">
                    <tr> 
                      
                <td width="200"> <div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><a href="admi.php?maj=ok">Actualis&eacute; 
                    le </a> : <? echo "<br>$maj"; ?></font></div></td>
	           		 
                <td valign="top"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif">&gt; 
                  <font color="#FF9900"><a href="admi.php?page_admi=admiajout_classe">Ajouter 
                  une classe</a></font> &gt; <font color="#<? echo $couleur3 ?>"><a href="admi.php?page_admi=admiajout">Ajouter 
                  un &eacute;l&egrave;ve</a>&nbsp;&gt; <a href="admi.php?page_admi=adminouveau_dev">Ajouter 
                  un devoir</a><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><br>
                  </font></font></font><font  size="1" face="Arial, Helvetica, sans-serif">&gt;&nbsp;<a href="admi.php?page_admi=modification">Les 
                  derni&egrave;res fiches modifi&eacute;es par les &eacute;l&egrave;ves</a> 
                  &gt; &nbsp;<a href="admi.php?page_admi=connexion">Les derni&egrave;res 
                  connexions</a></font><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><br>
                  <font color="#FF6600">&gt;</font> <a href="admi.php?page_admi=sauvegarde&action=connect"><font color="#FF6600">Sauvegarder 
                  les tables</font></a>&nbsp;<font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF6600">&gt;</font> 
                  <a href="admi.php?page_admi=restaurer"><font color="#FF6600">Ex&eacute;cuter 
                  des requ&ecirc;tes sur la base</font></a></font></font></font> 
                  <font color="#FF6600">&gt;</font> <a href="admi.php?page_admi=vider"><font color="#FF6600">Vider 
                  les tables</font></a> <font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#9900CC"> 
                  </font></font></font></font></font></font></font></font></font></font></font></font></font><br>
                  <font color="#9900CC">&gt;</font> <a href="commun/style_gestclasse.php" target="_blank"><font color="#9900CC"> 
                  Les styles Gest'classe</font></a> <font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"> 
                  </font><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#9900CC">&gt;</font> 
                  <a href="FCKeditor/_samples/html/index.htm" target="_blank"><font color="#9900CC"> 
                  &eacute;diteur HTML</font></a></font></font></font></font></font></font><font color="#9900CC"> 
                  &gt;</font></font></font></font> <a href="admilux/page/arborescence/arb.php" target="_blank"><font color="#9900CC">G&eacute;rer 
                  le dossier document </font></a> <font color="#9900CC">&gt; </font></font><a href="admilux/trombi/arborescence/arb.php" target="_blank"><font color="#9900CC" size="1" face="Arial, Helvetica, sans-serif">G&eacute;rer 
                  le dossier photo_classe</font></a> </font><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#FF9900"></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></td>
                      <td width="100" ><div><font size="1" face="Arial, Helvetica, sans-serif">&gt; 
                        <a href="index.php?page=accueil">Retour au site</a></font></div>
                        <div><font size="1" face="Arial, Helvetica, sans-serif Helvetica, sans-serif" align="center">&gt; 
                        <a href="session/logout.php">Déconnexion</a></font></font> </div></td>
                    </tr>
                  </table>
				  </td>
              </tr>
              <tr> 
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
              <tr> 
                      
                <td width="200" bgcolor="#<? echo $couleur2 ?>"> <div align="left"><font color="<? echo "#$couleur8"; ?>" size="2" face="Arial, Helvetica, sans-serif"> 
                    - Espace prof -</font></div></td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr > 
                      <td width="150"  > 
                        <div align="center"><img src="images/config/cahier_texte.gif" align="absmiddle" ></div></td>
                            
                      <td > 
                        <?
			$sql="select  classe  from gc_classe";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$classe=$rang['classe'];
			echo "<font color=\"$couleur3\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">| <a href=\"?page_admi=cahier_texte&classe=$classe\">$classe</a> 
  </font>";
			}

			?>
                        <font color="#<? echo $couleur3 ?>" size="1" face="Arial, Helvetica, sans-serif"><font color="#<? echo $couleur3 ?>" size="1">|&nbsp;</font><font color="#<? echo $couleur3 ?>">&nbsp;</font></font> 
                      </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> <div align="center"> </div>
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr valign="top">
			 <?	 //affichage des rubriques
          
			$sql="select  COUNT(id_page)  FROM gc_page where sous_titre_de='0' ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$nb_page=$rang['0'];
			if ($nb_page<>0) $largeur_colonne=100/$nb_page;

			$sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='0' order by ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			echo "<td width=\"$largeur_colonne%\" >";
			$titre=$rang['titre'];
			$id_page=$rang['id_page'];
			$classe=$rang['classe'];
			if ($classe<>"aucune restriction") titre_variable ("<font size=\"1\">$classe : $titre</font>","admi.php?page_admi=page&id_page=$id_page");
			else titre_variable ("<font size=\"1\">$titre</font>","admi.php?page_admi=page&id_page=$id_page");
			echo "</td>";
			}
			
			?>
                    </tr>
                  </table></td>
              </tr>
            </table>

                  <? include ("admilux/admi_lien.php") ;?>
			</td></tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table></td>
    <td width="7" bgcolor="#<? echo $couleur2; ?>">&nbsp;</td>
  </tr>
  <tr>
    <td width="7" bgcolor="#<? echo $couleur2; ?>">&nbsp;</td>
    <td bgcolor="#<? echo $couleur2; ?>"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
		 
        <td><font size="1" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>">Gest'classe 
          &copy; 2003-2008 cr&eacute;&eacute; par <a href="mailto:luxpierre@hotmail.com"><font size="1" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>"> 
          Lux Pierre</font></a> - <a href="http://gestclasse.free.fr" target="_blank"><font size="1" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>">gestclasse.free.fr</font></a></font></td>
          <td > <div align="center"><a href="#haut"><img src="images/config/hautdepage.gif"  border="0" align="absmiddle" ></a>&nbsp;&nbsp;<a href="#haut"><font size="2" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>">Haut 
            de page</font></a></div>
		</td>
        </tr>
      </table></td>
    <td width="7" bgcolor="#<? echo $couleur2; ?>">&nbsp;</td>
  </tr></table>
</body>
</html>
