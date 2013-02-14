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

//validation
if(isset($_GET['valide_accueil']) and $_GET['valide_accueil']=="ok")
{ 
$_POST['mail']=texte($_POST['mail']);
$_POST['contenu']=texte($_POST['contenu']);
$_POST['gauche']=texte($_POST['gauche']);
$_POST['droite']=texte($_POST['droite']);
$_POST['bas_page']=texte($_POST['bas_page']);
$sql="UPDATE gc_config SET  maj='$_POST[maj]' , mail='$_POST[mail]' , contenu='$_POST[contenu]', gauche='$_POST[gauche]' , droite='$_POST[droite]', bas_page='$_POST[bas_page]'";
mysql_db_query($dbname,$sql,$id_link);
}

include('commun/config.php');

// affichage du formulaire de modifications
echo"

<form name=\"form1\" method=\"post\" action=\"admi.php?page_admi=config&sous_titre=accueil&valide_accueil=ok\">
<table width=\"100%\" border=\"0\" bgcolor=\"#$couleur1\">
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&gt; Mise 
      &agrave; jour</font></td>
    <td><input name=\"maj\" type=\"text\" value=\"$maj\" size=\"50\"></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&gt; Mail</font></td>
    <td><input name=\"mail\" type=\"text\" value=\"$mail\" size=\"50\"></td>
  </tr>
  <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&gt; Contenu HTML de la page d'accueil : centre</font></td>
    <td><textarea name=\"contenu\" cols=\"80\" rows=\"10\" wrap=\"VIRTUAL\">$contenu</textarea></td>
  </tr>
    <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&gt; Contenu HTML de la page d'accueil : gauche</font></td>
    <td><textarea name=\"gauche\" cols=\"80\" rows=\"10\" wrap=\"VIRTUAL\">$gauche</textarea></td>
  </tr>
    <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&gt; Contenu HTML de la page d'accueil : droite</font></td>
    <td><textarea name=\"droite\" cols=\"80\" rows=\"10\" wrap=\"VIRTUAL\">$droite</textarea></td>
  </tr>
    <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&gt; Contenu HTML du bas des pages</font></td>
    <td><textarea name=\"bas_page\" cols=\"80\" rows=\"4\" wrap=\"VIRTUAL\">$bas_page</textarea></td>
  </tr>
   <tr> 
    <td width=\"30%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;</font></td>
    <td><input type=\"submit\" name=\"Submit\" value=\"Envoyer\"></td>
  </tr>  

</table>
</form>
";
//fin : affichage du formulaire de modifications


//affichage du contenu HTML de la page d'accueil
$contenu=style($contenu);
$droite=style($droite);
$gauche=style($gauche);
$bas_page=style($bas_page);

echo"<hr>
<div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>Visualisation
  du contenu HTML de la page d'accueil </strong></font></div>
<table width=\"100%\" height=\"600\" border=\"0\">
        <tr>
          <td width=\"115\" valign=\"top\" class=\"borduredroite\">
			<table width=\"100%\" border=\"0\">
              <tr>
                <td><div align=\"center\"><a href=\"mailto:$mail\"><img src=\"images/config/contact.gif\" border=\"0\" ></a></div></td>
              </tr>
              <tr>
                <td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$gauche</font></td>
              </tr>
              <tr>
                <td height=\"40\">&nbsp;</td>
              </tr>
            </table>
          </td>
          <td valign=\"top\"> 
            <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$contenu</font>
          </td>
          <td width=\"115\" valign=\"top\" class=\"borduregauche\">
			<table width=\"100%\" border=\"0\">
              <tr> 
                <td><div align=\"center\"></div></td>
              </tr>
              <tr> 
                <td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$droite</font></td>
              </tr>
              <tr> 
                <td height=\"40\">";

	

	
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

if ($type=="td") 
{ 
if ($compteur_td==1) echo "<br><img src=\"images/config/td.gif\" border=\"0\" align=\"absmiddle\"><br>";
echo "
<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$url_auto\" target=_blank ><img src=\"images/config/point.gif\" border=\"0\" align=\"absmiddle\" title=\"$extrait_de - $contenu_auto\">$nom_auto</font></a></font><br>
";
$compteur_td++;
}

if ($type=="tp") 
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

// fin :affichage du contenu auto sélectionné dans la bordure droite
						
echo" </tr></table> ";
//fin : affichage du contenu HTML de la page d'accueil

?>