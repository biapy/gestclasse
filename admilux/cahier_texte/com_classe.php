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

//la date du jour pour les listes 
$date_du_jour=getdate(time());
$date=$date_du_jour["mday"];
$jour=$date_du_jour["weekday"];
$mois=$date_du_jour["month"];
// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

?>


<table width="90%" align="center" border="0" cellspacing="4" cellpadding="0">
  <tr>
    <td> 
      <form name="commentaire" method="post" action="?page_admi=cahier_texte&classe=<? echo $_GET['classe'] ?>&ajout_commentaire=ok&jour=<? echo $id_com_classe ?>">
		  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  
            <td height="25" valign="top">&nbsp; </td>
			</tr>
			<tr>
			  <td >
				<textarea name="commentaire" cols="70" rows="2" wrap="VIRTUAL" id="commentaire"></textarea>
              <input type="submit" name="Submit" value="Ajouter un commentaire"> </td>
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
              <div align="center"><font color="#FF9900" size="1" face="Arial, Helvetica, sans-serif">Devoir 
                &agrave; venir</font></div></td>
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
            <td width="6%">
<div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Classe 
                enti&egrave;re</font></div></td>
            <td width="6%">
<div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                groupe</font></div></td>
          </tr>
          <tr> 
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input name="type" type="radio" value="aucun" checked>
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="faire">
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="dm">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="devoir_venir">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="attention">
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="ds">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="int">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="note">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="correction">
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="tp">
                </font></div></td>
            <td width="4%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="td">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="activite">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="sous_titre">
                </font></div></td>
            <td width="6%"> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="chapitre">
                </font></div></td>
            <td width="6%">
<div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="classe_entiere">
                </font></div></td>
            <td width="6%">
<div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                <input type="radio" name="type" value="groupe">
                </font></div></td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#F2F2F2"> 
                  <td width="230" bgcolor="#F2F2F2"><font face="Arial, Helvetica, sans-serif">Pour 
                    : </font><font color="#999999" size="1" face="Arial, Helvetica, sans-serif">( 
                    &quot;A faire&quot;, &quot;DM&quot; et &quot;Devoir &agrave; 
                    venir&quot; )</font></td>
                  <td width="200"> 
                    <?
			$plus=0; 
			echo "<select name=\"pour\">";
			for($i=1;$i<=30;$i++)
				{
					$date_francais=date_francais(getdate(time()+$plus));
					echo "<option value=\"$date_francais\" >$date_francais</option>";
					$plus=$plus+86400;
				}
			echo "</select>";
			?>
                  </td>
                  <td><font face="Arial, Helvetica, sans-serif">ou</font> <input name="pour_ou" type="text" id="pour_ou" size="25"> 
                    <font color="#999999" size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
                    </font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td bgcolor="#F2F2F2">
<div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Ces trois 
                types de messages apparaissent directement dans l'agenda au jour 
                ( &quot;pour&quot; ) s&eacute;lectionn&eacute;.</font></div></td>
          </tr>
        </table>
        <p><font size="1" face="Arial, Helvetica, sans-serif"> </font></p>
        </form>
		  
			
      <?
			//affichage des commentaires pour la classe
			$sql="select  *  FROM gc_cahier_texte where jour='$id_com_classe' ORDER BY id_com_classe";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$id_com_classe=$rang['id_com_classe'];	
			$commentaire=style($rang['commentaire']);
			$type=$rang['type'];
			$pour=$rang['pour'];
			echo"<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			echo"<tr><td valign=\"top\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >";
			echo"<a href=\"admilux/cahier_texte/modifier.php?classe=$_GET[classe]&id_com_classe=$id_com_classe\" target=\"blank\" ><img src=\"images/config/modifier.gif\" border=\"0\" align=\"absmiddle\" title=\"modifier\"></a>&nbsp;&nbsp;&nbsp;<a href=\"?page_admi=cahier_texte&classe=$_GET[classe]&del_com=$id_com_classe&jour=$jour1\"><img src=\"images/config/pdel.gif\"  title=\"supprimer\" border=\"0\" align=\"absmiddle\"></a><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >";
			switch ($type)
			{
			case "aucun": echo "&nbsp; &nbsp; &nbsp; $commentaire" ; break;
			case "ds": echo "<img src=\"admilux/cahier_texte/image/ds.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "dm": echo "<img src=\"admilux/cahier_texte/image/dm.gif\" align=\"absmiddle\"> pour $pour : $commentaire" ; break;
			case "correction": echo "<img src=\"admilux/cahier_texte/image/correction.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "int": echo "<img src=\"admilux/cahier_texte/image/int.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "attention": echo "<img src=\"admilux/cahier_texte/image/attention.gif\" align=\"absmiddle\">$commentaire" ; break;
			case "note": echo "<img src=\"admilux/cahier_texte/image/note.gif\" align=\"absmiddle\"> &nbsp;$commentaire" ; break;
			case "faire": echo "<img src=\"admilux/cahier_texte/image/afaire.gif\" align=\"absmiddle\"> pour $pour : $commentaire" ; break;
			case "chapitre": echo "<font size=\"3\" face=\"Arial, Helvetica, sans-serif\" color=\"#FF0000\"> $commentaire</font>" ; break;
			case "sous_titre": echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\" color=\"#006600\"> $commentaire</font>" ; break;
			case "devoir_venir": echo "<img src=\"admilux/cahier_texte/image/devoir_venir.gif\" align=\"absmiddle\">  $pour : $commentaire" ; break;
			case "tp": echo "<img src=\"admilux/cahier_texte/image/tp.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "td": echo "<img src=\"admilux/cahier_texte/image/td.gif\" align=\"absmiddle\">&nbsp;$commentaire" ; break;
			case "activite": echo "<img src=\"admilux/cahier_texte/image/activite.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			case "classe_entiere": echo "<img src=\"admilux/cahier_texte/image/classe_entiere.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			case "groupe": echo "<img src=\"admilux/cahier_texte/image/groupe.gif\" align=\"absmiddle\">&nbsp;$commentaire " ; break;
			}	
			echo"</font></td></tr></table>";
			}
			?>
       </td>
  </tr>
</table>