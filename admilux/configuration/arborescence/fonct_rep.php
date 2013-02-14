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
echo"<a href=\"action.php?dossier=$chemin0\"target=\"droite\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" > Sélectionner</font> <a>";
 	
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
function niv_1($chemin1)
{
//echo" Niv1 :$indice";
global   $tab_rep ;
 $rep_1=@opendir($chemin1);
 echo"<a href=\"action.php?dossier=$chemin1\"target=\"droite\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" > Sélectionner</font> <a>";
 while($nomfichier_1=@readdir($rep_1))
		{
		if ($nomfichier_1 !="." && $nomfichier_1 !="..")// pour eviter le premier
		   {
			if(!is_file($chemin1."/".$nomfichier_1))
				{
				echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><li id='foldheader'>$nomfichier_1 </li></font>";
?>
<ul STYLE="margin-left: 1em" id="foldinglist" style="display:none" style=&{head};>
<?
$chemin2 = "$chemin1/$nomfichier_1";
$tab_rep[] = $chemin2 ;
niv_2($chemin2);
echo"</ul>";
				}
		   }
		}
@closedir($rep_1); 
//*******************************************************************************
$rep_1=@opendir($chemin1);
	 while($nomfichier_1=@readdir($rep_1))
		{
		if ($nomfichier_1 !="." && $nomfichier_1 !="..")// pour eviter le premier
		   {
		    if(is_file($chemin1."/". $nomfichier_1))
				{
				$chemin = $chemin1;
				$nomfichier = $nomfichier_1;
				tri($chemin,$nomfichier, $tab_rep);
				}
			}// de if ($nomfichier !="."  pour eviter le premier 
		}// de while($nomfichier */
@closedir($rep_1);
}
//*********************************************************************************
function niv_2($chemin2)
{
global  $tab_rep ;
$rep_2=@opendir($chemin2);
 echo"<a href=\"action.php?dossier=$chemin2\"target=\"droite\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" > Sélectionner</font> <a>";
 while($nomfichier_2=@readdir($rep_2))
		{
		if ($nomfichier_2 !="." && $nomfichier_2 !="..")// pour eviter le premier
		   {
		    if(!is_file($chemin2."/".$nomfichier_2))
				{
				echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><li id='foldheader'>$nomfichier_2 </li></font>";
?>
<ul STYLE="margin-left: 1em" id="foldinglist" style="display:none" style=&{head};>
<?
$chemin3 = "$chemin2/$nomfichier_2";
$tab_rep[] = $chemin3 ;
niv_3($chemin3);
echo"</ul>";
				}
		   }
		}
closedir($rep_2);
//**************************************************
$rep_2=@opendir($chemin2);
	 while($nomfichier_2=@readdir($rep_2))
		{
		if ($nomfichier_2 !="." && $nomfichier_2 !="..")// pour eviter le premier
		   {
		    if(is_file($chemin2."/". $nomfichier_2))
				{
				$chemin = $chemin2;
				$nomfichier = $nomfichier_2;
				tri($chemin,$nomfichier, $tab_rep);				
				}
			}// de if ($nomfichier !="."  pour eviter le premier 
		}// de while($nomfichier */
closedir($rep_2);
}
//*********************************************************************************
function niv_3($chemin3)
{
global  $tab_rep ;
$rep_3=@opendir($chemin3);
 echo"<a href=\"action.php?dossier=$chemin3\"target=\"droite\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" > Sélectionner</font> <a>";
 while($nomfichier_3=@readdir($rep_3))
		{
		if ($nomfichier_3 !="." && $nomfichier_3 !="..")// pour eviter le premier
		   {
		    if(!is_file($chemin3."/".$nomfichier_3))
				{
				echo "<font size=\"1\" face=\"Arial, Helvetica, sans-serif\" ><li id='foldheader'>$nomfichier_3 </li></font>";
?>
<ul STYLE="margin-left: 1em" id="foldinglist" style="display:none" style=&{head};>
<?
$chemin4 = "$chemin3/$nomfichier_3";
$tab_rep[] = $chemin4 ;
niv_4($chemin4);
echo"</ul>";
				}
		   }
		}
closedir($rep_3);
//**************************************************
$rep_3=@opendir($chemin3);
 while($nomfichier_3=@readdir($rep_3))
		{
		if ($nomfichier_3 !="." && $nomfichier_3 !="..")// pour eviter le premier
		   {
		    if(is_file($chemin3."/". $nomfichier_3))
				{
				$chemin = $chemin3;
				$nomfichier = $nomfichier_3;
				tri($chemin,$nomfichier, $tab_rep);			
				}
			}// de if ($nomfichier !="."  pour eviter le premier 
		}// de while($nomfichier */
closedir($rep_3);
}
//*******************************************************************************

//********* trie des fichier par Type et constitution d'URL **********************
function tri($chemin,$nomfichier, $tab_rep)
{
global $le_combo,$tab_rep;
$le_combo = implode (":",$tab_rep);
//************************************************************

// affichage des fichiers
if($chemin =="../../../images/") $fichier=$chemin.$nomfichier;
else $fichier=$chemin."/".$nomfichier;
echo"<li><a href=\"action.php?fichier=$fichier\" target=\"droite\" ><font size=\"1\" face=\"Arial, Helvetica, sans-serif\" >$nomfichier</font></a></li>";

} 
?>
