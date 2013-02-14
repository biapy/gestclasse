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
function compteur($couleurtexte)
{
 if (!isset($_SESSION['compteur_visites']) and !isset($_SESSION['admilogin']))
 {
	$fichier = "cpt.txt";
    $fp = @fopen($fichier, "r");
    if (!$fp)
	 	{
        echo "Impossible d'ouvrir $fichier en lecture";
        exit;
    	}
    $visites = fgets($fp, 8);
    echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" color=$couleurtexte>";
    $visites++;
	echo $visites;
    echo "</font>"; // on affiche $visites, et on incremente $visites.
    fclose($fp);

    $fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero
    if (!$fp) {
        echo "Impossible d'ouvrir $fichier en ecriture";
        exit;
    }
    fputs($fp, $visites);
    fclose($fp);
	$_SESSION['compteur_visites']=$visites;
 }
else
 {
 if (isset($_SESSION['admilogin']))
  {
	if (!isset($_SESSION['compteur_prof']))
	{
	$fichier = "cpt.txt";
    $fp = @fopen($fichier, "r");
    if (!$fp)
	 	{
        echo "Impossible d'ouvrir $fichier en lecture";
        exit;
    	}
    $visites = fgets($fp, 8);
    if (isset($_SESSION['compteur_visites'])) $visites--;
    fclose($fp);

    $fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero
    if (!$fp) {
        echo "Impossible d'ouvrir $fichier en ecriture";
        exit;
    }
    fputs($fp, $visites);
    fclose($fp);
	$_SESSION['compteur_prof']=$visites;
	$_SESSION['compteur_visites']=$visites;
	}
	}	
	echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" color=$couleurtexte>";
    echo $_SESSION['compteur_visites'];
    echo "</font>";
 }

}



function date_francais($date)
{ 

$nb=$date["mday"];
$jour=$date["weekday"];
$mois=$date["month"];

switch ($jour)
{
case "Monday": $jour="lundi" ; break;
case "Tuesday": $jour="mardi" ; break;
case "Wednesday": $jour="mercredi" ; break;
case "Thursday": $jour="jeudi" ; break;
case "Friday": $jour="vendredi" ; break;
case "Saturday": $jour="samedi" ; break;
case "Sunday": $jour="dimanche" ; break;
}
		
switch ($mois)
{
case "January": $mois="janvier";break;
case "February": $mois="février";break;
case "March": $mois="mars";break;
case "April": $mois="avril";break;
case "May": $mois="mai";break;
case "June": $mois="juin";break;
case "July": $mois="juillet";break;
case "August": $mois="août";break;
case "September": $mois="septembre";break;
case "October": $mois="octobre";break;
case "November": $mois="novembre";break;
case "December": $mois="décembre"; break;
}

$datef=$jour." ".$nb." ".$mois;
return $datef;
}

function heure($date)
{ 
$heure=$date["hours"];
$minute=$date["minutes"];
$heure=" à ".$heure." h ".$minute." min";
return $heure;
}


function mediane($nombres){ 
 // $nombres est un tableau de nombres. 
  sort($nombres); 
  $c = count($nombres); 
  if ($c % 2){ // cas impair 
  $mediane = $nombres[($c - 1) / 2]; 
  } else { 
  $mediane = ($nombres[$c/2] + $nombres[$c/2 - 1]) / 2; 
  } 
  return $mediane; 
}


//titre de la page après sélection
if (isset($couleur7)) define("COULEUR7",$couleur7); 
if (isset($couleur8)) define("COULEUR_TEXTE",$couleur8); 
function titre_page ($titre)
{
$couleur=COULEUR7;
$couleur_texte=COULEUR_TEXTE;
if (subStr($couleur,0,2)=="im") echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\"  cellpadding=\"1\" background=\"$couleur\">";
else echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\"  cellpadding=\"1\" bgcolor=\"#$couleur\">";
echo "
  <tr>
    <td ><div align=\"center\"><font color=\"#$couleur_texte\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>- $titre -</strong></font></div></td>
  </tr>
</table>
";
}

//titre de la page impression
function titre_page_impression ($titre)
{
echo "<div align=\"center\"><font color=\"#000000\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><strong>- $titre -</strong></font></div></td>";
}

//titre des divisions 

function titre_division($titre)
{
$couleur=COULEUR7;
$couleur_texte=COULEUR_TEXTE;
if (subStr($couleur,0,2)=="im") echo "<table width=\"200\" border=\"0\" cellspacing=\"1\"  cellpadding=\"1\" background=\"$couleur\">";
else echo "<table width=\"300\" border=\"0\" cellspacing=\"1\"  cellpadding=\"1\" bgcolor=\"#$couleur\">";
echo "
  <tr>
    <td ><div align=\"left\"><font color=\"#$couleur_texte\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"#haut\"><img src=\"images/config/hautdepage.gif\"  border=\"0\" align=\"absmiddle\" ></a> $titre</font></div></td>
  </tr>
</table>
";
}



//titre variable
if (isset($couleur6)) define("COULEUR6",$couleur6); 
function titre_variable ($titre, $lien)
{
$couleur=COULEUR6;
if (subStr($couleur,0,2)=="im") echo "<table width=\"100%\"   border=\"0\" cellspacing=\"1\"  cellpadding=\"1\" background=\"$couleur\" class=\"bordure\">";
else echo "<table width=\"100%\"  border=\"0\" cellspacing=\"1\"  cellpadding=\"1\" bgcolor=\"#$couleur\" class=\"bordure\" >";
echo"
  <tr>
    <td  valign=\"middle\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"$lien\">$titre</a></font></div></td>
  </tr>
</table>
";
}


//sous titre

function sous_titre ($titre, $lien)
{
if ($lien=='selection') echo " <td  width=\"170\" valign=\"middle\" class=\"bordure_sous_titre\" ><div align=\"center\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\">$titre</font></div></td>";
else echo "<td  width=\"170\"  valign=\"middle\" ><div align=\"center\"><font  size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" align=\"absmiddle\"><a href=\"$lien\">$titre</a></font></div></td>";

}

//message
function message ($message)
{
echo"
<table width=\"600\" border=\"0\" cellpadding=\"2\" cellspacing=\"6\"  >
  <tr >
    <td bgcolor=\"#FEF9E2\" class=\"bordure\" ><div align=\"left\"><font color=\"#003333\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><em> <img src=\"images/config/message.gif\" > <br>$message</em></font></div></td>
  </tr>
</table>

";
}

//message
function message2 ($message)
{
// pour commentaire.php
echo"
<table width=\"600\" border=\"0\" cellpadding=\"2\" cellspacing=\"6\"  >
  <tr >
    <td bgcolor=\"#FEF9E2\" class=\"bordure\" ><div align=\"left\"><font color=\"#003333\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><em> <img src=\"../../images/config/message.gif\" > <br>$message</em></font></div></td>
  </tr>
</table>

";
}

//message
function message3 ($message)
{
// pour l'arborescence
echo"
<table width=\"600\" border=\"0\" cellpadding=\"2\" cellspacing=\"6\"  >
  <tr >
    <td bgcolor=\"#FEF9E2\" class=\"bordure\" ><div align=\"left\"><font color=\"#003333\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><em> <img src=\"../../../images/config/message.gif\" > <br>$message</em></font></div></td>
  </tr>
</table>

";
}

//les styles de Gest'classe
function  style($texte)
{

for ($i=1;$i<=6;$i++)
{
$texte=eregi_replace("gctexte,-,$i,-:","<font  size=\"$i\">",$texte);
$texte=eregi_replace("gctexte,-,$i,g:","<font  size=\"$i\" class=\"gras\">",$texte);
$texte=eregi_replace("gctexte,-,$i,i:","<font  size=\"$i\" class=\"italique\">",$texte);
$texte=eregi_replace("gctexte,r,$i,-:","<font color=\"#FF0000\" size=\"$i\">",$texte);
$texte=eregi_replace("gctexte,r,$i,g:","<font color=\"#FF0000\" size=\"$i\" class=\"gras\">",$texte);
$texte=eregi_replace("gctexte,r,$i,i:","<font color=\"#FF0000\" size=\"$i\" class=\"italique\">",$texte);
$texte=eregi_replace("gctexte,v,$i,-:","<font color=\"#00FF00\" size=\"$i\">",$texte);
$texte=eregi_replace("gctexte,v,$i,g:","<font color=\"#00FF00\" size=\"$i\" class=\"gras\">",$texte);
$texte=eregi_replace("gctexte,v,$i,i:","<font color=\"#00FF00\" size=\"$i\" class=\"italique\">",$texte);
$texte=eregi_replace("gctexte,b,$i,-:","<font color=\"#0000FF\" size=\"$i\">",$texte);
$texte=eregi_replace("gctexte,b,$i,g:","<font color=\"#0000FF\" size=\"$i\" class=\"gras\">",$texte);
$texte=eregi_replace("gctexte,b,$i,i:","<font color=\"#0000FF\" size=\"$i\" class=\"italique\">",$texte);
$texte=eregi_replace("gclien,$i:","<font  size=\"$i\"><a href=\"",$texte);
}
$texte=eregi_replace("gctexte,-,-,g:","<font  class=\"gras\">",$texte);
$texte=eregi_replace("gctexte,-,-,i:","<font  class=\"italique\">",$texte);
$texte=eregi_replace("gctexte,r,-,g:","<font  color=\"#FF0000\" class=\"gras\">",$texte);
$texte=eregi_replace("gctexte,v,-,i:","<font  color=\"#00FF00\" class=\"italique\">",$texte);
$texte=eregi_replace("gctexte,b,-,i:","<font  color=\"#0000FF\" class=\"italique\">",$texte);
$texte=eregi_replace("gctexte,r,-,-:","<font  color=\"#FF0000\" >",$texte);
$texte=eregi_replace("gctexte,v,-,-:","<font  color=\"#00FF00\" >",$texte);
$texte=eregi_replace("gctexte,b,-,-:","<font  color=\"#0000FF\" >",$texte);

$texte=eregi_replace("/texte","</font>",$texte);
$texte=eregi_replace("/gc","<br>",$texte);
$texte=eregi_replace("gclien:","<font size=\"1\" ><a href=\"",$texte);
$texte=eregi_replace("gcnom:","\" target=\"_blank\" >",$texte);
$texte=eregi_replace("/lien","</font></a>",$texte);

return $texte;
}
?>

