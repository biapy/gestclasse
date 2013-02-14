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
include ("../../commun/connect.php");
include("../../commun/texte.php");
include("../../commun/fonction.php");

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

//formatage des textes
if (isset($_POST['commentaire'])) $_POST['commentaire']=texte($_POST['commentaire']);

?>

<p><img src="../../images/config/logogestclasse.gif" width="110" height="25" align="absmiddle"> 
  <a href="../../commun/style_gestclasse.php" target="_blank"><font color="#999999" size="2" face="Arial, Helvetica, sans-serif">Les 
  styles de Gest'classe</font></a></p>

<?
$id_com_classe=$_GET["id_com_classe"];

//fonction selection type
function selection($selection,$type)
{ 
if ($type==$selection)  echo "checked";
}


//modification d'un commentaire
if (isset($_GET['modif_commentaire']) and $_GET['modif_commentaire']=="ok")
{
	if (isset($_POST['pour_ou']) and $_POST['pour_ou']<>"") $_POST['pour']=$_POST['pour_ou'];
	$sql="UPDATE gc_cahier_texte SET  commentaire='$_POST[commentaire]' , type='$_POST[type]' , pour='$_POST[pour]' where id_com_classe='$id_com_classe'";
	mysql_db_query($dbname,$sql,$id_link);
}



$sql="select  *  FROM gc_cahier_texte where id_com_classe='$id_com_classe'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);	
$commentaire=style($rang['commentaire']);
$commentaire_form=$rang['commentaire'];
$type=$rang['type'];
$pour=$rang['pour'];
$jour=$rang['jour'];

$sql="select  id_jour,jour  FROM gc_cahier_texte where id_com_classe='$jour'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$date_jour=$rang['jour'];
$jour=$rang['id_jour'];

echo "<div align=\"center\"><font size=\"3\" face=\"Arial, Helvetica, sans-serif\" >$_GET[classe] - $date_jour - Modification du commentaire :</font></div>";



?>

<table width="90%" align="center" border="0" cellspacing="4" cellpadding="0">
  <tr>
    <td> 
	      <?
			//affichage des commentaires pour la classe

			echo"<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			echo"<tr><td valign=\"top\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >";
			switch ($type)
			{
			case "aucun": echo "&nbsp; &nbsp; &nbsp; $commentaire" ; break;
			case "ds": echo "<img src=\"image/ds.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "dm": echo "<img src=\"image/dm.gif\" align=\"absmiddle\"> pour $pour : $commentaire" ; break;
			case "correction": echo "<img src=\"image/correction.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "int": echo "<img src=\"image/int.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "attention": echo "<img src=\"image/attention.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "note": echo "<img src=\"image/note.gif\" align=\"absmiddle\"> &nbsp;$commentaire" ; break;
			case "faire": echo "<img src=\"image/afaire.gif\" align=\"absmiddle\"> pour $pour : $commentaire" ; break;
			case "chapitre": echo "<font size=\"3\" face=\"Arial, Helvetica, sans-serif\" color=\"#FF0000\"> $commentaire</font>" ; break;
			case "sous_titre": echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\" color=\"#006600\"> $commentaire</font>" ; break;
			case "devoir_venir": echo "<img src=\"image/devoir_venir.gif\" align=\"absmiddle\">  $pour : $commentaire" ; break;
			case "tp": echo "<img src=\"image/tp.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "td": echo "<img src=\"image/td.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "activite": echo "<img src=\"image/activite.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			case "classe_entiere": echo "<img src=\"image/classe_entiere.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			case "groupe": echo "<img src=\"image/groupe.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			}	
			echo"</font></td></tr></table>";
			?>
			
      <form name="commentaire" method="post" action="modifier.php?classe=<? echo $_GET['classe'] ?>&modif_commentaire=ok&id_com_classe=<? echo $id_com_classe ?>">
		  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  
            <td height="25" valign="top">&nbsp; </td>
			</tr>
			<tr>
			  <td >
				<textarea name="commentaire" cols="70" rows="2" wrap="VIRTUAL" id="commentaire"><? echo $commentaire_form ?> </textarea>
              <input type="submit" name="Submit" value="Modifier le commentaire"> </td>
			</tr>
		  </table>
		  
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Aucun 
                </font></div></td>
            <td width="6%" bgcolor="#F2F2F2"> 
              <div align="center"><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif">A 
                faire </font></div></td>
            <td width="4%" bgcolor="#F2F2F2"> 
              <div align="center"><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif">DM</font></div></td>
            <td width="6%" bgcolor="#F2F2F2"> 
              <div align="center"><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif">A 
                venir</font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif">Attention 
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font color="#0000CC" size="1" face="Arial, Helvetica, sans-serif">DS</font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif"> 
                </font><font color="#0000CC" size="1" face="Arial, Helvetica, sans-serif">Interrogation</font><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif"> 
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#0000CC" size="1" face="Arial, Helvetica, sans-serif">Notes 
                en ligne</font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#0000CC" size="1" face="Arial, Helvetica, sans-serif">Correction</font></div></td>
            <td width="4%"> 
              <div align="center"><font color="#339933" size="1" face="Arial, Helvetica, sans-serif">TP</font></div></td>
            <td width="4%"> 
              <div align="center"><font color="#339933" size="1" face="Arial, Helvetica, sans-serif">TD</font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#339933" size="1" face="Arial, Helvetica, sans-serif">Activit&eacute;</font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#339933" size="1" face="Arial, Helvetica, sans-serif">Sous-titre 
                de chapitre</font></div></td>
            <td width="6%"> 
              <div align="center"><font color="#0000CC" size="1" face="Arial, Helvetica, sans-serif"></font><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">Nouveau 
                chapitre</font></div></td>
            <td width="6%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Classe 
                enti&egrave;re</font></div></td>
            <td width="6%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                groupe</font></div></td>
          </tr>
          <tr>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input name="type" type="radio" value="aucun" <? selection('aucun',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="faire" <? selection('faire',$type) ?>>
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="dm" <? selection('dm',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="devoir_venir" <? selection('devoir_venir',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="attention" <? selection('attention',$type) ?>>
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="ds" <? selection('ds',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="int" <? selection('int',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="note" <? selection('note',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="correction" <? selection('correction',$type) ?>>
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="tp" <? selection('tp',$type) ?>>
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="td" <? selection('td',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="activite" <? selection('activite',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="sous_titre" <? selection('sous_titre',$type) ?>>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="chapitre" <? selection('chapitre',$type) ?>>
                </font></div></td>
            <td width="6%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="classe_entiere" <? selection('classe_entiere',$type) ?>>
                </font></div></td>
            <td width="6%"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="groupe" <? selection('groupe',$type) ?>>
                </font></div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#F2F2F2"> 
            <td width="200"><font face="Arial, Helvetica, sans-serif">Pour : </font><font color="#999999" size="1" face="Arial, Helvetica, sans-serif">( 
              &quot;A faire&quot;, &quot;DM&quot; et &quot;A venir&quot; )</font></td>
            <td width="200"> 
              <?
			$plus=0; 
			echo "<select name=\"pour\">";
			if ($type=='faire' or $type=='devoir_venir' or $type=='dm') echo "<option value=\"$pour\" >$pour</option><option value=\"$pour\" ></option>";
			for($i=1;$i<=30;$i++)
				{
					$date_francais=date_francais(getdate($jour+$plus));
					echo "<option value=\"$date_francais\" >$date_francais</option>";
					$plus=$plus+86400;
				}
			echo "</select>";
			?>
            </td>
			<td><font face="Arial, Helvetica, sans-serif">ou</font> 
              <input name="pour_ou" type="text" id="pour_ou" size="25">
              <font color="#999999" size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
          </tr>
        </table>
        <p><font size="1" face="Arial, Helvetica, sans-serif"> </font></p>
      </form>
		  
			

       </td>
  </tr>
</table>