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
     	 Statistiques des devoirs</a> <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=classe&choix_classe=$_GET[choix_classe]\"> Statistiques de la classe</a> <img src=\"images/config/lien.gif\" > <a href=\"admi.php?page_admi=notes_ligne&choix_classe=$_GET[choix_classe]\"> Notes en ligne - appréciations</a>  <img src=\"images/config/lien.gif\" >  Carnet de notes complet</font><div></td></tr>";  
?>
</table>
<p><br>
  <?
if (isset($_GET['choix_classe']))
{

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
$largeur_tableau=140+$largeur[1]+$largeur[2]+$largeur[3]+200;

echo"
<table width=\"$largeur_tableau\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#000033\">
  <tr>
    <td><table width=\"$largeur_tableau\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" >
        <tr bgcolor=\"#FFFFFF\"> 
          <td width=\"140\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"></font></div></td>
          <td bgcolor=\"#D9E6F2\" width=\"$largeur[1]\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Trim 
              1</font></div></td>
          <td bgcolor=\"#FFFFEC\" width=\"$largeur[2]\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Trim 
              2</font></div></td>
          <td bgcolor=\"#D9E6F2\" width=\"$largeur[3]\"> 
            <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Trim 
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
			//les devoirs du trim1
			$sql="select  nom  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim1' and coef<>'0' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);

			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			echo "<td width=\"$largeur_ds[1]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom </font></td>";
			}
echo "</tr></table></td>";
echo" <td width=\"$largeur[2]\"> 
           <table width=\"$largeur[2]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;

			//les devoirs du trim2
			$sql="select  nom  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim2' and coef<>'0' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			echo "<td width=\"$largeur_ds[2]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom </font></td>";
			}
echo "</tr></table></td>";
echo" <td width=\"$largeur[3]\"> 
           <table width=\"$largeur[3]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;
			  				
			$sql="select  nom  FROM gc_devoir where classe='$_GET[choix_classe]' and trim='trim3' and coef<>'0' ORDER BY id_devoir";
			$resultat=mysql_db_query($dbname,$sql,$id_link);
			while($rang=mysql_fetch_array($resultat))
			{
			$nom=subStr($rang['nom'],0,3);
			echo "<td width=\"$largeur_ds[3]\"   align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom </font></td>";
			}
echo "</tr></table></td>";


echo"       <td width=\"200\"> 
              <table width=\"200\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr> 
                  <td width=\"50\" ><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      trim1</font></div></td>
                  <td width=\"49\" ><div align=\"center\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      trim2</font></div></td>
                  <td width=\"49\" ><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> 
                      trim3</font></div></td>
                  <td width=\"49\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">G&eacute;nerale</font></div></td>
                </tr>
              </table>
			</td>
			</tr>
";

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

// les notes des élèves ( trim2)
echo" <td width=\"$largeur[2]\"> 
           <table width=\"$largeur[2]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;		  
		  		$sql1="select gc_notes.note, gc_devoir.nom FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim2'  and (gc_devoir.coef<>'0')) ";
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

// les notes des élèves ( trim3)
echo" <td width=\"$largeur[3]\"> 
           <table width=\"$largeur[3]\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>" ;		  
		  		$sql1="select gc_notes.note, gc_devoir.nom FROM gc_notes,gc_devoir where (gc_notes.id_eleve='$id_eleve' ) and (gc_notes.id_devoir=gc_devoir.id_devoir and gc_devoir.trim='trim3'  and (gc_devoir.coef<>'0')) ";
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


if (!isset($_GET['impression'])) 
{
titre_page("Statistiques des devoirs");
echo "<a href=\"#haut\"><img src=\"images/config/hautdepage.gif\" align=\"absmiddle\" border=\"0\" ></a>";
}
else
titre_page_impression("Statistiques des devoirs");		

//les ds
	$sqld="select * FROM gc_devoir where classe='$_GET[choix_classe]' and coef<>'0' ORDER BY id_devoir ";
	$resultatd=mysql_db_query($dbname,$sqld,$id_link);
	while($rangd=mysql_fetch_array($resultatd))
	{
		$id_devoir=$rangd['id_devoir'];
		$nom=$rangd['nom'];
		$duree=$rangd['duree'];
		$trim=$rangd['trim'];
		$coef=$rangd['coef'];
		$type=$rangd['type'];
		$date=$rangd['date'];
		$commentaire=$rangd['commentaire'];

		//aucune note
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nb_notes=$rang[0];
		if ($nb_notes==0) $nb_notes="pas_de_note";
		echo
		"

		<table bgcolor=\"#FFFFFF\" width=\"90%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"borduregrise\">
		<tr>
		<td>
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  >
		  <tr> 
			<td width=\"16%\"  > <div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp; $nom </strong></font><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $trim</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">dur&eacute;e</font></div></td>
			<td width=\"16%\"> <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">coef</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">type</font></div></td>
			<td width=\"16%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">date</font></div></td>
			<td width=\"20%\" > <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">commentaire</font></div></td>
		  </tr>
		  <tr> 
		  ";
		  if (!isset($_GET['impression'])) 
		  {
		  if ($nb_notes==0) echo "<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=pas_de_note\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">modifier</font></a></font></div></td>";
		  else echo "<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?page_admi=adminouveau_dev&id_devoir=$id_devoir&modification_notes_bis=ok&nb_notes=$nb_notes\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">modifier</font></a></font></div></td>";	
		  }
		  else echo"<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"></font></div></td>";
		  echo"
		  	<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\"> $duree</font></div></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$coef</font></div></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$type</font></div></td>
			<td width=\"16%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$date</font></div></td>
			<td width=\"20%\" ><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$commentaire</font></div></td>
		   </tr>
		 </table>
		 </td>
		 </tr>
		 ";
		
		//les statistiques  ... du devoir

		$sql="select  COUNT(note) FROM gc_notes where (id_devoir=$id_devoir) and (note>'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$absent=$rang[0];
		
		$sql="select  COUNT(note),ROUND(AVG(note),1),MIN(note),MAX(note),ROUND(STD(note),1) FROM gc_notes where id_devoir=$id_devoir and note<'90'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$nombre_present=$rang[0];
		$moyenne=$rang[1];
		$minimum=$rang[2];
		$maximum=$rang[3];
		$ecart_type=$rang[4];
		
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90') and (note>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$sup10=$rang[0];
		
		$sql="select  count(note) FROM gc_notes where (id_devoir=$id_devoir) and (note<'90') and (note<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$inf10=$rang[0];
		
		
		$sql="select  note FROM gc_notes where (id_devoir=$id_devoir) and (note<'90')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$i=1;
		while($rang=mysql_fetch_array($resultat))
		{
				$notem[$i]=$rang['0'];
				$i++;
		}
		if ($notem) $mediane=mediane($notem);
		echo
		"
		<tr>
		<td>
		<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\" >
		  <tr> 
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Absents ou non not&eacute;s</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Moyenne</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">M&eacute;diane</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Min</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Max</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">sup10</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">inf10</font></div></td>
			<td width=\"20%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Ecart 
				type</font></div></td>
		  </tr>
		  <tr> 
			<td width=\"12%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$absent</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$moyenne</font></div></td>
			<td width=\"12%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$mediane</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$minimum</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$maximum</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$sup10</font></div></td>
			<td width=\"11%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$inf10</font></div></td>
			<td width=\"20%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$ecart_type</font></div></td>
		  </tr>
		</table>
		</td>
		</tr>
		<tr>
		<td><div align=\"center\">";
		graphique('note','gc_notes','id_devoir',$id_devoir);
		echo"</div>
		</td>
		</tr>
		<br>
		</table>
		<br>
		";
		
		}
		
//les statistiques de la classe

		
		if (!isset($_GET['impression'])) 
		{
		titre_page("Statistiques de la classe");
		echo "<a href=\"#haut\"><img src=\"images/config/hautdepage.gif\" align=\"absmiddle\" border=\"0\" ></a>";	
		}
		else
		titre_page_impression("Statistiques de la classe");
		for ($k=1 ; $k<=4 ; $k++)
		{
		$sql="select  COUNT(trim$k),ROUND(AVG(trim$k),1),MIN(trim$k),MAX(trim$k),ROUND(STD(trim$k),1) FROM gc_eleve where classe='$_GET[choix_classe]' and trim$k!='99.0'";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		$moy=$rang[1];
		$min=$rang[2];
		$max=$rang[3];
		$ecty=$rang[4];
		
		
		$sql="select  count(trim$k) FROM gc_eleve where classe='$_GET[choix_classe]' and trim$k!='99.0' and (trim$k>=10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
		if (!$moy) $sup="";
		else $sup=$rang[0]; 
		
		
		
		$sql="select  count(trim$k) FROM gc_eleve where classe='$_GET[choix_classe]' and trim$k!='99.0' and (trim$k<10)";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		$rang=mysql_fetch_array($resultat);
 		if (!$moy) $inf="";
		else $inf=$rang[0]; 
		$sql="select  trim$k FROM gc_eleve where classe='$_GET[choix_classe]' and (trim$k!='99')";
		$resultat=mysql_db_query($dbname,$sql,$id_link);
		unset($notem);
		unset($med);
		$j=1;
		while($rang=mysql_fetch_array($resultat))
		{
				$notem[$j]=$rang['0'];
				$j++;
		}
		if (isset($notem)) $med=mediane($notem);
		else $med=0;
	
		if ($k==4)
		{
		echo"<table align=\"center\" width=\"90%\" border=\"0\"><tr><td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Moyenne générale</font><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> ( Calculée sur toutes les notes coefficientées de l'année)</font></td></tr></table>";
		}
		else
		{
		echo"<table align=\"center\" width=\"90%\" border=\"0\"><tr><td><div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Trimestre $k</font></td></tr></table>";
		}
		echo
		"
		<table bgcolor=\"#ffffff\" width=\"90%\" align=\"center\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\" class=\"borduregrise\">
		  <tr><td>
		    <table width=\"100%\"><tr> 
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Moyenne</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">M&eacute;diane</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Min</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Max</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">sup10</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">inf10</font></div></td>
			<td width=\"22%\"><div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Ecart 
				type</font></div></td>
			</tr>
			</table>	
		  </td></tr>
		  <tr><td>
		    <table width=\"100%\"><tr> 
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$moy</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$med</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$min</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$max</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$sup</font></div></td>
			<td width=\"13%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$inf</font></div></td>
			<td width=\"22%\"><div align=\"center\"><font color=\"#0000CC\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$ecty</font></div></td>
		  </tr></table></td></tr><tr><td><div align=\"center\">";
		$trim='trim'.$k;
		graphique( $trim,'gc_eleve','classe',$_GET['choix_classe']);
		echo "</div></td></tr></table><br>";

		}
		
}

if (isset($_GET['impression'])) echo "<p align=\"right\"><img src=\"../../images/config/logogestclasse.gif\"></p>";
?>