<!DOCTYPE HTML>
<?php
	$path = "http://sp-uc.ddns.net//images/";
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="ocean.css">
	<style>
		#formulaire{
			float:left;
		}
		#selection_capture{
			float:left;
			max-height:500px;
			overflow:scroll;
			
		}
		#selection_reference{
			float:left;
			max-height:400px;
			overflow:scroll;
		}
		#plotPHP{
			float:right;
		}
		#submit_formulaire{
			display: block;
			float:right;
		}
	</style>
</head>
<body>
<div style="clear:both">
<ul>
<li><a id="menulinkactive" href="index.php">Index</a></li>
<li><a id="menulink" href="capture_comparison.php">Analysis of a capture</a></li>
<li><a id="menulink" href="capture_visualization.php">Visualization of the specter</a></li>
<!--<li><a id="menulink" href="#">Visualization on a period</a></li>
<li><a id="menulink" href="#">Single Measurement</a></li>
<li><a id="menulink" href="#">Manage Results</a></li>
<li><a id="menulink" href="#">Configuration</a></li>-->
<div align="right"><a href="<?php echo "http://sp-uc.ddns.net//"?>fr/index.php "><img src="<?php echo $path;?>drapeau_france.png" width="25px" height="25px" alt="France"/></a> <a href="<?php echo "http://sp-uc.ddns.net//"?>en/index.php"><img src="<?php echo $path;?>drapeau_anglais.png" width="25px" height="25px" alt="English"/></a> <a href="<?php echo "http://sp-uc.ddns.net//"?>esp/index.php"><img src="<?php echo $path;?>drapeau_espagne.png" width="25px" height="25px" alt="Espagnol"/></a> <a href="<?php echo "http://sp-uc.ddns.net//"?>pt/index.php"><img src="<?php echo $path;?>drapeau_portugal.png" width="25px" height="25px" alt="Portugal"/></a></div>
</ul>
</ul>
</div>

</form>
</body>
<?php //} ?>
