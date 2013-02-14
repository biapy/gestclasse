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

// protection 



if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

function niv_0($chemin0)
{
global  $tab_rep ;
$tab_rep[]="../";
$rep_0=@opendir($chemin0);
 	
 		while($nomfichier=@readdir($rep_0))
		{
		if ($nomfichier !="." && $nomfichier !="..")// pour eviter le premier
		   {
			  if(!is_file($chemin0 . "/" . $nomfichier))
				{
				echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><li id='foldheader'>$nomfichier</li></font>";
?>
<ul STYLE="margin-left: 1em" id="foldinglist" style="display:none" style=&{head};>
<?
$chemin1 = "$chemin0$nomfichier";
$tab_rep[] = $chemin1;
niv_1($chemin1);
echo"</ul>";
				}
			}// de if ($nomfichier !="."  pour eviter le premier
		}// de while($nomfichier	
closedir($rep_0);
//--------------------------------------------		
$rep_0=@opendir($chemin0);
	while($nomfichier=@readdir($rep_0))
		{
		if ($nomfichier !="." && $nomfichier !="..")// pour eviter le premier
		   {
			  if(is_file($chemin0 . "/" . $nomfichier))
				{
				$chemin = $chemin0;
				tri($chemin,$nomfichier, $tab_rep);
				}
			}// de if ($nomfichier !="."  pour eviter le premier
		}// de while($nomfichier
closedir($rep_0); 
echo "</ul>";
}
//*********************************************************************************

//********* trie des fichier par Type et constitution d'URL **********************
function tri($chemin,$nomfichier, $tab_rep)
{
global $le_combo,$tab_rep;
$le_combo = implode (":",$tab_rep);
//************************************************************

// affichage des fichiers
$fichier=$chemin.$nomfichier;
if ( $fichier=='../../photo_classe/index.php') echo"<li><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >$nomfichier</font></li>";
else
echo"<li><a href=\"action.php?fichier=$fichier\" target=\"droite\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >$nomfichier</font></a></li>";

} 
?>
