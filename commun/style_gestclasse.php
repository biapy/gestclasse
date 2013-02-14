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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>les styles de Gest'classe</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="bordure">
  <tr>
    <td valign="top" bgcolor="#FEF9E2"> 
      <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100"><font size="5" face="Arial, Helvetica, sans-serif"><img src="../images/config/message.gif" width="66" height="16"></font></td>
          <td><div align="center"><font size="5" face="Arial, Helvetica, sans-serif">Les 
              styles de Gest'classe </font></div></td>
        </tr>
      </table>
      <p><font size="2" face="Arial, Helvetica, sans-serif"><em>Gest'classe autorise 
        l'utilisation de l'html dans les formulaires de l'espace professeur, mais 
        pour simplifier l'utilisation et pour aider les personnes ne connaissant 
        pas l'html voici quelques styles propre &agrave; Gest'classe :</em></font></p>
      <hr>
      <ul>
        <li><font color="#FF0000" face="Arial, Helvetica, sans-serif">gclien:</font><font face="Arial, Helvetica, sans-serif">le 
          lien <font color="#FF0000">gcnom:<font color="#000000">le nom</font>/lien 
          </font></font><font color="#FF0000" face="Arial, Helvetica, sans-serif"><br>
          <font color="#000000" size="1">Exemple :</font><font size="1"><br>
          gclien:</font></font><font size="1" face="Arial, Helvetica, sans-serif"> 
          http://gestclasse.free.fr <font color="#FF0000">gcnom:</font>gest'classe<font color="#FF0000">/lien 
          <font color="#000000">pour afficher : <a href="http://gestclasse.free.fr" target="_blank">gest'classe</a><br>
          </font></font></font></li>
        <li><font color="#FF0000" face="Arial, Helvetica, sans-serif">gclien,taille:</font><font face="Arial, Helvetica, sans-serif">le 
          lien <font color="#FF0000">gcnom:<font color="#000000">le nom</font>/lien 
          </font></font><br>
          <font size="2" face="Arial, Helvetica, sans-serif">taille :<font color="#FF0000"><font color="#000000"><font color="#FF0000"><font color="#000000">1 
          &agrave; 6 pour </font></font>la taille de la police.</font></font></font><br>
          <font color="#FF0000" face="Arial, Helvetica, sans-serif"><font color="#000000" size="1">Exemple 
          :</font></font><font size="1"><br>
          <font color="#FF0000" face="Arial, Helvetica, sans-serif">gclien,5:</font></font><font size="1" face="Arial, Helvetica, sans-serif"> 
          http://gestclasse.free.fr <font color="#FF0000">gcnom:</font>gest'classe<font color="#FF0000">/lien 
          <font color="#000000">pour afficher :</font></font></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"> 
          <a href="http://gestclasse.free.fr" target="_blank"><font size="5">gest'classe</font></a><br>
          <font size="2"><strong>Attention :</strong> il faut biens&ucirc;r &eacute;viter 
          d'utiliser &quot;/lien&quot; dans le chemin d'un lien ...</font><br>
          </font></font></font></li>
        <li><font color="#FF0000" face="Arial, Helvetica, sans-serif">/gc :</font><font color="#000000" face="Arial, Helvetica, sans-serif"> 
          pour aller &agrave; la ligne<br>
          </font></li>
        <li><font color="#FF0000" face="Arial, Helvetica, sans-serif">gctexte,couleur,taille,format:</font><font face="Arial, Helvetica, sans-serif"> 
          votre texte <font color="#FF0000">/texte</font><br>
          <font size="2">Couleur : - pour pour la couleur normale, r pour rouge, 
          v pour vert et b pour bleu<br>
          Taille : <font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"> 
          - pour la taille normale </font></font></font>. <font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000">1 
          &agrave; 6 pour </font></font></font>la taille de la police.<br>
          Format : - pour le format normal, i pour italique, g pour gras</font></font></font></font><br>
          <font color="#FF0000" face="Arial, Helvetica, sans-serif"><font color="#000000" size="1">Exemple 
          :</font><font color="#000000"><br>
          </font></font><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">gctexte,b,2,i:</font><font size="1" face="Arial, Helvetica, sans-serif"> 
          texte bleu, taille 2 en italique<font color="#FF0000">/texte<font color="#000000"> 
          pour afficher :</font></font></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"> 
          <em><font color="#0000FF" size="2">texte bleu, taille 5 en italique<br>
          </font></em><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">gctexte,v,1,g:</font><font size="1" face="Arial, Helvetica, sans-serif"> 
          texte vert, taille 1 en gras<font color="#FF0000">/texte<font color="#000000"> 
          pour afficher :</font></font></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"> 
          <font color="#00FF00" size="1"><strong>texte vert, taille 1 en gras<br>
          </strong></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">gctexte,-,-,i:</font><font size="1" face="Arial, Helvetica, sans-serif"> 
          texte en italique<font color="#FF0000">/texte<font color="#000000"> 
          pour afficher :</font></font></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"> 
          <font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font size="1" face="Arial, Helvetica, sans-serif"><em>texte 
          en italique</em></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><em><font color="#00FF00" size="1"><strong> 
          <br>
          </strong></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">gctexte,-,4,-:</font><font size="1" face="Arial, Helvetica, sans-serif"> 
          taille 4<font color="#FF0000">/texte<font color="#000000"> pour afficher 
          :</font></font></font><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"> 
          <font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font face="Arial, Helvetica, sans-serif"><font color="#FF0000"><font color="#000000"><font size="4" face="Arial, Helvetica, sans-serif"><em>taille 
          4 </em></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></em></font></font></font></font></font></font></li>
      </ul>
      </td>
  </tr>
</table>
<p align="center">&nbsp;</p>
</body>
</html>
