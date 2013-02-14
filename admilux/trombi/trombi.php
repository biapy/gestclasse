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


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td colspan="2" > 
      <? 
	//la liste des classes
if (isset($_GET['choix_classe'])) titre_page("Trombinoscope de  $_GET[choix_classe]");
else titre_page('Trombinoscope de ')
	
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
			echo "<option value=\"?page_admi=trombi&choix_classe=$classe\">$classe</option>";
			}
			?>
          </select>
      <? if (isset($_GET['choix_classe'])) echo " <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/trombi/impression.php?choix_classe=$_GET[choix_classe]&impression=ok\" target=\"_blank\">  <img src=\"images/config/impression.gif\" align=\"absmiddle\" border=\"0\" ></a> <a href=\"admilux/fiches/mdp.php?choix_classe=$_GET[choix_classe]\" target=\"_blank\"> > voir les mots de passe</a></font>";?>
	  </div></form></td>
  </tr>
</table>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr>
<?
if (isset($_GET['choix_classe']) )
{

//les photos
			$sql="select id_eleve, nom , prenom FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$compteur=0;
			while($rang=mysql_fetch_array($resultat))
			{
			    $id_eleve=$rang['id_eleve'];
				$nom_eleve=$rang['nom'];
				$prenom_eleve=$rang['prenom'];
				$compteur++;
				if ($compteur%5==1) {echo "</tr><tr>";}
				echo "<td width=\"20%\">
					  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					    <tr>
      					  <div align=\"center\"><a href=\"admilux/fiches/fiche_eleve.php?id_eleve=$id_eleve\" target=\"_blank\"><img src=\"admilux/photo_classe/$id_eleve.jpg\" border=\"0\"></a></div>
  					    </tr>
  					   <tr>
   						  <td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom_eleve <br>$prenom_eleve</font></div></td>
  					   </tr>
					</table>
					</td>";
			
			}
}
?>
</tr></table>
<? 
message ('Cliquez sur la photo pour voir la fiche de l\'&eacute;l&egrave;ve');
message ('Déposez les photos dans le dossier - admilux/photo_classe - <br>Format de photo : identifiant.jpg ( ex : 3.jpg )</font></div>');
?>
