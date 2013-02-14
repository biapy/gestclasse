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

titre_page('Vider les tables ... attention !');
message('Attention : cette op&eacute;ration supprime toutes les donn&eacute;es de la table s&eacute;lectionn&eacute;e');

//confirmation pour la suppression d'une table
if (isset($_GET['vider']) and $_GET['vider']=='ok' )
{
	 if (!isset($_GET['del_confirmation'])) 
	 {
	    $table="la(les) table(s) :<br> ";
	  	if ( isset($_POST['agenda'])) $table.="- gc_agenda<br>";
		else $_POST['agenda']="non";
	  	if ( isset($_POST['bloc_notes']))$table.="- gc_bloc_notes<br>";
		else $_POST['bloc_notes']="non";
		if ( isset($_POST['classe'])) $table.="- gc_classe<br>";
		else $_POST['classe']="non";
	  	if ( isset($_POST['com_classe'])) $table.="- gc_cahier_texte<br>";
		else $_POST['com_classe']="non";
		if ( isset($_POST['connexion'])) $table.="- gc_connexion<br>";
		else $_POST['connexion']="non";
		if ( isset($_POST['contenu_auto'])) $table.="- gc_contenu_auto<br>";
		else $_POST['contenu_auto']="non";
		if ( isset($_POST['contenu_page'])) $table.="- gc_contenu_page<br>";
		else $_POST['contenu_page']="non";
		if ( isset($_POST['devoir'])) $table.="- gc_devoir<br>";
		else $_POST['devoir']="non";
		if ( isset($_POST['division_page'])) $table.="- gc_division_page<br>";
		else $_POST['division_page']="non";
		if ( isset($_POST['eleve'])) $table.="- gc_eleve<br>";
		else $_POST['eleve']="non";
		if ( isset($_POST['lien'])) $table.="- gc_lien<br>";
		else $_POST['lien']="non";
		if ( isset($_POST['modification'])) $table.="- gc_modification<br>";
		else $_POST['modification']="non";
		if ( isset($_POST['notes'])) $table.="- gc_notes<br>";
		else $_POST['notes']="non";
		if ( isset($_POST['page'])) $table.="- gc_pages<br>";
		else $_POST['page']="non";
		if ( isset($_POST['vacances'])) $table.="- gc_vacances<br>";
		else $_POST['vacances']="non";
		message('Voulez-vous vraiment vider '.$table);
	  	echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"admi.php?page_admi=vider&del_confirmation=ok&agenda=$_POST[agenda]&bloc_notes=$_POST[bloc_notes]&classe=$_POST[classe]&com_classe=$_POST[com_classe]&config=$_POST[config]&connexion=$_POST[connexion]&contenu_auto=$_POST[contenu_auto]&contenu_page=$_POST[contenu_page]&devoir=$_POST[devoir]&division_page=$_POST[division_page]&eleve=$_POST[eleve]&lien=$_POST[lien]&modification=$_POST[modification]&notes=$_POST[notes]&page=$_POST[page]&vacances=$_POST[vacances]\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"admi.php?page_admi=vider\">NON</a></font></p>
		";
		
		}
}

?>
<form name="form1" method="post" action="admi.php?page_admi=vider&vider=ok">
  <br>
  <table width="620" border="0" align="center" cellpadding="0" cellspacing="0" class="bordure">
    <tr>
      <td><p align="center">&nbsp;</p>
        <p align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>S&eacute;lectionner 
          la ( ou les ) table(s)<br>
          </strong></font></p>
        <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="200"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="20"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="agenda" value="ok">
                      </font></div></td>
                  <td width="150"><font size="2" face="Arial, Helvetica, sans-serif">gc_agenda 
                    </font></td>
                </tr>
                <tr> 
                  <td width="20"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="bloc_notes" value="ok">
                      </font></div></td>
                  <td width="150"><font size="2" face="Arial, Helvetica, sans-serif">gc_bloc_notes 
                    </font></td>
                </tr>
                <tr> 
                  <td width="20"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="classe" value="ok">
                      </font></div></td>
                  <td width="150"><font size="2" face="Arial, Helvetica, sans-serif">gc_classe 
                    </font></td>
                </tr>
                <tr> 
                  <td width="20"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="com_classe" value="ok">
                      </font></div></td>
                  <td width="150"><font size="2" face="Arial, Helvetica, sans-serif">gc_cahier_texte
                    </font></td>
                </tr>
                <tr> 
                  <td width="20"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input name="connexion" type="checkbox" id="connexion" value="ok">
                      </font></div></td>
                  <td width="150"><font size="2" face="Arial, Helvetica, sans-serif">gc_connexion 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="contenu_auto" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_contenu_auto 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="contenu_page" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_contenu_page 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="devoir" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_devoir 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="division_page" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_division_page 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="eleve" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_eleve</font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="lien" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_lien 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="modification" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_modification 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="notes" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_notes 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="page" value="ok">
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_page 
                    </font></td>
                </tr>
                <tr> 
                  <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
                      <input type="checkbox" name="vacances" value="ok" >
                      </font></div></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif">gc_vacances 
                    </font></td>
                </tr>
              </table></td>
            <td width="250" valign="top"> 
              <?
if (isset($_GET['del_confirmation']) and $_GET['del_confirmation']=='ok') 
{
	 	  
if ( isset($_GET['agenda']) and $_GET['agenda']=="ok" )
{
$sql="DELETE from gc_agenda";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_agenda a &eacute;t&eacute; vid&eacute;e</font><br>";
}

if ( isset($_GET['bloc_notes']) and $_GET['bloc_notes']=="ok")
{ 
$sql="DELETE from gc_bloc_notes ";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_bloc_notes  a &eacute;t&eacute; vid&eacute;e</font><br>";
}

if ( isset($_GET['classe']) and $_GET['classe']=="ok")
{ 
$sql="DELETE from gc_classe ";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_classe  a &eacute;t&eacute; vid&eacute;e</font><br>";
}

if ( isset($_GET['com_classe']) and $_GET['com_classe']=="ok")
{ 
$sql="DELETE FROM gc_cahier_texte";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_cahier_texte a &eacute;t&eacute; vid&eacute;e</font><br>";
}


if ( isset($_GET['connexion']) and $_GET['connexion']=="ok")
{ 
$sql="DELETE FROM gc_connexion";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_connexion a &eacute;t&eacute; vid&eacute;e</font><br>";
}

if ( isset($_GET['contenu_auto']) and $_GET['contenu_auto']=="ok")
{ 
$sql="DELETE FROM gc_contenu_auto";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_contenu_auto a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['contenu_page']) and $_GET['contenu_page']=="ok")
{ 
$sql="DELETE FROM gc_contenu_page";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_contenu_page a &eacute;t&eacute; vid&eacute;e</font><br>";
}

if ( isset($_GET['devoir']) and $_GET['devoir']=="ok")
{ 
$sql="DELETE FROM gc_devoir";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_devoir a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['division_page']) and $_GET['division_page']=="ok")
{ 
$sql="DELETE FROM gc_division_page";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_division_page a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['eleve']) and $_GET['eleve']=="ok")
{ 
$sql="DELETE FROM gc_eleve";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_eleve a &eacute;t&eacute; vid&eacute;e</font><br>";
}

if ( isset($_GET['lien']) and $_GET['lien']=="ok")
{ 
$sql="DELETE FROM gc_lien";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_lien a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['modification']) and $_GET['modification']=="ok")
{ 
$sql="DELETE from gc_modification";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_modification a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['notes']) and $_GET['notes']=="ok")
{ 
$sql="DELETE FROM gc_notes";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_notes a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['page']) and $_GET['page']=="ok")
{ 
$sql="DELETE FROM gc_page";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_page a &eacute;t&eacute; vid&eacute;e</font><br>";
}
if ( isset($_GET['vacances']) and $_GET['vacances']=="ok")
{ 
$sql="DELETE from gc_vacances";
mysql_db_query($dbname,$sql,$id_link);
echo"<font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/sous_titre.gif\" > 
  La table gc_vacances a &eacute;t&eacute; vid&eacute;e</font><br>";
}

}
?>
            </td>
          </tr>
        </table>
        <p align="center"> 
          <input type="submit" name="Submit2" value="Vider">
        </p>
        <p align="center"><br>
        </p>
        </td>
    </tr>
  </table>
  <p align="center">&nbsp;</p>
  </form>


<?
message('<strong>Présentation des tables :</strong><br>
- gc_agenda : contient les messages de l\'agenda<br>
- gc_bloc_notes : contient les messages du bloc_notes présents dans les cahiers de texte<br>
- gc_classe : contient les noms des classes<br>
- gc_cahier_texte : contient les commentaires des cahiers de texte<br>
- gc_config : contient les informations sur la configuration générale du site<br>
- gc_connexion : contient les identifiants des derniers élèves connectés<br>
- gc_contenu_auto : contient les informations liées aux contenus automatiques des pages<br>
- gc_contenu_page : contient le contenu html ( haut et bas ) des pages <br>
- gc_devoir : contient les informations liées aux devoirs<br>
- gc_division_page : contient les divisions des pages et le contenu html de ces divisions<br>
- gc_eleve : contient les informations sur les élèves et les moyennes des élèves<br>
- gc_lien : contient les informations de la rubrique liens<br>
- gc_modification : contient les identifiants des derniers élèves ayant modifié leur fiche<br>
- gc_notes : contient les notes des devoirs<br>
- gc_pages : contient la structure des rubriques<br>
- gc_restriction : contient les informations sur les restrictions<br>
- gc_vacances : contient les vacances de la rubrique agenda');
message('Les tables gc_config et gc_restrictions ne doivent pas être vidées');
?> 
