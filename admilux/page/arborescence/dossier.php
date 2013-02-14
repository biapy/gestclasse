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
session_start();


if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}

?>
<p><img src="../../../images/config/logogestclasse.gif" width="110" height="25" align="absmiddle"></p>

<?


include("fonct_rep.php");
include("../../../commun/fonction.php");

//global $indice ;
?>


	 <style>
#foldheader {CURSOR: hand; FONT-WEIGHT: 300; LIST-STYLE-IMAGE: url(fold.gif); FONT-VARIANT: normal; FONT-SIZE: x-small}
#foldinglist{list-style-image:url(list.gif)}
	</style>
<script language="JavaScript">
var jav_combo
var head="display:''"
img1=new Image()
img1.src="fold.gif"
img2=new Image()
img2.src="open.gif"

function change(){
   if(!document.all)
      return
   if (event.srcElement.id=="foldheader") {
      var srcIndex = event.srcElement.sourceIndex
      var nested = document.all[srcIndex+1]
      if (nested.style.display=="none") {
         nested.style.display=''
         event.srcElement.style.listStyleImage="url(open.gif)"
      }
      else {
         nested.style.display="none"
         event.srcElement.style.listStyleImage="url(fold.gif)"
      }
   }
} 
document.onclick=change;
</script>	

  

<link href="../../../commun/style.css" rel="stylesheet" type="text/css">
<UL STYLE="margin-left: 1em">
<!-- premier decalage  -->
<?
echo "<font size=\"3\" face=\"Arial, Helvetica, sans-serif\" ><LI ID='foldheader'> documents</li></font>";
?><ul STYLE="margin-left: 1em" id="foldinglist" style="display:none" style=&{head};> 
<?
//******************************************************************************
$indice = 0 ;
$documents = "../../../documents/" ;
$chemin0 = $documents ;
niv_0($chemin0) 
?>
<p>
  <SCRIPT LANGUAGE="javascript">
jav_combo ="<?echo"$le_combo"?>";
parent.jav_combo = jav_combo;
</SCRIPT>
</p>
<div align="left">
  <p>&nbsp;</p>
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class="bordure">
    <tr>
      <td bordercolor="#000066"> 
        <div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><a href="dossier.php"><font size="1">Actualiser</font></a></font></div></td>
    </tr>
  </table>
  
</div>
