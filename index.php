<?
	error_reporting(E_ALL);
	
	$mass = isset($_POST['mass']) ? $_POST['mass'] : '2';
	$offx = isset($_POST['offx']) ? $_POST['offx'] : '1959.0';
	$offy = isset($_POST['offy']) ? $_POST['offy'] : '441.0';
	$offz = isset($_POST['offz']) ? $_POST['offz'] : '170.0';
	$scalex = isset($_POST['scalex']) ? $_POST['scalex'] : '1.0';
	$scaley = isset($_POST['scaley']) ? $_POST['scaley'] : '1.0';
	$scalez = isset($_POST['scalez']) ? $_POST['scalez'] : '1.0';
	$transx = isset($_POST['transx']) ? $_POST['transx'] : '0';
	$transy = isset($_POST['transy']) ? $_POST['transy'] : '0';
	$transz = isset($_POST['transz']) ? $_POST['transz'] : '0';
	$rotq1 = isset($_POST['rotq1']) ? $_POST['rotq1'] : '0';
	$rotq2 = isset($_POST['rotq2']) ? $_POST['rotq2'] : '0';
	$rotq3 = isset($_POST['rotq3']) ? $_POST['rotq3'] : '1';
	$rotq4 = isset($_POST['rotq4']) ? $_POST['rotq4'] : '0';
	$cogx = isset($_POST['cogx']) ? $_POST['cogx'] : '0';
	$cogy = isset($_POST['cogy']) ? $_POST['cogy'] : '0';
	$cogz = isset($_POST['cogz']) ? $_POST['cogz'] : '250';
	$aomq1 = isset($_POST['aomq1']) ? $_POST['aomq1'] : '1';
	$aomq2 = isset($_POST['aomq2']) ? $_POST['aomq2'] : '0';
	$aomq3 = isset($_POST['aomq3']) ? $_POST['aomq3'] : '0';
	$aomq4 = isset($_POST['aomq4']) ? $_POST['aomq4'] : '0';
	$ix = isset($_POST['ix']) ? $_POST['ix'] : '2';
	$iy = isset($_POST['iy']) ? $_POST['iy'] : '2';
	$iz = isset($_POST['iz']) ? $_POST['iz'] : '2';
	$uframex = isset($_POST['uframex']) ? $_POST['uframex'] : '1500';
	$uframey = isset($_POST['uframey']) ? $_POST['uframey'] : '500';
	$uframez = isset($_POST['uframez']) ? $_POST['uframez'] : '0';
	$uframeq1 = isset($_POST['uframeq1']) ? $_POST['uframeq1'] : '1';
	$uframeq2 = isset($_POST['uframeq2']) ? $_POST['uframeq2'] : '0';
	$uframeq3 = isset($_POST['uframeq3']) ? $_POST['uframeq3'] : '0';
	$uframeq4 = isset($_POST['uframeq4']) ? $_POST['uframeq4'] : '0';
	$oframex = isset($_POST['oframex']) ? $_POST['oframex'] : '0';
	$oframey = isset($_POST['oframey']) ? $_POST['oframey'] : '0';
	$oframez = isset($_POST['oframez']) ? $_POST['oframez'] : '0';
	$oframeq1 = isset($_POST['oframeq1']) ? $_POST['oframeq1'] : '1';
	$oframeq2 = isset($_POST['oframeq2']) ? $_POST['oframeq2'] : '0';
	$oframeq3 = isset($_POST['oframeq3']) ? $_POST['oframeq3'] : '0';
	$oframeq4 = isset($_POST['oframeq4']) ? $_POST['oframeq4'] : '0';
	$speed = isset($_POST['speed']) ? $_POST['speed'] : 'v100';
	$zone = isset($_POST['zone']) ? $_POST['zone'] : 'z5';
	$moveorig = isset($_POST['submit']) ? (isset($_POST['moveorig']) && $_POST['moveorig']=='on') : true;
	$paramz = isset($_POST['submit']) ? (isset($_POST['paramz']) && $_POST['paramz']=='on') : false;
	$tool0 = isset($_POST['tool']) && $_POST['tool']=='tool0' ? true : false;
	$limit = isset($_POST['limit']) ? $_POST['limit'] : '100000';
	
	$error = '';
	if (isset($_POST['submit']) && isset($_FILES['gcodefile']['tmp_name'])) switch($_FILES["gcodefile"]["error"]) {
		case UPLOAD_ERR_INI_SIZE:
			$error = 'The uploaded file exceeds '.ini_get('upload_max_filesize').'<br/>';
			break;
		case UPLOAD_ERR_PARTIAL:
			$error = 'The uploaded file was only partially uploaded.<br/>';
			break;
		case UPLOAD_ERR_NO_FILE:
			$error = 'No file was uploaded.<br/>';
			break;
		case UPLOAD_ERR_OK:
			// protection against uploading of serverside scripts
			if (preg_match('/\.(php|asp|pl|cgi|java|cfm)$/i',$_FILES['gcodefile']['tmp_name'])) $error.= "Not allowed to upload serverside scripts!<br/>";
			else {
				$gcodefile = fopen($_FILES['gcodefile']['tmp_name'], "r");
				if (!$gcodefile) $error.= 'Could not open the gcode file ('.$gcodefile.').<br/>';
				else {
					$filename = str_replace(' ', '_', pathinfo($_FILES['gcodefile']['name'])['filename']);
					header('Content-Type: application/json; charset=UTF-8');
					header('Content-Disposition: attachment; filename="'.$filename.'.mod'.'"');
					echo "%%%\r\n";
					echo "  VERSION:1\r\n";
					echo "  LANGUAGE:ENGLISH\r\n";
					echo "%%%\r\n";
					echo "! gcode2rapid conversion tool by Harmen G. Zijp\r\n";
					echo "! www.giplt.nl/cgode2robot\r\n";
					echo "MODULE ".$filename."\r\n";
					if (!$tool0) echo "  LOCAL PERS tooldata gTool:=[TRUE,[[".$transx.",".$transy.",".$transz."],[".$rotq1.",".$rotq2.",".$rotq3.",".$rotq4."]],[".$mass.",[".$cogx.",".$cogy.",".$cogz."],[".$aomq1.",".$aomq2.",".$aomq3.",".$aomq4."],".$ix.",".$iy.",".$iz."]];\r\n";
					echo "  LOCAL PERS wobjdata gWobj:=[FALSE,TRUE,\"\",[[".$uframex.",".$uframey.",".$uframez."],[".$uframeq1.",".$uframeq2.",".$uframeq3.",".$uframeq4."]],[[".$oframex.",".$oframey.",".$oframez."],[".$oframeq1.",".$oframeq2.",".$oframeq3.",".$oframeq4."]]];\r\n";
					echo "\r\n";
					echo "  LOCAL VAR orient gOrient:=[1,0,0,0];\r\n";
					echo "  LOCAL VAR confdata gConfData:=[0,-1,0,0];\r\n";
					echo "  LOCAL VAR extjoint gExtJoint:=[9E+09,9E+09,9E+09,9E+09,9E+09,9E+09];\r\n";
					echo "\r\n";
					echo "  PROC ".$filename."_proc()\r\n";
					echo "    VAR iodev serial;";
					echo "    Open \"COM3:\", serial\\Write;";
					
					while (($line = fgets($gcodefile)) !== false) {
						$words = explode(' ', $line);
						switch($words[0][0]) {
							case ';':
								break;
							case 'G':
								switch(substr($words[0], 1)) {
									case '0':
									case '1':
										foreach($words as $word) if ($word) switch($word[0]) {
											case 'X':
												$x = substr($word, 1);
												break;
											case 'Y':
												$y = substr($word, 1);
												break;
											case 'Z':
												$z = substr($word, 1);
												break;
											case 'F':
												break;
											case 'E':
												$e = substr($word, 1);
												break;
											default:
												break;
										}
										if (isset($x) && isset($y) && isset($z)) $path[] = Array("x"=>$x, "y"=>$y, "z"=>$z, "e"=>$e);
										break;
									default:
										break;
								}
								break;
							case 'M':
								break;
							default:
								break;
						}
					}
					$minx = $maxx = $path[0]['x'];
					$miny = $maxy = $path[0]['y'];
					$minz = $maxz = $path[0]['z'];
					if ($paramz) {
						$zvals = array();
						$dzvals = array();
					}
					foreach($path as $position) {
						if ($paramz) {
							if (!isset($zvals[$position['z']])) $zvals[$position['z']] = 1;
							else $zvals[$position['z']] ++;
						}
						$minx = min($minx, $position['x']);
						$maxx = max($maxx, $position['x']);
						$miny = min($miny, $position['y']);
						$maxy = max($maxy, $position['y']);
						$minz = min($minz, $position['z']);
						$maxz = max($maxz, $position['z']);
					}
					if ($paramz) {
						$zvals = array_keys($zvals);
						$j = 0;
						for($i=1; $i<count($zvals); $i++) {
							$dz = $zvals[$i] - $zvals[$i-1];
							if (!isset($dzvals[$dz])) {
								$dzvals[$dz] = 'dh'.$j;
								$j++;
							}
						}
						foreach($dzvals as $dz => $varname) echo "    LOCAL VAR num ".$varname.":=".$dz.";\r\n";
					}
					$steps = 0;
					$lastz = 0;
					foreach($path as $position) {
						$x = $moveorig ? $position['x'] - $minx : $position['x'];
						$y = $moveorig ? $position['y'] - $miny : $position['y'];
						$z = $moveorig ? $position['z'] - $minz : $position['z'];
						if ($paramz) {
							if($steps==0) echo "    LOCAL VAR num h:=".$z.";\r\n";
							elseif($z!=$lastz) echo "    h:=h+".$dzvals[$z-$lastz].";\r\n";
						}
						echo "    Write serial, NumToStr(".$position['e'].", 3);";
						if ($tool0) echo "    MoveL [[".$x.",".$y.",".($paramz?"h":$z)."],gOrient,gConfData,gExtJoint],".$speed.",".$zone.",tool0\\WObj:=gWobj;\r\n";
						else echo "    MoveL [[".$x.",".$y.",".($paramz?"h":$z)."],gOrient,gConfData,gExtJoint],".$speed.",".$zone.",gTool\\WObj:=gWobj;\r\n";
						
						$lastz = $z;
						$steps++;
						if ($steps==$limit) {
							$error = 'Rapid output limited to '.$limit.' move instructions.<br/>';
							break;
						}
					}
					fclose($gcodefile);

					echo "    Close serial;";
					echo "  ENDPROC\r\n";
					echo "\r\n";
					echo "  PROC Main()\r\n";
					echo "  ENDPROC\r\n";
					echo "ENDMODULE\r\n";
					exit;
				}
			}
			break;
		default:
			$error = 'Unknown error with uploading file.<br/>';
			break;
	}
	if (isset($rapidfile) && file_exists($filename.".mod")) {
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=".$filename.".mod");
		readfile($filename.".mod");
		exit;
	}
?>

<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="UTF-8" />
		<title>gcode2robot</title>
		<style>
			th td {vertical-align:top;}
			.l {text-align:left;}
			.r {text-align:right;}
			.number {width:70px; text-align:right;}
			.tool {display:none;}
		</style>
		<script>
			function setToolState(state) {
				var trs = document.getElementsByTagName("tr");
				for(var i=0; i<trs.length; i++) if(trs[i].className=="tool") trs[i].style.display = (state=="show" ? "table-row" : "none");
			}
		</script>
	</head>
	<body>
		<h1>gcode2robot conversion</h1>
		<?if ($error) echo '<span style="color:red;">Error: '.$error.'</span>';?>
		<form method="post" action="" enctype="multipart/form-data">
			<table>
				<tr>
					<td class="r">Source file</td>
					<td class="l" colspan="7"><input type="file" name="gcodefile"/></td>
				</tr>
				<tr>
					<td class="r">Limit (steps)</td>
					<td class="l"><input type="text" class="number" name="limit" value="<?echo $limit;?>"/></td>
					<td class="r">Speed</td>
					<td class="l"><input type="text" class="number" name="speed" value="<?echo $speed;?>"/></td>
					<td class="r">Zone</td>
					<td class="l"><input type="text" class="number" name="zone" value="<?echo $zone;?>"/></td>
				</tr>
				<tr>
					<td></td>
					<td class="l" colspan="5"><input type="checkbox" name="moveorig" <?if ($moveorig) echo 'checked="checked"';?>/> Offset gcode to origin of work object</td>
				</tr>
				<tr>
					<td></td>
					<td class="l" colspan="5"><input type="checkbox" name="paramz" <?if ($paramz) echo 'checked="checked"';?>/> Parametrize layer height</td>
					<td colspan="2"><input type="submit" name="submit" value="Create ABB RAPID file"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th class="l">Tool data</th>
					<td colspan=7><input type="radio" name="tool" value="tool0" checked="checked" onclick="setToolState('hide');"/>tool0 <input type="radio" name="tool" value="gtool" onclick="setToolState('show');"/>custom</td>
				</tr>
				<tr class="tool">
					<th></th>
					<th colspan="3" style="text-align:center;">coordinates (mm)</th>
					<th colspan="4" style="text-align:center;">orientation (quaternions)</th>
				</tr>
				<tr class="tool">
					<td></td>
					<th>x</th>
					<th>y</th>
					<th>z</th>
					<th>q1</th>
					<th>q2</th>
					<th>q3</th>
					<th>q4</th>
				</tr>
				<tr class="tool">
					<td class="r">Tool Center Point</td>
					<td><input type="text" class="number" name="transx" value="<?echo $transx;?>"/></td>
					<td><input type="text" class="number" name="transy" value="<?echo $transy;?>"/></td>
					<td><input type="text" class="number" name="transz" value="<?echo $transz;?>"/></td>
					<td><input type="text" class="number" name="rotq1" value="<?echo $rotq1;?>"/></td>
					<td><input type="text" class="number" name="rotq2" value="<?echo $rotq2;?>"/></td>
					<td><input type="text" class="number" name="rotq3" value="<?echo $rotq3;?>"/></td>
					<td><input type="text" class="number" name="rotq4" value="<?echo $rotq4;?>"/></td>
				</tr>
				<tr class="tool">
					<td class="r">Center Of Gravity</td>
					<td><input type="text" class="number" name="cogx" value="<?echo $cogx;?>"/></td>
					<td><input type="text" class="number" name="cogy" value="<?echo $cogy;?>"/></td>
					<td><input type="text" class="number" name="cogz" value="<?echo $cogz;?>"/></td>
					<td><input type="text" class="number" name="aomq1" value="<?echo $aomq1;?>"/></td>
					<td><input type="text" class="number" name="aomq2" value="<?echo $aomq2;?>"/></td>
					<td><input type="text" class="number" name="aomq3" value="<?echo $aomq3;?>"/></td>
					<td><input type="text" class="number" name="aomq4" value="<?echo $aomq4;?>"/></td>
				</tr>
				<tr class="tool">
					<td class="r">Moment Of Inertia</td>
					<td><input type="text" class="number" name="ix" value="<?echo $ix;?>"/></td>
					<td><input type="text" class="number" name="iy" value="<?echo $iy;?>"/></td>
					<td><input type="text" class="number" name="iz" value="<?echo $iz;?>"/></td>
				</tr>
				<tr class="tool">
					<td class="r">Mass (kg)</td>
					<td class="l"><input type="text" class="number" name="mass" value="<?echo $mass;?>"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th class="l">Work object data</th>
					<th colspan="3" style="text-align:center;">coordinates (mm)</th>
					<th colspan="4" style="text-align:center;">orientation (quaternions)</th>
				</tr>
				<tr>
					<td></td>
					<th>x</th>
					<th>y</th>
					<th>z</th>
					<th>q1</th>
					<th>q2</th>
					<th>q3</th>
					<th>q4</th>
				</tr>
				<tr>
					<td class="r">User Frame</td>
					<td><input type="text" class="number" name="uframex" value="<?echo $uframex;?>"/></td>
					<td><input type="text" class="number" name="uframey" value="<?echo $uframey;?>"/></td>
					<td><input type="text" class="number" name="uframez" value="<?echo $uframez;?>"/></td>
					<td><input type="text" class="number" name="uframeq1" value="<?echo $uframeq1;?>"/></td>
					<td><input type="text" class="number" name="uframeq2" value="<?echo $uframeq2;?>"/></td>
					<td><input type="text" class="number" name="uframeq3" value="<?echo $uframeq3;?>"/></td>
					<td><input type="text" class="number" name="uframeq4" value="<?echo $uframeq4;?>"/></td>
				</tr>
				<tr>
					<td class="r">Object Frame</td>
					<td><input type="text" class="number" name="oframex" value="<?echo $oframex;?>"/></td>
					<td><input type="text" class="number" name="oframey" value="<?echo $oframey;?>"/></td>
					<td><input type="text" class="number" name="oframez" value="<?echo $oframez;?>"/></td>
					<td><input type="text" class="number" name="oframeq1" value="<?echo $oframeq1;?>"/></td>
					<td><input type="text" class="number" name="oframeq2" value="<?echo $oframeq2;?>"/></td>
					<td><input type="text" class="number" name="oframeq3" value="<?echo $oframeq3;?>"/></td>
					<td><input type="text" class="number" name="oframeq4" value="<?echo $oframeq4;?>"/></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="7" rowspan="4"><img src="http://developercenter.robotstudio.com/BlobProxy/manuals/RapidIFDTechRefManual/images/xx0500002369-47702-604.png" /></td>
				</tr>
			</table>
		</form>
		<?if (isset($rapidfile) && file_exists($filename.".mod")) echo '<p/>download <a href="'.$filename.'.mod">'.$filename.'.mod</a></br/>';?>
	</body>
</html>
