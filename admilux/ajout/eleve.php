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
##                      modifié avec l'aide de TRUGEON Nicolas                ##
##   This program is free software. You can redistribute it and/or modify     ##
##   it under the terms of the GNU General Public License as published by     ##
##   the Free Software Foundation.                                            ##
################################################################################

titre_page("Ajouter un élève");
echo"<br>";
// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


//formatage des textes
if (isset($_POST['nom'])) $_POST['nom']=texte($_POST['nom']);
if (isset($_POST['prenom'])) $_POST['prenom']=texte($_POST['prenom']);


//traitement du formulaire
if ( isset($_GET['ajout']) and $_GET['ajout']=="ok")
{
$sql="INSERT INTO gc_eleve ( nom, prenom, classe, login, passe, trim1, trim2, trim3, trim4 ) VALUES ('$_POST[nom]', '$_POST[prenom]','$_POST[classe]','$_POST[nom]', '$_POST[prenom]',99,99,99,99)";
mysql_db_query($dbname,$sql,$id_link);
$sql="select  * FROM gc_eleve where id_eleve=LAST_INSERT_ID()";
$resultat=mysql_db_query($dbname,$sql,$id_link);
$rang=mysql_fetch_array($resultat);
$id_eleve=$rang['id_eleve'];
$nom=$rang['nom'];
$prenom=$rang['prenom'];
$classe=$rang['classe'];
message('l\'élève '.$nom.' '.$prenom.' ( classe de '.$classe.' ) a été ajouté dans la base de données');

}

// Ajout d'un élève arrivé en cours d'année
if ( (isset($_POST['apres'])) and $_POST['apres']=='ok')
{
$sql="select  id_devoir  from gc_devoir where classe='$_POST[classe]'";
$resultat=mysql_db_query($dbname,$sql,$id_link);
while($rang=mysql_fetch_array($resultat))
{
$id_devoir=$rang['id_devoir'];
$sql2="INSERT INTO gc_notes ( id_devoir, id_eleve, note, com_note) VALUES ('$id_devoir', '$id_eleve', '98', 'Inscrit apres la rentree')";
mysql_db_query($dbname,$sql2,$id_link);
}

}

// traitement du fichier d'importation
if ( isset($_GET['ajout']) and $_GET['ajout']=="import")
{

 // On ouvre le fichier à importer en lecture seulement
 $fichier=$_FILES['userfile']['tmp_name'];
 if ($_FILES['userfile']['size']==0)
    { // le fichier n'existe pas
       message('Fichier introuvable !<br>Importation stoppée.');
    }
    else
    {
       $fp = fopen("$fichier", "r");
	   $eleves="";
       while (!feof($fp))
       { // Tant qu'on n'atteint pas la fin du fichier
       $ligne = fgets($fp,4096); // On lit une ligne
       // On récupère les champs séparés par ; dans liste
       $liste = explode(";",$ligne);

       // On assigne les variables
       $nom = $liste[0];
       $prenom = $liste[1];
       $classe =  $_POST['classe'];
       $login = $liste[0];
       $passe = $liste[1];
       if ($nom=="" || $prenom=="")
            message('Le fichier à importer pose problème, vérifier la structure.');
       else
       {
       // Ajouter un nouvel enregistrement dans la table
       if ($eleves!="")
            $eleves.=", ";
       $sql = "INSERT INTO gc_eleve ( nom, prenom, classe, login , passe, trim1, trim2, trim3, trim4 ) VALUES ('$nom', '$prenom','$classe','$login', '$passe',99,99,99,99)";
       $result= mysql_db_query($dbname,$sql,$id_link);
       $eleves.="$nom";
       }
       }

        // Fermeture
        fclose($fp);
        message("importation réussie des élèves : $eleves");
    }
}
?>


<form name="form1" method="post" action="admi.php?page_admi=admiajout&ajout=ok">
  <table width="70%" border="0" align="center" cellpadding="2" cellspacing="0" class="bordure">
    <tr> 
      <td width="30%"> <div align="left"><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"> 
          Nom</font></div></td>
      <td> <div align="left"> 
          <input name="nom" type="text" id="nom" size="30">
        </div></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"> 
          Prenom</font></div></td>
      <td> <div align="left"> 
          <input name="prenom" type="text" id="prenom" size="30">
        </div></td>
    </tr>
    <tr> 
      <td width="30%"> <div align="left"><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"> 
          Classe</font></div></td>
      <td> 
        <?
                echo "<select name=\"classe\" >";
                $sql="select  classe  from gc_classe";
                $resultat=mysql_db_query($dbname,$sql,$id_link);
				if (isset($_POST['classe'])) echo"<option>$_POST[classe]</option>"; 
                while($rang=mysql_fetch_array($resultat))
                {
                $classe=$rang[classe];
                if (isset($_POST['classe']) and ($_POST['classe']<>$classe)) echo"<option>$classe</option>";
				if (!isset($_POST['classe'])) echo"<option>$classe</option>";
				}
                echo "</select>";
        ?>
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">S&eacute;lectionnez 
          cet onglet si l'&eacute;l&egrave;ve est ajout&eacute; apr&egrave;s un 
          ( ou plusieurs ) contr&ocirc;le :</font> 
          <input type="radio" name="apres" value="ok">
        </div></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="ajouter" type="submit" value="Ajouter"></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>

<form name="form2" method="post" action="admi.php?page_admi=admiajout&ajout=import" enctype="multipart/form-data">
  <table width="70%" border="0" align="center" cellpadding="2" cellspacing="0" class="bordure">
    <tr>
      <td width="30%"> <div align="left"><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"> 
          Fichier</font></div></td>
      <td> <div align="left">
          <input type="hidden" name="MAX_FILE_SIZE" value="100000"><input type="file" name="userfile" size="37">
        </div></td>
    </tr>
    <tr>
      <td width="30%"> <div align="left"><font face="Arial, Helvetica, sans-serif"><img src="images/config/lien.gif" align="absmiddle"> 
          Classe</font></div></td>
      <td>
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
        <div align="center"></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><p>&nbsp; </p>
        <p>
          <input name="ajouter2" type="submit" value="Ajouter">
        </p>
        </td>
    </tr>
  </table>
</form>
<?
message('Par défaut le login de l\'élève est son nom et le mot de passe est son prénom ( attention aux homonymes ! )<br>- Pour modifier les mots de passe par défaut, allez dans la rubrique - Fiches - <br> - Pour supprimer un élève, allez dans la rubrique - Fiches -<br><br> Vous pouvez également importer les élèves d\'une classe à partir d\'un fichier contenant le nom, prénom séparés par un point virgule.<br>ex:<br>Jules;Cesar;<br>Alexandre;Le Grand;<br>N\'utilisez pas cette deuxième option dans le cas où vous ajoutez un élève en cours d\'année');
?>
