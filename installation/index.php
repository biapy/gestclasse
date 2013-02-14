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
?>
<p><img src="../images/config/logogestclasse.gif"> </p>
<p align="center"><font size="4" face="Arial, Helvetica, sans-serif">Installation 
  de Gest'classe ... &eacute;tapes 4,5,6 et 7<br>
  <a href="../lisez_moi.htm"><font size="1">revoir les &eacute;tapes 1,2 et 3</font></a></font></p>
<?
//saisie 
if (isset($_GET['saisie']) and  $_GET['saisie']=='ok')
{
	
	$fichier = "../commun/connect.php";
	$ecrire="<?\n\$dbname=\"$_POST[base]\";\n\$hostname=\"$_POST[serveur]\";\n\$username=\"$_POST[login]\";\n\$password=\"$_POST[passe]\";\n\$id_link=mysql_connect(\$hostname,\$username,\$password);\n?>"; 
	$fp = @fopen($fichier, "w"); // le fichier est ouvert en ecriture, remis a zero 
	if (!$fp) { echo "Impossible d'ouvrir $fichier en ecriture"; exit; } 
  	fputs($fp, $ecrire); fclose($fp); } ?> </p>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <p align="left"><font size="3" face="Arial, Helvetica, sans-serif"><img src="../images/config/lien.gif" width="19" height="9">Etape 
        4</font><br>
        <font size="2" face="Arial, Helvetica, sans-serif">Si l'&eacute;tape 3 
        n'est pas r&eacute;alis&eacute;e, ... ce n'est pas la peine de continuer 
        !<br>
        Il faut maintenant cr&eacute;er une base de donn&eacute;es et r&eacute;cup&eacute;rer 
        les param&egrave;tres de connexion &agrave; cette base</font> <font size="2" face="Arial, Helvetica, sans-serif"> 
        ( nom du serveur, nom de la base,login et mot de passe )</font></p></td>
  </tr>
  <tr> 
    <td> <div align="left"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
          <tr> 
            <td width="50%" bgcolor="#FFFF99"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">- 
                Cliquez sur le <font size="5">e</font> , puis s&eacute;lectionnez 
                Administration <br>
                - Cliquez sur gestion BDD<br>
                - Cr&eacute;ez une base de donn&eacute;es ( nommez cette base 
                comme vous souhaitez : gestclasse pour l'exemple )<br>
                - C'est tout ... le plus dure est fait : ouf !<br>
                - Le nom du serveur est : localhost<br>
                - Le nom de la base est : gestclasse<br>
                - Le login est : root <br>
                - Le mot de passe est : pas de mot de passe !</font></div></td>
            <td width="50%" bgcolor="#E0E0E0"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">- 
                Activez votre base de donn&eacute;es ... consultez votre h&eacute;bergeur 
                : il suffit de lire les instructions<br>
                - R&eacute;cup&eacute;rez les param&egrave;tres d'acc&egrave;s 
                &agrave; votre base de donn&eacute;es.</font></div></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<form name="form1" method="post" action="index.php?saisie=ok">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td> <p align="left"><font size="3" face="Arial, Helvetica, sans-serif"><img src="../images/config/lien.gif" width="19" height="9">Etape 
          5 </font><br>
          <font size="2" face="Arial, Helvetica, sans-serif">Saisissez les param&egrave;tres 
          de connexions ( Le fichier modifi&eacute; est commun/connect.php )</font></p></td>
    </tr>
    <tr> 
      <td> <div align="left"> 
          <table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
            <tr> 
              <td height="58" bgcolor="#FFFFFF"> 
                <div align="left"> 
                  <?
				  include ('../commun/connect.php');
				  if(!mysql_select_db($dbname,$id_link))
				  {
				  echo"
                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
                    <tr> 
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Nom 
                        du serveur :</font></td>
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> 
                        <input name=\"serveur\" type=\"text\" id=\"serveur\">
                        </font></td>
                    </tr>
                    <tr> 
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Nom 
                        de la base :</font></td>
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> 
                        <input name=\"base\" type=\"text\" id=\"base\">
                        </font></td>
                    </tr>
                    <tr> 
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Login 
                        :</font></td>
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> 
                        <input name=\"login\" type=\"text\" id=\"login\">
                        </font></td>
                    </tr>
                    <tr> 
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Mot 
                        de passe :</font></td>
                      <td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> 
                        <input name=\"passe\" type=\"text\" id=\"passe\">
                        </font></td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                      <td><input type=\"submit\" name=\"Submit\" value=\"Envoyer\"></td>
                    </tr>
                  </table>
				  <p><div align=\"center\"><font size=\"2\"face=\"Arial, Helvetica, sans-serif\">Tant que ce formulaire apparaît, l'installation de la base n'est pas réussie</font></div></p>
				  ";
				 }
				else
				{ 
				 echo "
				 <div align=\"center\"><p><font size=\"4\"face=\"Arial, Helvetica, sans-serif\">Connexion r&eacute;ussie</font></div></p>
				";
				$installation="ok";
				}
				  ?>
                  <p>&nbsp;</p>
                </div>
                </td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><div align="left"><font size="3" face="Arial, Helvetica, sans-serif"><img src="../images/config/lien.gif" width="19" height="9">Etape 
        6</font></div></td>
  </tr>
  <tr> 
    <td> <div align="left"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
          <tr> 
            <td bgcolor="#FFFFFF"> 
              <?
				$tables = mysql_list_tables ($dbname);
				$tables1 = mysql_list_tables ($dbname);
				$nb_tbl="0";
 				if(isset($installation) and $installation=="ok")
				{
							while($rang=mysql_fetch_array($tables))
							{
							if (substr($rang['0'],0,3)=="gc_") $nb_tbl++ ;
							} 
				if($nb_tbl=="17") 
				{
				echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\"> Tables installées avec succès</font></div>";
				echo "<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Les tables installées sont : </font></div><br>";	
					while($rang1=mysql_fetch_array($tables1))
					{
					if (substr($rang1['0'],0,3)=="gc_")
					echo " <font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> $rang1[0]</font><br>";
					}
				}
				else
				echo"<div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Installlez 
                les tables <a href=\"tables.php\">en cliquant ici</a></font></div>";
				}
				else 
				echo"<div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Installlez 
                les tables ... cette opération n'est possible que si l'étape 5 est réalisée</font></div>";
			?>
            </td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="left"><font size="3" face="Arial, Helvetica, sans-serif"><img src="../images/config/lien.gif" width="19" height="9">Etape 
        7 </font></div></td>
  </tr>
  <tr> 
    <td> <div align="left"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCCC">
          <tr> 
            <td bgcolor="#FFFFFF"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">C'est 
                fini : vous pouvez utiliser <a href="../index.php">Gest'classe</a></font><font size="2" face="Arial, Helvetica, sans-serif"></font> 
              </div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><font size="2" face="Arial, Helvetica, sans-serif">Lors de la premi&egrave;re 
  utilisation, il n'y a ni login, ni mot de passe pour entrer dans l'espace prof 
  ... n'oubliez pas de prot&eacute;ger l'acc&egrave;s &agrave; l'espace prof !!!</font></p>
