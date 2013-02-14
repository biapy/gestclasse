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


include ("../commun/connect.php"); 


# 1
# Structure de la table `gc_agenda`
#

$sql="CREATE TABLE gc_agenda (
   id_agenda int(10) unsigned NOT NULL auto_increment,
   date int(11),
   type varchar(100) NOT NULL,
   commentaire text NOT NULL,
   site varchar(30) NOT NULL,
   PRIMARY KEY (id_agenda)
)";

mysql_db_query($dbname,$sql,$id_link);

# 2
# Structure de la table `gc_bloc_notes`
#

$sql="CREATE TABLE gc_bloc_notes (
   id_bloc int(10) unsigned NOT NULL auto_increment,
   classe varchar(30) NOT NULL,
   contenu text NOT NULL,
   date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   type varchar(200) NOT NULL,
   PRIMARY KEY (id_bloc)
)";
mysql_db_query($dbname,$sql,$id_link);



# 3
# Structure de la table `gc_cahier_texte`
#


$sql="CREATE TABLE gc_cahier_texte (
   id_com_classe int(10) unsigned NOT NULL auto_increment,
   id_jour int(11) NOT NULL,
   classe varchar(30) NOT NULL,
   commentaire text NOT NULL,
   type varchar(100) NOT NULL,
   pour varchar(100) NOT NULL,
   jour varchar(100) NOT NULL,
   archive tinyint(4) NOT NULL,
   PRIMARY KEY (id_com_classe)
)";
mysql_db_query($dbname,$sql,$id_link);



# 4
# Structure de la table `gc_classe`
#


$sql="CREATE TABLE gc_classe (
   id_classe tinyint(3) unsigned NOT NULL auto_increment,
   classe varchar(30) NOT NULL,
   PRIMARY KEY (id_classe)
)
";
mysql_db_query($dbname,$sql,$id_link);


# 5
# Structure de la table `gc_config`
#


$sql="CREATE TABLE gc_config (
   id_config tinyint(4) NOT NULL auto_increment,
   mail varchar(100) NOT NULL,
   maj varchar(100) NOT NULL,
   contenu text NOT NULL,
   gauche text NOT NULL,
   droite text NOT NULL,
   bas_page text NOT NULL,
   couleur1 varchar(40) NOT NULL,
   couleur2 varchar(10) NOT NULL,
   couleur3 varchar(40) NOT NULL,
   fond varchar(40) NOT NULL,
   couleur4 varchar(10) NOT NULL,
   couleur5 varchar(40) NOT NULL,
   couleur6 varchar(40) NOT NULL,
   couleur7 varchar(40) NOT NULL,
   couleur8 varchar(40) NOT NULL,
   fond_haut_page varchar(40) NOT NULL,
   PRIMARY KEY (id_config)
)";
mysql_db_query($dbname,$sql,$id_link);

# Contenu de la table `gc_config`


$sql="INSERT INTO gc_config VALUES (1, 'luxpierre@hotmail.com', '25/01/2008', ' <p align=\"center\"><br> <font size=\"6\" face=\"Arial, Helvetica, sans-serif\">Installation réussie</font></p>\r\n<div align=\"center\">\r\n  <p> </p>\r\n  <p><img src=\"images/gestclasse_accueil.gif\" ></p>\r\n</div>\r\n            \r\n<p align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">Entrez dans l\'espace \r\n  prof pour construire votre site<br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Cliquez sur ok ... n\'oubliez pas de choisir un login et un mot de passe une fois que vous serez entré dans l\'espace prof<font color=\"#FF3300\"> </font></font></p> \r\n           ', '', '', '<div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><br> Gest\'classe : Logiciel (php/Mysql) destiné aux enseignants<br>\r\n  Copyright (c) 2003-2008 by Lux Pierre (luxpierre@hotmail.com , http://gestclasse.free.fr)<br>\r\n  This program is free software. You can redistribute it and/or modify it under \r\n  the terms of the GNU General Public License as published by the Free Software \r\n  Foundation. <br>\r\n  <br>\r\n  </font></div>', 'f4F4F4', '6699CC', '000033', 'ffffff', '000033', 'ffffff', 'FFEBD7', '6699CC', 'ffffff', 'f4F4F4')";
mysql_db_query($dbname,$sql,$id_link);

# 6
# Structure de la table `gc_connexion`
#

$sql="CREATE TABLE gc_connexion (
   id_connexion int(10) unsigned NOT NULL auto_increment,
   id_eleve int(11) NOT NULL,
   date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (id_connexion)
)";
mysql_db_query($dbname,$sql,$id_link);

# 7
# Structure de la table `gc_contenu_auto`
#

$sql="CREATE TABLE gc_contenu_auto (
   id_auto int(10) unsigned NOT NULL auto_increment,
   nom varchar(100) NOT NULL,
   url varchar(200) NOT NULL,
   contenu text NOT NULL,
   ordre int(11) NOT NULL,
   type varchar(100) NOT NULL,
   accueil tinyint(4) NOT NULL,
   id_division int(11) NOT NULL,
   sans_division tinyint(4) NOT NULL,
   PRIMARY KEY (id_auto)
)";
mysql_db_query($dbname,$sql,$id_link);



# 8
# Structure de la table `gc_contenu_page`
#


$sql="CREATE TABLE gc_contenu_page (
   id_contenu int(10) unsigned NOT NULL auto_increment,
   haut text NOT NULL,
   bas text NOT NULL,
   id_page int(11) NOT NULL,
   PRIMARY KEY (id_contenu)
)";
mysql_db_query($dbname,$sql,$id_link);



# 9
# Structure de la table `gc_devoir`
#

$sql="CREATE TABLE gc_devoir (
   id_devoir tinyint(3) unsigned NOT NULL auto_increment,
   nom varchar(20) NOT NULL,
   classe varchar(30) NOT NULL,
   duree varchar(20) NOT NULL,
   trim varchar(10) NOT NULL,
   coef decimal(4,2) unsigned NOT NULL default '1.00',
   type varchar(10) NOT NULL,
   date varchar(20) NOT NULL,
   commentaire text NOT NULL,
   PRIMARY KEY (id_devoir)
)";
mysql_db_query($dbname,$sql,$id_link);



# 10
# Structure de la table `gc_division_page`
#

$sql="CREATE TABLE gc_division_page(
   id_division int(10) unsigned NOT NULL auto_increment,
   nom_division varchar(200) NOT NULL,
   id_page int(4) NOT NULL,
   ordre tinyint(4) NOT NULL,
   contenu text NOT NULL,
   PRIMARY KEY (id_division)
)";
mysql_db_query($dbname,$sql,$id_link);



# 11
# Structure de la table `gc_eleve`
#

$sql="CREATE TABLE gc_eleve (
   id_eleve smallint(5) unsigned NOT NULL auto_increment,
   login varchar(20) NOT NULL,
   passe varchar(20) NOT NULL,
   classe varchar(30) NOT NULL,
   maj_eleve timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   nom varchar(40) NOT NULL,
   prenom varchar(40) NOT NULL,
   naissance varchar(40) NOT NULL,
   adresse text NOT NULL,
   tel varchar(200) NOT NULL,
   prof_pere text NOT NULL,
   prof_mere text NOT NULL,
   classe_red varchar(100) NOT NULL,
   moy_avant varchar(200) NOT NULL,
   com_eleve text NOT NULL,
   com_prof text NOT NULL,
   trim1 float(3,1) unsigned NOT NULL default '0.0',
   trim2 float(3,1) unsigned NOT NULL default '0.0',
   trim3 float(3,1) unsigned NOT NULL default '0.0',
   trim4 float(3,1) unsigned NOT NULL default '0.0',
   appreciation text NOT NULL,
   PRIMARY KEY (id_eleve)
)";
mysql_db_query($dbname,$sql,$id_link);



# 12
# Structure de la table `gc_lien`
#

$sql="CREATE TABLE gc_lien (
   id_lien tinyint(4) NOT NULL auto_increment,
   nom varchar(100) NOT NULL,
   url varchar(100) NOT NULL,
   descriptif text NOT NULL,
   ordre tinyint(4) NOT NULL,
   id_division int(11) NOT NULL,
   PRIMARY KEY (id_lien)
)";
mysql_db_query($dbname,$sql,$id_link);

# 13
# Structure de la table `gc_modification`
#

$sql="CREATE TABLE gc_modification (
   id_modification int(10) unsigned NOT NULL auto_increment,
   id_eleve int(11) NOT NULL,
   date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (id_modification)
)";
mysql_db_query($dbname,$sql,$id_link);



# 14
# Structure de la table `gc_notes`
#

$sql="CREATE TABLE gc_notes (
   id_notes int(10) unsigned NOT NULL auto_increment,
   id_devoir int(10) unsigned NOT NULL,
   id_eleve smallint(5) unsigned NOT NULL,
   note double unsigned NOT NULL,
   com_note varchar(200) NOT NULL,
   PRIMARY KEY (id_notes)
)";
mysql_db_query($dbname,$sql,$id_link);

# 15
# Structure de la table `gc_page`
#

$sql="CREATE TABLE gc_page(
   id_page tinyint(3) unsigned NOT NULL auto_increment,
   titre varchar(100) NOT NULL,
   sous_titre_de tinyint(3) unsigned NOT NULL,
   ordre tinyint(4) NOT NULL,
   classe varchar(30) NOT NULL default 'aucune restriction',
   PRIMARY KEY (id_page)
)";
mysql_db_query($dbname,$sql,$id_link);

# 16
# Structure de la table `gc_restriction`
#


$sql="CREATE TABLE gc_restriction (
   id_restriction tinyint(4) NOT NULL auto_increment,
   nom varchar(100) NOT NULL,
   etat varchar(20) NOT NULL,
   PRIMARY KEY (id_restriction)
)";

mysql_db_query($dbname,$sql,$id_link);


# contenu de la table `gc_restriction`


$sql="INSERT INTO gc_restriction VALUES('1','plan','on')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('2','lien','on')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('3','agenda','on')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('4','cahier','commun')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('5','mail','on')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('6','fiche','off')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('7','notes','on')";
mysql_db_query($dbname,$sql,$id_link);
$sql="INSERT INTO gc_restriction VALUES('8','trombi','on')";
mysql_db_query($dbname,$sql,$id_link);

# 17
# Structure de la table `gc_vacances`
#


$sql="CREATE TABLE gc_vacances (
   id_vacances int(10) unsigned NOT NULL auto_increment,
   debut_vacances int(11) NOT NULL,
   fin_vacances int(11) NOT NULL,
   PRIMARY KEY (id_vacances)
)";

mysql_db_query($dbname,$sql,$id_link);

header('location:index.php'); 

?>
    