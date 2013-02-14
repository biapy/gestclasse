<?
################################################################################
##                      -=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-                    ##
##                               Gest'classe_v7_plus                          ##   
## Ce fichier est réalisé à partir de XT-DUMP v 0.7 :  Mysql Dump System      ## 
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

titre_page('Sauvegarder les tables');



@set_time_limit(600);
$dbhost = $hostname;
$dbbase = $dbname;
$dbuser = $username;
$dbpass = $password;

if (isset($_POST['tbls'])) $tbls   = $_POST['tbls'];
if (isset($_POST['action'])) $action   = $_POST['action'];
if (isset($_POST['secu'])) $secu   = $_POST['secu'];
if (isset($_POST['f_cut'])) $f_cut   = $_POST['f_cut'];
if (isset($_POST['fz_max'])) $fz_max   = $_POST['fz_max'];
if (isset($_POST['opt'])) $opt   = $_POST['opt'];
if (isset($_POST['savmode'])) $savmode   = $_POST['savmode'];
if (isset($_POST['file_type'])) $file_type   = $_POST['file_type'];
if (isset($_POST['ecraz'])) $ecraz   = $_POST['ecraz'];
if (isset($_POST['f_tbl'])) $f_tbl   = $_POST['f_tbl'];
if (isset($_POST['drp_tbl'])) $drp_tbl = $_POST['drp_tbl'];



/* Fonction retournant la date et l'heure actuelle - Actualy time function */

function aff_date()
{
	$date_now = date("F j, Y, g:i a");
	return $date_now;
}

/* Fonction de sauvegarde en mode Sql - Sql data dump function */

function sqldumptable($table)
{
	global $sv_s,$sv_d,$drp_tbl;
	
	if ($sv_s)
	{
		if ($drp_tbl)
		{
			$tabledump = "DROP TABLE IF EXISTS $table;\n";
		}
		$tabledump .= "CREATE TABLE $table (\n";
		
		$firstfield=1;
		
		$champs = mysql_query("SHOW FIELDS FROM $table");
		
		while ($champ = mysql_fetch_array($champs))
		{
			if (!$firstfield)
			{
				$tabledump .= ",\n";
			}
			else
			{
				$firstfield=0;
			}
			
			$tabledump .= "   $champ[Field] $champ[Type]";
			
			if ($champ['Null'] != "YES")
			{
				$tabledump .= " NOT NULL";
			}
// modification effectuée le 27 avril 2008 : pb pour l'exportation des champs de type timestamp résolu 			
			if (!empty($champ['Default']))
			{
				if ($champ['Default']=="CURRENT_TIMESTAMP")
				{
					$tabledump .= " default $champ[Default]";
				}
				else
				{
					$tabledump .= " default '$champ[Default]'";
				}
			}
			
			if ($champ['Extra'] != "")
			{
				$tabledump .= " $champ[Extra]";
			}
		}
		
		@mysql_free_result($champs);
		
		$keys = mysql_query("SHOW KEYS FROM $table");
		
		while ($key = mysql_fetch_array($keys))
		{
			$kname=$key['Key_name'];
			if ($kname != "PRIMARY" and $key['Non_unique'] == 0)
			{
				$kname="UNIQUE|$kname";
			}
			if(isset($index[$kname]) and !is_array($index[$kname]))
			{
				$index[$kname] = array();
			}
			$index[$kname][] = $key['Column_name'];
		}
		
		@mysql_free_result($keys);
		
		while(list($kname, $columns) = @each($index))
		{
			$tabledump .= ",\n";
			$colnames=implode($columns,",");
			
			if($kname == "PRIMARY")
			{
				$tabledump .= "   PRIMARY KEY ($colnames)";
			}
			else
			{
				if (substr($kname,0,6) == "UNIQUE")
				{
					$kname=substr($kname,7);
				}
			
				$tabledump .= "   KEY $kname ($colnames)";
			
			}
		}
	
		$tabledump .= "\n);\n\n";
	}
	
	
	// Données - Data
	
	if ($sv_d)
	{
		$rows = mysql_query("SELECT * FROM $table");
		$numfields = mysql_num_fields($rows);
	
		while ($row = mysql_fetch_array($rows))
		{
			if (isset($tabledump)) $tabledump .= "INSERT INTO $table VALUES(";
			else $tabledump = "INSERT INTO $table VALUES(";
		
			$cptchamp=-1;
			$firstfield=1;

			while (++$cptchamp<$numfields)
			{
				if (!$firstfield)
				{
				if (isset($tabledump))	$tabledump.=",";
				} 
				else
				{
					$firstfield=0;
				}
		
				if (!isset($row[$cptchamp]))
				{
					$tabledump .= "NULL";
				}
				else
				{
				if (isset($tabledump))	$tabledump .= "'".mysql_escape_string($row[$cptchamp])."'";
				}
			}
		
			if (isset($tabledump)) $tabledump .= ");\n";
		}
		
		@mysql_free_result($rows);
	}
	if (isset($tabledump)) return $tabledump;
}

/* Fonction de sauvegarde en mode CSV - CSV data dump function */

function csvdumptable($table)
{
	global $sv_s,$sv_d;
	
	$csvdump =  "## Table : $table \n\n";
	
	if ($sv_s)
	{
		$firstfield=1;
		$champs = mysql_query("SHOW FIELDS FROM $table");
		while ($champ = mysql_fetch_array($champs))
		{
			if (!$firstfield)
			{
				$csvdump.= ",";
			}
			else
			{
				$firstfield=0;
			}
			$csvdump.= "'" . $champ['Field'] . "'";
		}
		@mysql_free_result($champs);
		$csvdump.="\n";
	}
	
	
	// Données - Data
	if ($sv_d)
	{
		$rows = mysql_query("SELECT * FROM $table");
		$numfields=mysql_num_fields($rows);
		while ($row = mysql_fetch_array($rows))
		{
			$cptchamp=-1;
			$firstfield=1;
			while (++$cptchamp<$numfields)
			{
				if (!$firstfield)
				{
					$csvdump.=",";
				}
				else
				{
					$firstfield=0;
				}
				if (!isset($row[$cptchamp]))
				{
					$csvdump .= "NULL";
				}
				else
				{
					$csvdump .= "'" . addslashes($row[$cptchamp]) . "'";
				}
			}
			$csvdump .= "\n";
		}
	}
	@mysql_free_result($rows);
	return $csvdump;
}


/* Ecrire dans le fichier de sauvegarde - Write into the backup file */

function write_file($data)
{
	global $g_fp,$file_type;
	if ($file_type == 1)
	{
		gzwrite ($g_fp,$data);
	}
	else
	{
		fwrite ($g_fp,$data);
	}
}

/* Ouvrir le fichier de sauvegarde - Open the backup file */

function open_file($file_name)
{
	global $g_fp,$file_type,$dbbase,$f_nm;
	if ($file_type == 1)
	{
		$g_fp = gzopen($file_name,"wb9");
	}
	else
	{
		$g_fp = fopen ($file_name,"w");
	}
	$f_nm[] = $file_name;
	$data = "<? include('verif.php') ?>";
	$data .= "##\n";
	$data .= "## Réalisé avec gest'classe \n";
	$data .= "## http://gestclasse.free.fr \n";
	$data .= "## luxpierre@hotmail.com \n";
	$data .= "## Date : " . aff_date() . "\n";
	$data .= "## Base : $dbbase \n";
	$data .= "## -------------------------\n\n";

	write_file($data);
	unset($data);
}

/* Renvoie la taille actuelle du fichier */

function file_pos()
{
	global $g_fp,$file_type;
	
	if ($file_type == "1")
	{
		return gztell ($g_fp);
	}
	else
	{
		return ftell ($g_fp);
	}
}

/* Fermer le fichier de sauvegarde - Close the backup file */

function close_file()
{
	global $g_fp,$file_type;
	
	if ($file_type == "1")
	{
		gzclose ($g_fp);
	}
	else
	{
		fclose ($g_fp);
	}
}

/* ----------------------- */

function split_sql_file($sql)
{
	$morc = explode(";", $sql);

	$sql = "";
	$output = array();
	$matches = array();
	$morc_cpt = count($morc);
	for ($i = 0; $i < $morc_cpt; $i++)
	{
		if (($i != ($morc_cpt - 1)) || (strlen($morc[$i] > 0)))
		{
			$total_quotes = preg_match_all("/'/", $morc[$i], $matches);
			$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $morc[$i], $matches);
			$unescaped_quotes = $total_quotes - $escaped_quotes;
			
			if (($unescaped_quotes % 2) == 0)
			{
				$output[] = $morc[$i];
				$morc[$i] = "";
			}
			else
			{
				$temp = $morc[$i] . ";";
				$morc[$i] = "";
				$complete_stmt = false;
				
				for ($j = $i + 1; (!$complete_stmt && ($j < $morc_cpt)); $j++)
				{
					$total_quotes = preg_match_all("/'/", $morc[$j], $matches);
					$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $morc[$j], $matches);
			
					$unescaped_quotes = $total_quotes - $escaped_quotes;
					
					if (($unescaped_quotes % 2) == 1)
					{
						$output[] = $temp . $morc[$j];

						$morc[$j] = "";
						$temp = "";
						
						$complete_stmt = true;
						$i = $j;
					}
					else
					{
						$temp .= $morc[$j] . ";";
						$morc[$j] = "";
					}
					
				}
			}
		}
	}
	return $output;
}

function split_csv_file($csv)
{
	return explode("\n", $csv);
}

/* Header */

$header = "
<style>

.texte {
	font: 10pt;
	font-family: arial;
}



		  
#infobull {
	position: absolute;
	z-index: 1000;
	top: 0px;
	left: 0px;
	width: 200px;
}
DIV.infobullDIV {
	width: 200px;
	padding: 2px;
	background: yellow;
	border: 1px solid black;
	color: black;
	font-family: Arial,Helvetica;
	font-style: Normal;
	font-weight: Normal;
	font-size: 12px;
	line-height: 14px;
}
</style>

<center>
<br><br>
<table width=620 cellpadding=0 cellspacing=0 align=center class=bordure>
<col width=1>
<col width=600>
<col width=1>
	<tr>
		<td></td>
		<td align='center' style='font: bold 14px; font-family: verdana;'></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
	<td align=left class=texte>
				<br>";
	
	
	
/* Footer */ 

$footer = "
		</td>
		<td></td>
	</tr>
	<tr>
		<td height=1 colspan=3></td>
	</tr>
</table>
<br>
</center>
";

/* Mode Sauvegarde de la Base - Data Save Mode */

if ( isset($action) and $action=='save')
{

	if (isset($tbls) and !is_array($tbls))
	{
		echo $header . "<br><center><font color=red><b>Aucune Table n'a été sélectionnée pour la sauvegarde<br>Veuillez 'AU MOINS' en sélectionnez une :)</b></font></center>\n$footer";
		exit;
	}

	if(isset($f_cut) and $f_cut == 1)
	{
		if (!is_numeric($fz_max))
		{
			echo $header . "<br><center><font color=red><b>Veuillez choisir une valeur numérique à la taille du fichier à scinder.</b></font></center>\n$footer";
			exit;
		}
		if ($fz_max < 200000)
		{
			echo $header . "<br><center><font color=red><b>Veuillez choisir une taille de fichier a scinder supérieure à 200 000 Octets.</b></font></center>\n$footer";
			exit;
		}
	}
	
	/* Linearisation du tableau */
	
	$tbl = array();
	
	$tbl[] = reset($tbls);
	
	if (count($tbls) > 1)
	{
		$a = true;
		while ($a != false)
		{
			$a = next($tbls);
			if ($a != false)
			{
				$tbl[] = $a;
			}
		}
	}
	

	/* Gestion des Options de sauvegarde */
	
	if ($opt == 1)
	{
		$sv_s = true;
		$sv_d = true;
	}
	else if ($opt == 2)
	{
		$sv_s = true;
		$sv_d = false;
		$fc   = "_struct";
	}
	else if ($opt == 3)
	{
		$sv_s = false;
		$sv_d = true;
		$fc   = "_data";
	}
	else
	{
		exit;
	}

	
	$fext = "." . $savmode;
	if (isset($fc)) $fich = $dbbase . $fc . $fext;
	else $fich = $dbbase . $fext;
	
	/* Ecrazer ou non le fichier */
	
	$dte = "";
	if ($ecraz != 1)
	{
		$dte = date("dMy_Hi")."_";
	}
	
	$gz = ".php";
	if (isset($file_type) and $file_type == '1')
	{
		$gz .= ".gz";
	}
	
	$fcut = false;
	$ftbl = false;
	
	$f_nm = array();
	
	if(isset($f_cut) and $f_cut == 1)
	{
		$fcut = true;
		$fz_max = $fz_max;
		$nbf = 1;
		$f_size = 170;
	}
	if (isset($f_tbl) and $f_tbl == 1)
	{
		$ftbl = true;
	}
	else
	{
		if (!$fcut)
		{
		if (isset($fc)) open_file("admilux/tables/dump_".$dte.$dbbase.$fc.$fext.$gz);
		else open_file("admilux/tables/dump_".$dte.$dbbase.$fext.$gz);
		}
		else
		{
			open_file("admilux/tables/dump_".$dte.$dbbase.$fc."_1".$fext.$gz);
		}
	}
	$nbf = 1;
	mysql_connect($dbhost,$dbuser,$dbpass);
	mysql_select_db($dbbase);
	if ($fext == ".sql")
	{
		
		if ($ftbl)
		{
			while (list($i) = each($tbl))
			{
				
				$temp = sqldumptable($tbl[$i]);
				$sz_t = strlen($temp);
				if ($fcut)
				{
					open_file("admilux/tables/dump_".$dte.$tbl[$i].$fc.".sql".$gz);
					$nbf = 0;
					$p_sql = split_sql_file($temp);
					while(list($j,$val) = each($p_sql))
					{
						if ((file_pos() + 6 + strlen($val)) < $fz_max)
						{
							write_file($val . ";");
						}
						else
						{
							close_file();
							$nbf++;
							open_file("admilux/tables/dump_".$dte.$tbl[$i].$fc."_".$nbf.".sql".$gz);
							write_file($val . ";");
						}
					}
					close_file();
				}
				else
				{
					open_file("admilux/tables/dump_".$dte.$tbl[$i].$fc.".sql".$gz);
					write_file($temp ."\n\n");
					close_file();
					$nbf = 1;
				}
				if (isset($tblsv)) $tblsv = $tblsv . "<b>" . $tbl[$i] . "</b> , ";
				else $tblsv = "<b>" . $tbl[$i] . "</b> , ";
			}
		}
		else
		{
			while (list($i) = each($tbl))
			{
				
				$temp = sqldumptable($tbl[$i]);
				$sz_t = strlen($temp);
				if ($fcut && ((file_pos() + $sz_t) > $fz_max))
				{
					$p_sql = split_sql_file($temp);
					while(list($j,$val) = each($p_sql))
					{
						if ((file_pos() + 6 + strlen($val)) < $fz_max)
						{
							write_file($val . ";");
						}
						else
						{
							close_file();
							$nbf++;
							open_file("admilux/tables/dump_".$dte.$dbbase.$fc."_".$nbf.".sql".$gz);
							write_file($val . ";");
						}
					}
				}
				else
				{
					write_file($temp);
				}
				if (isset($tblsv ))$tblsv = $tblsv . "<b>" . $tbl[$i] . "</b> , ";
				else $tblsv = "<b>" . $tbl[$i] . "</b> , ";
			}
		}
	}
	else if ($fext == ".csv")
	{
		if ($ftbl)
		{
			while (list($i) = each($tbl))
			{
				
				$temp = csvdumptable($tbl[$i]);
				$sz_t = strlen($temp);
				if ($fcut)
				{
					open_file("admilux/tables/dump_".$dte.$tbl[$i].$fc.".csv".$gz);
					$nbf = 0;
					$p_csv = split_csv_file($temp);
					while(list($j,$val) = each($p_csv))
					{
						if ((file_pos() + 6 + strlen($val)) < $fz_max)
						{
							write_file($val . "\n");
						}
						else
						{
							close_file();
							$nbf++;
							open_file("admilux/tables/dump_".$dte.$tbl[$i].$fc."_".$nbf.".csv".$gz);
							write_file($val . "\n");
						}
					}
					close_file();
				}
				else
				{
					open_file("admilux/tables/dump_".$dte.$tbl[$i].$fc.".csv".$gz);
					write_file($temp ."\n\n");
					close_file();
					$nbf = 1;
				}
				if (isset($tblsv)) $tblsv = $tblsv . "<b>" . $tbl[$i] . "</b> , ";
				else $tblsv = "<b>" . $tbl[$i] . "</b> , ";
			}
		}
		else
		{
			while (list($i) = each($tbl))
			{
				
				$temp = csvdumptable($tbl[$i]);
				$sz_t = strlen($temp);
				if ($fcut && ((file_pos() + $sz_t) > $fz_max))
				{
					$p_csv = split_sql_file($temp);
					while(list($j,$val) = each($p_csv))
					{
						if ((file_pos() + 6 + strlen($val)) < $fz_max)
						{
							write_file($val . "\n");
						}
						else
						{
							close_file();
							$nbf++;
							open_file("admilux/tables/dump_".$dte.$dbbase.$fc."_".$nbf.".csv".$gz);
							write_file($val . "\n");
						}
					}
				}
				else
				{
					write_file($temp);
				}
				if (isset($tblsv))$tblsv = $tblsv . "<b>" . $tbl[$i] . "</b> , ";
				else $tblsv = "<b>" . $tbl[$i] . "</b> , ";
				
			}
		}
	}
	mysql_close();
	if (!$ftbl)
	{
		close_file();
	}
	echo $header;
	message('L\'extension .php est ajoutée pour pouvoir inclure une commande de sécurité ...<br>Pour enregistrer le fichier, ouvrir le fichier, puis enregister la source du fichier ...');	
	
	echo "<br><center>Les Tables ".$tblsv." ont été sauvées dans les fichiers suivants :<br><br></center>
	<table border='0' align='center' cellpadding='0' cellspacing='0'>
	<col width=1>
	<col valign=center>
	<col width=1>
	<col valign=center align=right>
	<col width=1>
	<tr>
		<td colspan=5></td>
	</tr>
	<tr>
		<td></td>
		<td align=center class=texte><font size=1><b>Nom</b></font></td>
		<td></td>
		<td align=center class=texte><font size=1><b>Taille</b></font></td>
		<td ></td>
	</tr>
	<tr>
		<td colspan=5 ></td>
	</tr>
	";
	reset($f_nm);
	while (list($i,$val) = each($f_nm))
	{
		$coul = '#99CCCC';
		if ($i % 2)
		{
			$coul = '#CFE3E3';
		}
		echo "<tr>
		<td></td>
		<td class=texte>&nbsp;<a href='".$val."' class=link target='_blank'>".$val."&nbsp;</a></td>
		<td></td>";
		$fz_tmp = filesize($val);
		if ($fcut && ($fz_tmp > $fz_max))
		{
			echo "<td class=texte>&nbsp;<font size=1 color=red>".$fz_tmp." Octets</font>&nbsp;</td><td></td></tr>";
		}
		else
		{
			echo "<td class=texte>&nbsp;<font size=1>".$fz_tmp." Octets</font>&nbsp;</td><td></td></tr>";
		}
		echo "<tr><td colspan=5></td></tr>";
	}
	echo "</table>";	
	
	echo $footer;

}

if ( isset($_GET['action']) and $_GET['action'] == 'connect')
{
	/* Vérification des paramètres de connexion */
	/* Check connection parameters */
	
	if(!@mysql_connect($dbhost,$dbuser,$dbpass))
	{
		echo $header . "<br><center><font color=red><b>La Connexion a la Base de Donnée a échouée,<br>Veuillez vérifier les parametres de connexion</b></font></center>\n$footer";
		exit;
	}
	
	if(!@mysql_select_db($dbbase))
	{
		echo $header . "<br><center><font color=red><b>La Base de Donnée que vous avez sélectionné, n'existe pas.<br>Veuillez vérifier les parametres de connexion</b></font></center>\n$footer";
		exit;
	}

	

	mysql_connect($dbhost,$dbuser,$dbpass);
	$tables = mysql_list_tables ($dbbase);
	$nb_tbl = mysql_num_rows ($tables);
	
	echo $header . "
	<script language='javascript'>
	function checkall()
	{
		var i = 0;
	
		while (i < $nb_tbl)
		{
			a = 'tbls[' + i + ']';
			document.formu.elements[a].checked = true;
			i = i+1;
		}
	
	}

	function decheckall()
	{
		var i = 0;
	
		while (i < $nb_tbl)
		{
			a = 'tbls[' + i + ']';
			document.formu.elements[a].checked = false;
			i = i+1;
		}
	
	}
	</script>
	<SCRIPT LANGUAGE='Javascript1.2'>
	IE4 = (document.all) ? 1 : 0;
	NS4 = (document.layers) ? 1 : 0;
	VERSION4 = (IE4 | NS4) ? 1 : 0;
	if (!VERSION4) event = null;
	
	function BullGetOffset(obj, coord)
	{
		var val = obj['offset'+coord] ;
		if (coord == 'Top') val += obj.offsetHeight;
		while ((obj = obj.offsetParent )!=null)
		{
			val += obj['offset'+coord];
			if (obj.border && obj.border != 0) val++;
		}
		return val;
	}
	
	function BullDown ()
	{
		if (IE4) document.all.infobull.style.visibility = 'hidden';
		if (NS4) document.infobull.visibility = 'hidden';
	}
	
	function BullOver (event,texte)
	{
		if (!VERSION4) return;
	
		var ptrObj, ptrLayer;
		if (IE4)
		{
			ptrObj = event.srcElement;
			ptrLayer = document.all.infobull;
		}
		if (NS4)
		{
			ptrObj = event.target;
			ptrLayer = document.infobull;
		}
	
		if (!ptrObj.onmouseout) ptrObj.onmouseout = BullDown;
	
		var str = '<DIV CLASS=infobullDIV>'+texte+'</DIV>';
		if (IE4)
		{
			ptrLayer.innerHTML = str;
			ptrLayer.style.top  = BullGetOffset (ptrObj,'Top') + 2;
			ptrLayer.style.left = BullGetOffset (ptrObj,'Left');
			ptrLayer.style.visibility = 'visible';
		}
		if (NS4)
		{
			ptrLayer.document.write (str);
			ptrLayer.document.close ();
			ptrLayer.document.bgColor = 'yellow';
			ptrLayer.top  = ptrObj.y + 20;
			ptrLayer.left = ptrObj.x;
			ptrLayer.visibility = 'show';
		}
	}
	// -->
	</SCRIPT>
	<center>
	<br>
	<b>Sélectionner la ( ou les ) Table(s)</b>
	<form action='admi.php?page_admi=sauvegarde' method='post' name=formu>
	<input type='hidden' name='action' value='save'>
	<input type='hidden' name='dbhost' value='$dbhost'>
	<input type='hidden' name='dbbase' value='$dbbase'>
	<input type='hidden' name='dbuser' value='$dbuser'>
	<input type='hidden' name='dbpass' value='$dbpass'>
	<DIV ID='infobull'></DIV>
	<table border='0' width='400' align='center' cellpadding='0' cellspacing='0' class=texte>
	<col width=1>
	<col width=30 align=center valign=center>
	<col width=1>
	<col width=350>
	<col width=1>
		<tr>
			<td colspan=5></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='checkbox' name='selc' title='Tout Sélectionner' onclick='if (document.formu.selc.checked==true){checkall();}else{decheckall();}' onMouseover=\"BullOver(event,'Selectionner Toutes les Tables')\" ></td>
			<td></td>
			<td align=center></td>
			<td></td>
		</tr>
		<tr>
			<td colspan=5></td>
		</tr>
	";

	$i = 0;
	while ($i < mysql_num_rows ($tables))
	{
		$coul = '#99CCCC';
		if ($i % 2)
		{
			$coul = '#CFE3E3';
		}
		$tb_nom = mysql_tablename ($tables, $i);
		echo "	<tr>
					<td></td>
					<td><input type='checkbox' name='tbls[".$i."]' value='".$tb_nom."' checked></td>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;".$tb_nom."</td>
					<td></td>
				</tr>
				<tr>
					<td colspan=5></td>
				</tr>";
		$i++;
	}

	mysql_close();
	
	echo "
	</table>
	<br><br>
	<table align=center border=0 >
		<tr>
			<td align=left class=texte>
			<hr>
				<input type='radio' name='savmode' value='csv'> Sauvegarder au Format csv (*.<i>csv</i>)<br>
				<input type='radio' name='savmode' value='sql' checked> Sauvegarder sous forme Sql (*.<i>sql</i>)<br>
			<hr>
				<input type='radio' name='opt' value='1' checked>Structure et Données<br>
				<input type='radio' name='opt' value='2'>Structure Seulement<br>
				<input type='radio' name='opt' value='3'>Données Seulement<br>
			<hr>
				<input type='Checkbox' name='drp_tbl' value='1' checked> Ajouter la Suppression de Table si existante.<br>
				<input type='Checkbox' name='ecraz' value='1' checked> Ecraser le Fichier si existant.<br>
				<input type='Checkbox' name='f_tbl' value='1'> Un fichier par table<br>
				<input type='Checkbox' name='f_cut' value='1'> Taille Maximale des fichiers : <input type='text' name='fz_max' value='200000' class=form> Octets<br>
				
			</td>
		</tr>
	</table>
	<br><br>
	<input type='submit' value=' Sauver ' class=form>
	</form>
	</center>
	$footer"; } 
	
message('<strong>Présentation des tables :</strong><br>
- gc_agenda : contient les messages de l\'agenda<br>
- gc_bloc_notes : contient les messages du bloc_notes présents dans les cahiers de texte<br>
- gc_classe : contient les noms des classes<br>
- gc_cahier_texte : contient les commentaires des cahiers de texte<br>
- gc_config : contient les informations sur la configuration générale du site<br>
- gc_connexion : contient les identifiants des derniers élèves connectés<br>
- gc_contenu_auto : contient les informations liées aux contenus automatiques des pages<br>
- gc_contenu_page : contient le contenu html ( haut et bas ) des pages <br>
- gc_devoir : contient les informations liées aux devoirs<br>
- gc_division_page : contient les divisions des pages et le contenu html de ces divisions<br>
- gc_eleve : contient les informations sur les élèves et les moyennes des élèves<br>
- gc_lien : contient les informations de la rubrique liens<br>
- gc_modification : contient les identifiants des derniers élèves ayant modifié leur fiche<br>
- gc_notes : contient les notes des devoirs<br>
- gc_pages : contient la structure des rubriques<br>
- gc_restriction : contient les informations sur les restrictions<br>
- gc_vacances : contient les vacances de la rubrique agenda');
?> 
	