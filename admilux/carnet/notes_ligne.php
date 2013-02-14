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
	if (!isset($_GET['impression']))
	{
	if (isset($_GET['choix_classe'])) titre_page("Carnet de notes de  $_GET[choix_classe]");
	else titre_page('Carnet de notes de ');
	}
	else
	titre_page_impression ("Carnet de notes de  $_GET[choix_classe]");
	
	?>
    </td>
  </tr>
  <tr> 
  <?  
    	if (!isset($_GET['impression'])) $hauteur_tableau=50;
		else $hauteur_tableau=0;
		echo "<td height=\"$hauteur_tableau\">";
	    include('choix_classe.php');
 ?>
	</td>
  </tr>
<?
if (isset($_GET['choix_classe'])  and !isset($_GET['impression']))
echo "<tr><td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]\"> Tableau de notes</a>  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=devoir&choix_classe=$_GET[choix_classe]\">
     	 Statistiques des devoirs</a> <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=classe&choix_classe=$_GET[choix_classe]\"> Statistiques de la classe</a> <img src=\"images/config/lien.gif\" > Notes en ligne - appréciations  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=admicarnet&choix_classe=$_GET[choix_classe]\">  Carnet de notes complet</a></font><div></td></tr>";  
?>
</table>
<br>
<?
//la liste des élèves 
if (isset($_GET['choix_classe']) and !isset($_GET['impression']))
	{
    // menu des éléve

        echo "<div align=\"center\" ><form name=\"eleve\">
          			<select name=\"menu1\" onChange=\"MM_jumpMenu('parent',this,0)\">";

			$sql="select  *  FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$id_eleve=$rang[id_eleve];
			$nom=$rang[nom];
			$prenom=$rang[prenom];
			echo "<option value=\"#$id_eleve\">$nom $prenom</option>";
			}
			
        echo "</select></form></div>";
		 }


//fin :la liste des élèves 

		
if (isset($_GET['choix_classe']) )
{

//le carnet de notes
			$sql="select id_eleve, nom , prenom, com_prof , trim1, trim2, trim3, trim4, appreciation FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			    $id_eleve=$rang['id_eleve'];
				$nom_eleve=$rang['nom'];
				$prenom_eleve=$rang['prenom'];
				$appreciation=$rang['appreciation'];
				$com_prof=$rang['com_prof'];
				
				if ($rang['trim1']==99) $trim1="";
				else $trim1=$rang['trim1'];
				if ($rang['trim2']==99) $trim2="";
				else $trim2=$rang['trim2'];
				if ($rang['trim3']==99) $trim3="";
				else $trim3=$rang['trim3'];
				if ($rang['trim4']==99) $trim4="";
				else $trim4=$rang['trim4'];
				echo 
				"
				<a name=\"$id_eleve\"></a>
				<table width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"3\" cellpadding=\"0\" class=\"borduregrise\" bgcolor=\"#FFFFFF\">
  				<tr>
    				<td>
				";
				if (!isset($_GET['impression']))
				echo "<div align=\"left\"><img src=\"admilux/photo_classe/$id_eleve.jpg\" align=\"absmiddle\" ><a href=\"#haut\"><img src=\"images/config/hautdepage.gif\" align=\"absmiddle\" border=\"0\" ></a> <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/fiches/fiche_eleve.php?id_eleve=$id_eleve\" target=\"_blank\">$nom_eleve $prenom_eleve</a> </font></div>";
				else
				echo "<div align=\"left\"><img src=\"../photo_classe/$id_eleve.jpg\" align=\"absmiddle\" > <font size=\"3\" face=\"Arial, Helvetica, sans-serif\"> $nom_eleve $prenom_eleve</font></div>";
				echo"
					</td>				
  				</tr>
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
				if ($note==97) $note="<font color=\"#3399FF\">NR</font>";
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
			}
			
}
if (isset($_GET['impression'])) echo "<p align=\"right\"><img src=\"../../images/config/logogestclasse.gif\"></p>";
?>

