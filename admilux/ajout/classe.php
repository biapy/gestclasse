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

titre_page("Ajouter/supprimer une classe");
echo"<br>";

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


//formatage des textes
if (isset($_POST['nom'])) $_POST['nom']=texte($_POST['nom']);
if (isset($_POST['classe'])) $_POST['classe']=texte($_POST['classe']);


if ( isset($_GET['ajout']) and $_GET['ajout']=="ok")
{
$sql="INSERT INTO gc_classe ( classe ) VALUES ('$_POST[nom]')";
mysql_db_query($dbname,$sql,$id_link);
$sql="select  * from gc_classe where id_classe=LAST_INSERT_ID()";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$nom=$rang['classe'];
message('La classe '.$nom.' a été ajoutée');
}


//suppression d'une classe

if ( (isset($_POST['del']) and $_POST['del']=="ok") or (isset($_GET['del']) and $_GET['del']=="ok") )
{
	  if (!isset($_GET['del_confirmation'])) 
	  {
	  message('Voulez-vous vraiment supprimer la classe '.$_POST['classe'].' définitivement de la base de données');
	  echo"
		<p><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\"  align=\"absmiddle\"><a href=\"?page_admi=admiajout_classe&del=ok&del_confirmation=ok&classe=$_POST[classe]\">OUI</a></font>
		<font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/config/lien.gif\" align=\"absmiddle\"><a href=\"?page_admi=admiajout_classe\">NON</a></font></p>
		";
	  }
	 if (isset($_GET['del_confirmation'])) 
	 { 
	 $sql="delete  from gc_classe where classe='$_GET[classe]'";
	 mysql_db_query($dbname,$sql,$id_link);
	 message('La classe '.$_GET['classe'].' a été supprimée définitivement de la base de données');
	 }
	 
}



?>
<form name="form1" method="post" action="?page_admi=admiajout_classe&ajout=ok">
  <table width="70%" border="0" align="center" cellpadding="2" cellspacing="0" class="bordure">
    <tr> 
      <td width="31%"> <div align="left"><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"> 
          Nom de la classe</font></div></td>
      <td width="69%"> <div align="center"> 
          <input name="nom" type="text" id="nom" size="30">
        </div></td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <div align="center">
          <p>&nbsp;</p>
          <p> 
            <input name="ajouter" type="submit" value="Ajouter">
          </p>
          </div></td>
    </tr>
  </table>
</form>


 <form action="?page_admi=admiajout_classe" method="post">
  <p>&nbsp;</p>
  <table width="70%" border="0" align="center" cellpadding="2" cellspacing="0" class="bordure">
    <tr> 
      <td> <div align="left">
          <p><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"></font><font face="Arial, Helvetica, sans-serif"> 
            Supprimer une classe 
            <?
	echo "<select name=\"classe\" >";
	$sql="select  classe  from gc_classe";
	$resultat=mysql_db_query($dbname,$sql,$id_link);
	while($rang=mysql_fetch_array($resultat))
	{
	$classe=$rang[classe];
	echo"<option>$classe</option>";
	}
	echo "</select>";
  ?>
            </font></p>
          <p><font size="1" face="Arial, Helvetica, sans-serif"> <br>Seule la classe est supprimée de la base gc_classe . Les données concernant la classe présentes dans les autres tables sont conservées ( élèves, cahier de texte ... )</font> 
            <font face="Arial, Helvetica, sans-serif"></p>
          <p align="center"><font face="Arial, Helvetica, sans-serif"> 
            <input name="supprimer" type="submit" value="Supprimer">
            </font> </p>
        </div>
        </td>
    </tr>
  </table>
  <div align="left">
    <input name="del" type="hidden" value="ok">

  </div>
</form>
<?
message('- Le nom d\'une classe peut comporter au maximum 30 caractères. <br>- Ce nom doit être unique.<br>- Ne cherchez pas à modifier le nom de la classe. ( Si une modification est nécessaire, il faut supprimer la classe, puis recommencer )<br>');
?>