<?
################################################################################
##                      -=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-                    ##
##                               Gest'classe_v7_plus                          ##    
##Ce fichier est réalisé à partir du code de Perrich (perrich@netsolution.fr) ##                                
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

// protection de la page
if (!isset($_SESSION['admilogin']) or !isset($_SESSION['admipasse']))
{
echo "<div align=\"center\"><font size=\"4\" face=\"Arial, Helvetica, sans-serif\">acc&egrave;s interdit</font></div>";
exit;
}


titre_page("Exécuter des requêtes sur la base ");
?> <br><br> 
<table width="620" border="0" align="center" cellpadding="0" cellspacing="0" class="bordure">
  <tr> 
    <td>
<p align="center">&nbsp;</p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>S&eacute;lectionner 
        le fichier sql<br>
        </strong><font size="1">Cette rubrique permet par exemple de restaurer 
        les tables &agrave; partir du fichier sql de sauvegarde</font><strong><br>
        </strong></font></p>
      <form action="admi.php?page_admi=restaurer" method="post" enctype="multipart/form-data" name="form1">
        <div align="center"> 
          <p>&nbsp;</p>
          <p> 
            <input type="file" name="file">
          </p>
          <p> 
            <input type="submit" name="Submit" value="Ex&eacute;cuter">
          </p>
        </div>
      </form>


<? 

if (isset($_FILES['file']) and $_FILES['file']['tmp_name']<>'') 
{
mysql_select_db( $dbname, $id_link );

$sql_file = $_FILES['file']['tmp_name'];

set_time_limit(0);

function split_sql($sql) { 

  $sql = trim($sql); 
  $sql = ereg_replace("\n#[^\n]*\n", "", $sql); 
  $buffer = array(); 
  $ret = array(); 
  $in_string = false; 

  for( $i = 0; $i < strlen( $sql ) - 1; $i++) { 
    if ( $in_string ) { 
      if ( ( $sql[$i] == $in_string ) && ( $buffer[1] != "\\" ) )
        $in_string = false; 
    } else { 
      if ( $sql[$i] == ";" ) { 
        $ret[] = substr( $sql, 0, $i ); 
        $sql = substr( $sql, $i + 1 ); 
        $i = 0; 
      } 
      if ( ( $sql[$i] == "\"" || $sql[$i] == "'" ) && 
           ( !isset($buffer[1] ) || $buffer[1] != "\\" ) ) $in_string = $sql[$i]; 
    } 
    $buffer[1] = $sql[$i]; // caractère precédent 
  }

  if ( !empty( $sql ) ) $ret[] = $sql;

  return($ret); 

} 

if ( isset( $sql_file ) )
 { 
  $sql_query = fread( fopen( $sql_file, "r" ), filesize( $sql_file )); 
  $pieces = split_sql( $sql_query ); 
  for ( $i = 0; $i < count( $pieces ); $i++ ) { 
    $pieces[$i] = trim( $pieces[$i] ); 
    if ( !empty( $pieces[$i] ) && $pieces[$i] != "#" ) 
      $result = mysql_query( $pieces[$i], $id_link ) 
                or die( 'erreur ligne '.($i+1).' &nsbp; '.$pieces[$i].'<br>' ); 
  } 
 
}
  message('Ex&eacute;cution r&eacute;ussie</font>');  
}
?>
	</td>
  </tr>
</table>
