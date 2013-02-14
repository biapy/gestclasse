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
	

	// Calcul des moyennes des élèves		
	if (isset($_GET['calcul']) and $_GET['calcul']='ok')
	{ 
		$sql="select id_eleve FROM gc_eleve where classe='$_GET[choix_classe]'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		while($rang=mysql_fetch_array($resultat))
		{
		$id_eleve=$rang['id_eleve'];		
		for ($i=1 ; $i<=3 ; $i++)
				{
				$trim="trim".$i;
				$sql1="select SUM(gc_notes.note*gc_devoir.coef)/SUM(gc_devoir.coef) FROM gc_notes,gc_devoir where (gc_notes.note<'90') and (id_eleve='$id_eleve') and (gc_notes.id_devoir=gc_devoir.id_devoir) and (gc_devoir.trim='$trim') ";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				$rang1=mysql_fetch_array($resultat1);
				if (!$rang1['0'] and $rang1['0']!="0")
				$moy[$i]="99.0";
				else
				$moy[$i]=$rang1['0']; 
				
				}
				$sql2="select SUM(gc_notes.note*gc_devoir.coef)/SUM(gc_devoir.coef) FROM gc_notes,gc_devoir where (gc_notes.note<'90') and (id_eleve='$id_eleve') and (gc_notes.id_devoir=gc_devoir.id_devoir) ";
				$resultat2=mysql_db_query($dbname,$sql2,$id_link);
				$rang2=mysql_fetch_array($resultat2);
				if (!$rang2['0'] and $rang2['0']!="0")
				$moy_gen="99.0";
				else
				$moy_gen=$rang2['0']; 
				
				$sql3="UPDATE gc_eleve SET trim1='$moy[1]',trim2='$moy[2]',trim3='$moy[3]',trim4='$moy_gen' where id_eleve='$id_eleve'";
				$resultat3=mysql_db_query($dbname,$sql3,$id_link);
		}
		}
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
echo "<tr><td><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">  <img src=\"images/config/lien.gif\" >  Tableau de notes <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=devoir&choix_classe=$_GET[choix_classe]\">
     	 Statistiques des devoirs</a> <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=classe&choix_classe=$_GET[choix_classe]\"> Statistiques de la classe</a> <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_ligne&choix_classe=$_GET[choix_classe]\"> Notes en ligne - appréciations</a>  <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=admicarnet&choix_classe=$_GET[choix_classe]\"> Carnet de notes complet</a> </font><div></td></tr>";  
?>
</table>
<p>
<? 
if (isset($_GET['choix_classe'])  and !isset($_GET['impression']))
echo "<p align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]&cacher=1\">Cacher 
  le trimestre 1</a> - <a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]&cacher=12\">Cacher 
  les trimestres 1 et 2</a></font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> - <a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]\">Voir 
les trois trimestres</a> </font> </p>";
  
if (isset($_GET['choix_classe']))
{

// lien pour modifier les devoirs
if (!isset($_GET['impression']))
{
			$sql="select  id_devoir,nom  FROM gc_devoir where classe='$_GET[choix_classe]' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			echo "<div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Modifier une note ou un devoir : ";
			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			$id_devoir=$rang['id_devoir'];
				$sql1="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				$rang1=mysql_fetch_array($resultat1);
				$nb_notes=$rang1[0];
				if ($nb_notes==0)
				{
				$nb_notes="pas_de_note";
				echo " > <a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=pas_de_note\">$nom</a>";
				}
				else echo " > <a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=$nb_notes\">$nom</a>";

			}
			echo "</font></div>";
}
// fin : lien pour modifier les devoirs

//le nombre de devoirs 

for ($i=1;$i<=3;$i++)
{
$sql="select  count(nom)  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim$i' and coef<>'0' ORDER BY id_devoir";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$nb_ds_trim[$i]=$rang[0];
if ($nb_ds_trim[$i]>0) ($largeur[$i]=41*$nb_ds_trim[$i] and $largeur_ds[$i]=40);
else $largeur[$i]=40;
}
if (isset($_GET['cacher']) and ( $_GET['cacher']=="1" or $_GET['cacher']=="12")) 
{
$largeur[1]="0";
$trim1="";
}
else $trim1="trim1";

if (isset($_GET['cacher']) and ($_GET['cacher']=="12"))
{
$largeur[1]=0;
$largeur[2]=0;
$trim1="";
$trim2="";
}
else 
{
if ($_GET['cacher']<>"1") $trim1="trim1";
$trim2="trim2";
}
$largeur_tableau=140+$largeur[1]+$largeur[2]+$largeur[3]+200;

echo"
<table width=\"$largeur_tableau\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#000033\">
  <tr>
    <td><table width=\"$largeur_tableau\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" >
        <tr bgcolor=\"#FFFFFF\"> 
          <td width=\"140\" bgcolor=\"#E4C6F9\">
	";
if (!isset($_GET['impression']))
echo"<div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admi.php?page_admi=notes_tableau&choix_classe=$_GET[choix_classe]&calcul=ok\">CALCUL 
  DES MOYENNES</a></font></div>";


echo"
		 </td>
          <td bgcolor=\"#D9E6F2\" width=\"$largeur[1]\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$trim1
              </font></div></td>
          <td bgcolor=\"#FFFFEC\" width=\"$largeur[2]\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$trim2 
              </font></div></td>
          <td bgcolor=\"#D9E6F2\" width=\"$largeur[3]\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">trim 
              3</font></div></td>
          <td bgcolor=\"#E4C6F9\" width=\"200\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Moyennes</font></div></td>
        </tr>
        <tr bgcolor=\"#FFFFFF\"> 
          <td width=\"140\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Nom 
              </font></div></td>
          <td width=\"$largeur[1]\"> 
              <table width=\"$largeur[1]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr> 
		";
			if (isset($_GET['cacher']) and ( $_GET['cacher']=="1" or $_GET['cacher']=="12"))
			echo"";
			else
			{
			//les devoirs du trim1
			$sql="select  id_devoir,nom  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim1' and coef<>'0' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);

			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			$id_devoir=$rang['id_devoir'];
			if (!isset($_GET['impression']))
			echo "<td width=\"$largeur_ds[1]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/carnet/devoir_seul.php?choix_classe=$_GET[choix_classe]&id_devoir=$id_devoir&nom=$nom\" target=\"blank\">$nom</a></font></td>";
			else
			echo "<td width=\"$largeur_ds[1]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom</font></td>";
			}
			}
echo "</tr></table></td>";
echo" <td width=\"$largeur[2]\"> 
           <table width=\"$largeur[2]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;
			if (isset($_GET['cacher']) and $_GET['cacher']=="12")
			echo"";
			else
			{
			//les devoirs du trim2
			$sql="select  id_devoir,nom  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim2' and coef<>'0' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			$id_devoir=$rang['id_devoir'];
			if (!isset($_GET['impression']))
			echo "<td width=\"$largeur_ds[2]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/carnet/devoir_seul.php?choix_classe=$_GET[choix_classe]&id_devoir=$id_devoir&nom=$nom\" target=\"blank\">$nom</a></font></td>";
			else
			echo "<td width=\"$largeur_ds[2]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom</font></td>";
			}
			}
echo "</tr></table></td>";
echo" <td width=\"$largeur[3]\"> 
           <table width=\"$largeur[3]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;
			 
			//les devoirs du trim3				
			$sql="select  id_devoir,nom  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim3' and coef<>'0' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			$id_devoir=$rang['id_devoir'];
			if (!isset($_GET['impression']))
			echo "<td width=\"$largeur_ds[3]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"admilux/carnet/devoir_seul.php?choix_classe=$_GET[choix_classe]&id_devoir=$id_devoir&nom=$nom\" target=\"blank\">$nom</a></font></td>";
			else
			echo "<td width=\"$largeur_ds[3]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom</font></td>";
			
			}
echo "</tr></table></td>";

if (!isset($_GET['impression']))
{
echo"       <td width=\"200\"> 
              <table width=\"200\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr> 
                  <td width=\"50\" ><div align=\"center\">
				  	  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      <a href=\"admilux/carnet/trimestre_seul.php?choix_classe=$_GET[choix_classe]&trimestre=trim1\" target=\"blank\">trim1 </a>
					  </font>
				  </td>
                  <td width=\"50\" ><div align=\"center\">
				  	  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      <a href=\"admilux/carnet/trimestre_seul.php?choix_classe=$_GET[choix_classe]&trimestre=trim2\" target=\"blank\">trim2 </a>
					  </font>
				  </td>
                  <td width=\"50\" ><div align=\"center\">
				  	  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      <a href=\"admilux/carnet/trimestre_seul.php?choix_classe=$_GET[choix_classe]&trimestre=trim3\" target=\"blank\">trim3 </a>
					  </font>
				  </td>
				 <td width=\"50\" ><div align=\"center\">
				  	  <font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      <a href=\"admilux/carnet/trimestre_seul.php?choix_classe=$_GET[choix_classe]&trimestre=trim4\" target=\"blank\">Générale</a>
					  </font>
				  </td>
                </tr>
              </table>
			</td>
			</tr>
";
}
else
{
echo"       <td width=\"200\"> 
              <table width=\"200\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr> 
                  <td width=\"50\" ><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      trim1</font></div></td>
                  <td width=\"50\" ><div align=\"center\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      trim2</font></div></td>
                  <td width=\"50\" ><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      trim3</font></div></td>
                  <td width=\"50\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">G&eacute;nerale</font></div></td>
                </tr>
              </table>
			</td>
			</tr>
";
}
// les résultats des élèves
$sql="select id_eleve, nom , prenom, trim1, trim2, trim3, trim4 FROM gc_eleve where classe='$_GET[choix_classe]' ORDER BY nom,prenom ";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			$couleur='#F4F4F4';
			while($rang=mysql_fetch_array($resultat))
			{
			    $id_eleve=$rang['id_eleve'];
				$nom_eleve=$rang['nom'];
				$nom_eleve=subStr($nom_eleve,0,19);
				$prenom_eleve=$rang['prenom'];
				$prenom_eleve=subStr($prenom_eleve,0,1).".";
				if ($rang['trim1']==99) $trim1="<font color=\"#ffffff\">.</font>";
				else $trim1=$rang['trim1'];
				if ($rang['trim2']==99) $trim2="<font color=\"#ffffff\">.</font>";
				else $trim2=$rang['trim2'];
				if ($rang['trim3']==99) $trim3="<font color=\"#ffffff\">.</font>";
				else $trim3=$rang['trim3'];
				if ($rang['trim4']==99) $trim4="<font color=\"#ffffff\">.</font>";
				else $trim4=$rang['trim4'];
			
echo"<tr bgcolor=\"$couleur\"> 
          <td width=\"140\">";
if (!isset($_GET['impression'])) 
echo "<div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> &nbsp; <a href=\"admilux/fiches/fiche_eleve.php?id_eleve=$id_eleve\" target=\"_blank\"> $nom_eleve $prenom_eleve</a> </font></div></td>";
else
echo "<div align=\"left\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;  $nom_eleve $prenom_eleve </font></div></td>";

if ($couleur=='#F4F4F4') $couleur='#FFFFFF';
else $couleur='#F4F4F4';	
// les notes des élèves ( trim1)
if (isset($_GET['cacher']) and ( $_GET['cacher']=="1" or $_GET['cacher']=="12"))
echo"<td></td>";
else
{
echo" <td width=\"$largeur[1]\"> 
           <table width=\"$largeur[1]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;		  
		  		$sql1="select gc_notes.note, gc_devoir.nom FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim1') and (gc_devoir.coef<>'0') ";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				$bordure=1;
				while($rang1=mysql_fetch_array($resultat1))
				{
				$note=$rang1['0'];
				if ($note==99) $note="<font color=\"#3399FF\">ABS</font>";
				if ($note==98) $note="<font color=\"#6666CC\">NN</font>";
				if ($note==97) $note="<font color=\"#3399FF\">NR</font>";
			    if ($note<10) $note="<font color=\"#ff0000\">$note</font>";
				$nom_devoir=$rang1['1'];
				if ($bordure==1)
				{
				echo "<td   align=\"center\" width=\"$largeur_ds[1]\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$note </font></td>";
				$bordure++;
				}
				else
				echo "<td width=\"$largeur_ds[1]\"  class=\"borduregauchebleue\" align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$note </font></td>";
			
		  		}
echo "</tr></table></td>";
}
// les notes des élèves ( trim2)
if (isset($_GET['cacher']) and $_GET['cacher']=="12")
echo"<td></td>";
else
{
echo" <td width=\"$largeur[2]\"> 
           <table width=\"$largeur[2]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;		  
		  		$sql1="select gc_notes.note, gc_devoir.nom FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim2')  and (gc_devoir.coef<>'0') ";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				$bordure=1;
				while($rang1=mysql_fetch_array($resultat1))
				{
				$note=$rang1['0'];
				if ($note==99) $note="<font color=\"#3399FF\">ABS</font>";
				if ($note==98) $note="<font color=\"#6666CC\">NN</font>";
				if ($note==97) $note="<font color=\"#3399FF\">NR</font>";
			    if ($note<10) $note="<font color=\"#ff0000\">$note</font>";
				$nom_devoir=$rang1['1'];
				if ($bordure==1)
				{
				echo "<td   align=\"center\" width=\"$largeur_ds[2]\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$note </font></td>";
				$bordure++;
				}
				else
				echo "<td width=\"$largeur_ds[2]\"  class=\"borduregauchebleue\" align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$note </font></td>";
			
		  		}
echo "</tr></table></td>";
}
// les notes des élèves ( trim3)
echo" <td width=\"$largeur[3]\"> 
           <table width=\"$largeur[3]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;		  
		  		$sql1="select gc_notes.note, gc_devoir.nom FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim3'  and (gc_devoir.coef<>'0') ) ";
				$resultat1=mysql_db_query($dbname,$sql1,$id_link);
				$bordure=1;
				while($rang1=mysql_fetch_array($resultat1))
				{
				$note=$rang1['0'];
				if ($note==99) $note="<font color=\"#3399FF\">ABS</font>";
				if ($note==98) $note="<font color=\"#6666CC\">NN</font>";
				if ($note==97) $note="<font color=\"#3399FF\">NR</font>";
			    if ($note<10) $note="<font color=\"#ff0000\">$note</font>";
				$nom_devoir=$rang1['1'];
				if ($bordure==1)
				{
				echo "<td   align=\"center\" width=\"$largeur_ds[3]\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$note </font></td>";
				$bordure++;
				}
				else
				echo "<td width=\"$largeur_ds[3]\"  class=\"borduregauchebleue\" align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$note </font></td>";
			
		  		}
echo "</tr></table></td>";


if ($trim1<10) $trim1="<font color=\"#ff0000\">$trim1</font>";
if ($trim2<10) $trim2="<font color=\"#ff0000\">$trim2</font>";
if ($trim3<10) $trim3="<font color=\"#ff0000\">$trim3</font>";
if ($trim4<10) $trim4="<font color=\"#ff0000\">$trim4</font>";

echo"

          <td width=\"200\"> 
              <table width=\"200\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr> 
                  <td width=\"50\" class=\"borduredroitebleue\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      $trim1</font></div></td>
                  <td width=\"49\" class=\"borduredroitebleue\"><div align=\"center\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      $trim2</font></div></td>
                  <td width=\"49\" class=\"borduredroitebleue\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      $trim3</font></div></td>
                  <td width=\"49\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      $trim4</font></div></td>
                </tr>
              </table>
            </td>
        </tr>
		";
}
echo"
      </table></td>
  </tr>
</table>
<br>
";

		
}

if (!isset($_GET['impression']) and isset($_GET['choix_classe']))
{
message('- Cliquez sur un élève pour voir et modifier sa fiche<br>- Cliquez sur un devoir pour voir les statistiques du devoir<br>- Cliquez sur un trimestre pour voir les statistiques du trimestre ');
}
if (isset($_GET['impression'])) echo "<p align=\"right\"><img src=\"../../images/config/logogestclasse.gif\"></p>";
?>