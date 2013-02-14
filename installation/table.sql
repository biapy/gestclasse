##
## Réalisé avec gest'classe 
## http://gestclasse.free.fr 
## luxpierre@hotmail.com 
## Date : February 3, 2008, 1:45 pm
## Base : luxpierre 
## -------------------------

DROP TABLE IF EXISTS gc_agenda;
CREATE TABLE gc_agenda (
   id_agenda int(10) unsigned NOT NULL auto_increment,
   date int(11),
   type varchar(100) NOT NULL,
   commentaire text NOT NULL,
   site varchar(30) NOT NULL,
   PRIMARY KEY (id_agenda)
);

DROP TABLE IF EXISTS gc_bloc_notes;
CREATE TABLE gc_bloc_notes (
   id_bloc int(10) unsigned NOT NULL auto_increment,
   classe varchar(30) NOT NULL,
   contenu text NOT NULL,
   date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   type varchar(200) NOT NULL,
   PRIMARY KEY (id_bloc)
);

DROP TABLE IF EXISTS gc_cahier_texte;
CREATE TABLE gc_cahier_texte (
   id_com_classe int(10) unsigned NOT NULL auto_increment,
   id_jour int(11) NOT NULL,
   classe varchar(30) NOT NULL,
   commentaire text NOT NULL,
   type varchar(100) NOT NULL,
   pour varchar(100) NOT NULL,
   jour varchar(100) NOT NULL,
   archive tinyint(4) NOT NULL,
   PRIMARY KEY (id_com_classe)
);

DROP TABLE IF EXISTS gc_classe;
CREATE TABLE gc_classe (
   id_classe tinyint(3) unsigned NOT NULL auto_increment,
   classe varchar(30) NOT NULL,
   PRIMARY KEY (id_classe)
);

DROP TABLE IF EXISTS gc_config;
CREATE TABLE gc_config (
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
);

INSERT INTO gc_config VALUES('1','luxpierre@hotmail.com','03/02/2008',' <p align=\"center\"><br> <font size=\"6\" face=\"Arial, Helvetica, sans-serif\">Installation réussie</font></p>\r\n<div align=\"center\">\r\n  <p> </p>\r\n  <p><img src=\"images/gestclasse_accueil.gif\" ></p>\r\n</div>\r\n            \r\n<p align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">Entrez dans l\'espace \r\n  prof pour construire votre site<br><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Cliquez sur ok ... n\'oubliez pas de choisir un login et un mot de passe une fois que vous serez entré dans l\'espace prof<font color=\"#FF3300\"> </font></font></p> \r\n           ','','','<div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><br> Gest\'classe : Logiciel (php/Mysql) destiné aux enseignants<br>\r\n  Copyright (c) 2003-2005 by Lux Pierre (luxpierre@hotmail.com , http://gestclasse.free.fr)<br>\r\n  This program is free software. You can redistribute it and/or modify it under \r\n  the terms of the GNU General Public License as published by the Free Software \r\n  Foundation. <br>\r\n  <br>\r\n  </font></div>','f4F4F4','6699CC','000033','ffffff','000033','ffffff','FFEBD7','6699CC','ffffff','f4F4F4');


DROP TABLE IF EXISTS gc_connexion;
CREATE TABLE gc_connexion (
   id_connexion int(10) unsigned NOT NULL auto_increment,
   id_eleve int(11) NOT NULL,
   date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (id_connexion)
);

DROP TABLE IF EXISTS gc_contenu_auto;
CREATE TABLE gc_contenu_auto (
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
);

DROP TABLE IF EXISTS gc_contenu_page;
CREATE TABLE gc_contenu_page (
   id_contenu int(10) unsigned NOT NULL auto_increment,
   haut text NOT NULL,
   bas text NOT NULL,
   id_page int(11) NOT NULL,
   PRIMARY KEY (id_contenu)
);

DROP TABLE IF EXISTS gc_devoir;
CREATE TABLE gc_devoir (
   id_devoir int(10) unsigned NOT NULL auto_increment,
   nom varchar(20) NOT NULL,
   classe varchar(30) NOT NULL,
   duree varchar(20) NOT NULL,
   trim varchar(10) NOT NULL,
   coef decimal(4,2) unsigned NOT NULL default '1.00',
   type varchar(10) NOT NULL,
   date varchar(20) NOT NULL,
   commentaire text NOT NULL,
   PRIMARY KEY (id_devoir)
);

DROP TABLE IF EXISTS gc_division_page;
CREATE TABLE gc_division_page (
   id_division int(10) unsigned NOT NULL auto_increment,
   nom_division varchar(200) NOT NULL,
   id_page int(4) NOT NULL,
   ordre tinyint(4) NOT NULL,
   contenu text NOT NULL,
   PRIMARY KEY (id_division)
);

DROP TABLE IF EXISTS gc_eleve;
CREATE TABLE gc_eleve (
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
);

DROP TABLE IF EXISTS gc_lien;
CREATE TABLE gc_lien (
   id_lien tinyint(4) NOT NULL auto_increment,
   nom varchar(100) NOT NULL,
   url varchar(100) NOT NULL,
   descriptif text NOT NULL,
   ordre tinyint(4) NOT NULL,
   id_division int(11) NOT NULL,
   PRIMARY KEY (id_lien)
);

DROP TABLE IF EXISTS gc_modification;
CREATE TABLE gc_modification (
   id_modification int(10) unsigned NOT NULL auto_increment,
   id_eleve int(11) NOT NULL,
   date timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (id_modification)
);

DROP TABLE IF EXISTS gc_notes;
CREATE TABLE gc_notes (
   id_notes int(10) unsigned NOT NULL auto_increment,
   id_devoir int(10) unsigned NOT NULL,
   id_eleve smallint(5) unsigned NOT NULL,
   note double unsigned NOT NULL,
   com_note varchar(200) NOT NULL,
   PRIMARY KEY (id_notes)
);

DROP TABLE IF EXISTS gc_page;
CREATE TABLE gc_page (
   id_page tinyint(3) unsigned NOT NULL auto_increment,
   titre varchar(100) NOT NULL,
   sous_titre_de tinyint(3) unsigned NOT NULL,
   ordre tinyint(4) NOT NULL,
   classe varchar(30) NOT NULL default 'aucune restriction',
   PRIMARY KEY (id_page)
);

DROP TABLE IF EXISTS gc_restriction;
CREATE TABLE gc_restriction (
   id_restriction tinyint(4) NOT NULL auto_increment,
   nom varchar(100) NOT NULL,
   etat varchar(20) NOT NULL,
   PRIMARY KEY (id_restriction)
);

INSERT INTO gc_restriction VALUES('1','plan','on');
INSERT INTO gc_restriction VALUES('2','lien','on');
INSERT INTO gc_restriction VALUES('3','agenda','on');
INSERT INTO gc_restriction VALUES('4','cahier','commun');
INSERT INTO gc_restriction VALUES('5','mail','on');
INSERT INTO gc_restriction VALUES('6','fiche','off');
INSERT INTO gc_restriction VALUES('7','notes','on');
INSERT INTO gc_restriction VALUES('8','trombi','on');

DROP TABLE IF EXISTS gc_vacances;
CREATE TABLE gc_vacances (
   id_vacances int(10) unsigned NOT NULL auto_increment,
   debut_vacances int(11) NOT NULL,
   fin_vacances int(11) NOT NULL,
   PRIMARY KEY (id_vacances)
);

