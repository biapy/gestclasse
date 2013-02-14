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

//protection de la page
if (!isset($_SESSION['login']) or !isset($_SESSION['passe']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}
 ?> 
<table width="80%" border="0" align="center">
  <tr>
    <td> 
      <p align="center"><font size="5" face="Arial, Helvetica, sans-serif"><em><font size="3">Espace de 
	  <? echo $_SESSION['nom_eleve']." ".$_SESSION['prenom_eleve'];?>
	  </font></em></font></p>
      <hr>
      <div align="left"> 
      <?
	   if ($etat_fiche=="on") echo" <p><font color=\"#FF6600\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"index.php?page=eleveok&eleve_lien=information\">Voir 
          et modifier mes informations</a> </font></p>";
       if ($etat_notes=="on") echo"<p><font color=\"#FF6600\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"index.php?page=eleveok&eleve_lien=notes\">Voir 
          mes résultats</a> </font></p>";
       if ($etat_trombi=="on") echo"<p><font color=\"#FF6600\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"index.php?page=eleveok&eleve_lien=trombi\">Voir 
          le trombinoscope de la classe</a></font> </p>";
       echo "<hr>";
	

    // affichage de mon commentaire ( si il y en a un !)
	if ($_SESSION['com_prof']!="")
	{
	$_SESSION['com_prof']=style($_SESSION['com_prof']);
	echo "<p><div align=\"left\"><font  size=\"3\" face=\"Arial, Helvetica, sans-serif\"><strong>Commentaire(s) du professeur me concernant : </strong></font><br>";
	echo "<font color=\"#FF6800\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">> $_SESSION[com_prof]</font></div></p>";
	}
	
	
	// affichage des messages pour la classe
    echo "<p><div align=\"left\"><font  size=\"3\" face=\"Arial, Helvetica, sans-serif\"><strong>Message(s) du professeur concernant la classe : </strong></font><br>";
	$sql="select classe FROM gc_eleve where id_eleve='$_SESSION[id_eleve]'";
	$resultat=mysql_db_query($dbname,$sql,$id_link);
	$rang=mysql_fetch_array($resultat);
	$classe=$rang['classe'];
	$sql="select contenu,UNIX_TIMESTAMP(date) from gc_bloc_notes where type='$classe' order by id_bloc";
	$resultat=mysql_db_query($dbname,$sql,$id_link);
	while($rang=mysql_fetch_array($resultat))
	{
	$contenu=style($rang[0]);
	$date=$rang[1];
	echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\"> > ";
	echo date_francais(getdate($date));
	echo heure(getdate($date));
	echo "<br>$contenu</font> <br><br>";
	}
	
	?>
      </div>
</td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<div align="left"></div>
