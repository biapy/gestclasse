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

include("commun/connect.php");
session_start(); 

//protection eleve
if (isset($_SESSION['login']) and isset($_SESSION['passe']))
{
$verif_id_eleve=0;
$sql="select  id_eleve FROM gc_eleve where login='$_SESSION[login]' and passe='$_SESSION[passe]'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$verif_id_eleve=$rang['id_eleve'];
if ($verif_id_eleve<>$_SESSION['id_eleve']) 
{
session_unset(); // on efface toutes les variables de session
session_destroy(); // on detruit la session en cours.
}
}


setcookie("test","yes",time()+86400);

//déclaration des variables pour définir un nb d'essais limité pour les mots de passe et pour le compteur
session_register("auth");
session_register("compteur_visites");
session_register("compteur_prof");


 ?>
<html>
<head>
<title>Gest'classe</title>
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

 include("commun/test.php");
 include("commun/config.php");
 include("commun/fonction.php"); 
 include("commun/texte.php"); 
 include("admilux/carnet/graphique.php"); 



// les restrictions
for($i=1;$i<=8;$i++)
{
$sql="select  etat  FROM gc_restriction where id_restriction='$i'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$etat[$i]=$rang['etat'];
}
$etat_plan=$etat[1];
$etat_lien=$etat[2];
$etat_agenda=$etat[3];
$etat_cahier=$etat[4];
$etat_mail=$etat[5];
$etat_fiche=$etat[6];
$etat_notes=$etat[7];
$etat_trombi=$etat[8];


//fin: les restrictions 

$contenu=style($contenu);
$droite=style($droite);
$gauche=style($gauche);
$bas_page=style($bas_page);

echo "<a name=\"haut\"></a>";
echo "<body text=\"#$couleur3\"  bgproperties=\"fixed\" link=\"#$couleur4\" vlink=\"#$couleur4\" alink=\"#$couleur4\" leftmargin=\"0\"  topmargin=\"0\"";
if (subStr($fond,0,2)=="im") echo "background=\"$fond\">";
else echo "bgcolor=\"#$fond\">";

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
      <?
		  if (subStr($fond_haut_page,0,2)=="im") echo "<table width=\"100%\" border=\"0\" background=\"$fond_haut_page\" cellspacing=\"0\"  cellpadding=\"0\">";
		  else echo "<table width=\"100%\" border=\"0\" bgcolor=\"#$fond_haut_page\" cellspacing=\"0\"  cellpadding=\"0\">";
		  ?>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0"  cellpadding="0">
        <tr> 
          <td width="200" valign="top"> <div align="left"><img src="images/config/logo.gif" ></div></td>
          <td><table width="100%" height="15" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td> <div align="left"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="17%"><a href="index.php?page=accueil"><img src="images/config/accueil.gif"  border="0" align="absmiddle"></a></td>
						<td width="8%">&nbsp;</td>
                        <td width="19%"> <? if ($etat_plan=="on") echo "<a href=\"index.php?page=plan\"><img src=\"images/config/plan.gif\"  border=\"0\" align=\"absmiddle\"></a>"?></td>
                        <td width="8%">&nbsp;</td>
                        <td width="16%"> <? if ($etat_lien=="on") echo "<a href=\"index.php?page=lien\"><img src=\"images/config/liens.gif\"  border=\"0\" align=\"absmiddle\"></a>"?></td>
                        <td width="4%">&nbsp;</td>
                        <td width="28%"> <? if ($etat_agenda=="on") echo "<a href=\"index.php?page=agenda\"><img src=\"images/config/agenda.gif\"  title=\"Connectez-vous pour consulter les dates importantes de votre classe\"  border=\"0\" align=\"absmiddle\"></a>"?></td>
                      </tr>
                    </table>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                <td width="7%"><div align="left"><? if ($etat_mail=="on") echo "<a href=\"mailto:$mail\"><img src=\"images/config/mail.gif\" border=\"0\">"; ?></a></div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0">
        <tr> 
          <td> <div align="left">
              <table width="100%" border="0">
                <tr valign="top"> 
                  <td><font size="1" face="Arial, Helvetica, sans-serif"> 
                    <?  if ($etat_cahier=="commun") 
						{
						$sql="select  classe  from gc_classe";
						$resultat=mysql_db_query($dbname,$sql,$id_link);
						$cahier="non";
						while($rang=mysql_fetch_array($resultat))
						{
						$classe1=$rang['classe'];
						if (isset($classe1) and $cahier<>"ok")
						{
						echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><font color=\"#$couleur5\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/cahier_texte.gif\" align=\"absmiddle\" > </font> <font color=\"#$couleur3\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">|</font> ";
						$cahier="ok";
						}
						echo "<font color=\"#$couleur3\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"index.php?page=cahier_texte&classe=$classe1\" >$classe1</a> | 
			  			</font>";
						}
						}
						else if ($etat_cahier=="eleve" and isset($_SESSION['id_eleve']))  echo "<a href=\"index.php?page=cahier_texte&classe=$_SESSION[classe_active]\"><img src=\"images/config/cahier_texte.gif\"  border=\"0\" align=\"absmiddle\" ></a>";
						else echo "<img src=\"images/config/cahier_texte.gif\" title=\"Connectez-vous pour consulter le cahier de texte de votre classe\" align=\"middle\" ><br> <font color=\"#$couleur3\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"> Connectez-vous pour consulter le cahier de texte de votre classe</font>";
						?>
                    </font></td>
                  <td width="330"> 
                    <?
				  // formulaire de connexion
				  include("session/mot_de_passe.php");
				  
				  if ((!isset($_SESSION['id_eleve']) and !isset($_SESSION['admilogin'])  and $_SESSION['auth']<>2 ) or ( !isset($_SESSION['id_eleve']) and isset($_SESSION['admilogin']) and $_SESSION['admilogin']<>LOGIN_PROF ))
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
				  ?>
                  </td>
                </tr>
              </table>
              <font size="1" face="Arial, Helvetica, sans-serif"> </font></div>
          </td>
          <td width="100" > 
            <?
				  //déconnexion ...
				  
					if (isset($_SESSION['id_eleve']) and ( !isset($_SESSION['admilogin']) or (isset($_SESSION['admilogin']) and $_SESSION['admilogin']<>LOGIN_PROF ))) echo "<div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> <a href=\"session/logout.php\">Déconnexion</font></a></div>";
					if (isset($_SESSION['admilogin']) and isset($_SESSION['admipasse']) and $_SESSION['admilogin']==LOGIN_PROF  and $_SESSION['admipasse']==PASSE_PROF ) 
					{
					echo "<div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> <a href=\"session/logout.php\">Déconnexion</font></a></div>";
					echo "<div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">> <a href=\"admi.php\">Espace prof</font></a></div>";
					}
				  ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="300"> 
            <?
				  if (isset($_SESSION['id_eleve']) and ( !isset($_SESSION['admilogin']) or (isset($_SESSION['admilogin']) and $_SESSION['admilogin']<>LOGIN_PROF ))) include("admilux/page/site/eleve/nom_prenom.php");
			?> 
          </td>
          <td valign="top"> 
            <?
				  // titre de la rubrique eleve
				  if (isset($_SESSION['id_eleve'])) include("admilux/page/site/eleve/titre.php");
				 		  ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="600" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> <div align="center"> </div>
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr> 
             <?
			 //affichage des rubriques
			if (isset($_SESSION['classe_active'])) ($sql="select  COUNT(id_page)  FROM gc_page where sous_titre_de='0' and (classe='$_SESSION[classe_active]' or classe='aucune restriction') ");
			else if (isset($_SESSION['admilogin'])) ($sql="select  COUNT(id_page)  FROM gc_page where sous_titre_de='0'");
			else $sql="select  COUNT(id_page)  FROM gc_page where sous_titre_de='0' and classe='aucune restriction'";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$rang=mysql_fetch_array($resultat);
			$nb_page=$rang['0'];
			if ($nb_page<>0) $largeur_colonne=100/$nb_page;
			if (isset($_SESSION['classe_active'])) ($sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='0' and (classe='$_SESSION[classe_active]' or classe='aucune restriction') order by ordre");
			else if (isset($_SESSION['admilogin'])) ($sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='0' order by ordre");
			else $sql="select id_page,titre,classe  FROM gc_page where sous_titre_de='0' and classe='aucune restriction' order by ordre";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			echo "<td width=\"$largeur_colonne%\" valign=\"top\">";
			$titre=$rang['titre'];
			$id_page=$rang['id_page'];
			$classe=$rang['classe'];
			if (isset($_SESSION['admilogin']) and $classe<>"aucune restriction") titre_variable ("$classe : $titre","index.php?page=page&id_page=$id_page");
			else titre_variable ("$titre","index.php?page=page&id_page=$id_page");
			echo "</td>";
			}
			?>
                    </tr>
                  </table>
				  </td>
              </tr>
            </table>   

              
      
  <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
<?
//affichage de la bordure gauche		
 if ( !isset($_GET['page']) or $_GET['page']=='accueil'   )
 {
  echo"
          <td width=\"115\" valign=\"top\" class=\"borduredroite\">
			<table width=\"100%\" border=\"0\">
			 <tr>
                <td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Actualisé le : <br>$maj</font></div></td>
              </tr>
              <tr>
                <td><div align=\"center\">";
  if ($etat_mail=="on") echo "<a href=\"mailto:$mail\"><img src=\"images/config/contact.gif\" border=\"0\">"; 
  echo"</div></td></tr>";
		// alerte des messages pour les classes
		$sql="select count(type) from gc_bloc_notes where type<>'' ";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nb_message=$rang[0];
		
		if ($nb_message>0)
		{
		echo "<tr><td><div align=\"center\"><img src=\"images/config/messages.gif\" title=\"Les messages sont accessibles après connexion dans votre espace personnel.\"></div>
		";

		$sql="select type,UNIX_TIMESTAMP(date) from gc_bloc_notes where type<>'' order by id_bloc";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		while($rang=mysql_fetch_array($resultat))
		{
		$type=style($rang[0]);
		$date=$rang[1];
		echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> - $type ";
		echo date_francais(getdate($date));
		echo "</font><br>";
	    } 
		echo "<br></td></tr>";
		}		  
			  
  echo"	    
              <tr>
                <td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$gauche</font></td>
              </tr>
              <tr>
                <td height=\"40\">&nbsp;</td>
              </tr>
            </table>
          </td>
		";  
}

// fin : afichage de la bordure gauche
?>
          <td valign="top">
		   <p>
		<?   
        include ("commun/lien.php") ;
		?>
            </p>
            <p>&nbsp; </p></td>

<?
//affichage de la bordure droite		
 if ( !isSet($_GET['page']) or $_GET['page']=="accueil"  )
 {
  echo"
          <td width=\"115\" valign=\"top\" class=\"borduregauche\">
			<table width=\"100%\" border=\"0\">
              <tr> 
                <td><div align=\"center\"><font color=\"#CCCCCC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">Nombre de visites</font><br>";
				compteur("#CCCCCC");
			echo "</div></td>
              </tr>
              <tr> 
                <td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$droite</font></td>
              </tr>
              <tr> 
                <td height=\"40\">
		";
	
// affichage du contenu auto sélectionné dans la bordure droite
$sql1="select *  FROM gc_contenu_auto where accueil='1' order by type" ;
$resultat1=mysql_db_query($dbname,$sql1,$id_link);
$compteur_cours=1;
$compteur_td=1;
$compteur_tp=1;
$compteur_activite=1;
$compteur_animation=1;
$compteur_exercice=1;
$compteur_revision=1;
$compteur_devoir=1;
$compteur_dm=1;
$compteur_i=1;
$compteur_document=1;
$compteur_ligne=1;
$compteur_info=1;

while($rang1=mysql_fetch_array($resultat1))
{
$id_auto=$rang1['id_auto'];
$nom_auto=$rang1['nom'];
$url_auto=$rang1['url'];
$contenu_auto=$rang1['contenu'];
$ordre_auto=$rang1['ordre'];
$type=$rang1['type'];
$id_division=$rang1['id_division'];
$sans_division=$rang1['sans_division'];

if ($sans_division==0) $sql2="select gc_page.titre,gc_page.sous_titre_de  FROM gc_page,gc_division_page where (gc_division_page.id_division=$id_division and gc_division_page.id_page=gc_page.id_page ) " ;
else $sql2="select titre,sous_titre_de  FROM gc_page where id_page=$id_division" ;
$resultat2=mysql_db_query($dbname,$sql2,$id_link);
$rang2=mysql_fetch_array($resultat2);
$extrait_de=$rang2['0'];
$sous_titre_de=$rang2['1'];

if ($sans_division==0) 
{
$sql4="select nom_division  FROM gc_division_page where id_division=$id_division" ;
$resultat4=mysql_db_query($dbname,$sql4,$id_link);
$rang4=mysql_fetch_array($resultat4);
$nom_division=$rang4['0'];
}


if ($sous_titre_de<>0) 
{
$sql3="select titre FROM gc_page where id_page=$sous_titre_de " ;
$resultat3=mysql_db_query($dbname,$sql3,$id_link);
$rang3=mysql_fetch_array($resultat3);
$extrait_de=$rang3['0']." - ".$extrait_de;
if ($sans_division==0) $extrait_de=$extrait_de." - ".$nom_division;
}

if ($type=="en ligne") 
{ 
if ($compteur_ligne==1) echo "<br><img src=\"images/config/en_ligne.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_ligne++;
}

if ($type=="cours") 
{ 
if ($compteur_cours==1) echo "<br><img src=\"images/config/cours.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_cours++;
}

if ($type=="TD") 
{ 
if ($compteur_td==1) echo "<br><img src=\"images/config/td.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_td++;
}

if ($type=="TP") 
{ 
if ($compteur_tp==1) echo "<br><img src=\"images/config/tp.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_tp++;
}

if ($type=="activité") 
{ 
if ($compteur_activite==1) echo "<br><img src=\"images/config/activite.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_activite++;
}

if ($type=="devoir") 
{ 
if ($compteur_devoir==1) echo "<br><img src=\"images/config/devoir.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$extrait_de - $nom_auto</font></a></font><br>
";
$compteur_devoir++;
}

if ($type=="devoir maison") 
{ 
if ($compteur_dm==1) echo "<br><img src=\"images/config/dm.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_dm++;
}

if ($type=="interrogation") 
{ 
if ($compteur_i==1) echo "<br><img src=\"images/config/i.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_i++;
}

if ($type=="animation") 
{ 
if ($compteur_animation==1) echo "<br><img src=\"images/config/animation.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_animation++;
}



if ($type=="révision") 
{ 
if ($compteur_revision==1) echo "<br><img src=\"images/config/revision.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_revision++;
}

if ($type=="exercice") 
{ 
if ($compteur_exercice==1) echo "<br><img src=\"images/config/exercice.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_exercice++;
}

if ($type=="document") 
{ 
if ($compteur_document==1) echo "<br><img src=\"images/config/document.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_document++;
}

if ($type=="salle info") 
{ 
if ($compteur_info==1) echo "<br><img src=\"images/config/info.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_info++;
}

if ($type=="aucun") 
{ 
echo "<br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>";
}   
}
echo"</td> </tr></table></td>";
}


// fin :affichage du contenu auto sélectionné dans la bordure droite
?>
				

  			</tr>
      </table> 
	  
	  
	  </td>
        </tr>
        <tr> 
          
    <td><div align="left"> 
        <table width="90%" border="0">
          <tr>
            <td width="110"><a href="http://gestclasse.free.fr" target="_blank"><img src="images/config/logogestclasse.gif"   width="110" height="25" border="0"  ></a></td>
            <td>
              <div align="center"><font color="#999999" size="1" face="Arial, Helvetica, sans-serif"><? echo $bas_page ?></font></div></td>
          </tr>
        </table>
      </div></td>
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
          &copy; 2003-2008 créé par <a href="mailto:luxpierre@hotmail.com"><font size="1" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>"> 
          Lux Pierre</font></a> - <a href="http://gestclasse.free.fr" target="_blank"><font size="1" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>">gestclasse.free.fr</font></a></font></td>
          <td > <div align="center"><a href="#haut"><img src="images/config/hautdepage.gif"  border="0" align="absmiddle" ></a>&nbsp;&nbsp;<a href="#haut"><font size="2" face="Arial, Helvetica, sans-serif" color="<? echo "#$couleur8"; ?>">Haut 
            de page</font></a></div>
		</td>
        </tr>
      </table></td>
    <td width="7" bgcolor="#<? echo $couleur2; ?>">&nbsp;</td>
  </tr>
</table>
</body>
</html>
