<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=DataBase_Spectro_Pointer;charset=utf8', 'root', 'xxxx');
}
catch(Exception $e){
	die('Erreur : '.$e->getMessage());
}

require_once '/var/www/phpmyadmin/phplot.php';

$path = "http://sp-uc.ddns.net/images/";

if( $_GET["capture"] && $_GET["reference"] ) {

	// on récupère l'id correspondant à la date et au numéro de série.
	$mots = explode(" ", $_GET["capture"]);
	$serial_num=$mots[0];
	$capture_date=$mots[1]." ".$mots[2];

	$selection = $bdd->query("SELECT id_spectre FROM Capture WHERE serial_num='".$serial_num."'"." AND capture_date='".$capture_date."'");
	while ($donnees = $selection->fetch()){
		$id_spectre=$donnees[0];
	}
	$selection->closeCursor();

	// on récupère l'id de la référence
	$mots = explode(" ", $_GET["reference"]);
	$id_reference = $mots[1];

	$dataTemp = array();
	//Define the object
	$plot = new PHPlot(800,600);
	$plot->SetPrintImage(False);
	$numberOfPlot=2;

	$table1 = Spectrum_Capture;
	$reponse = $bdd->query('SELECT wavelength, intensity FROM '.$table1.' WHERE id='.$id_spectre);

	while ($donnees = $reponse->fetch()){
		$dataTemp[] = array($donnees['wavelength'],$donnees['intensity']);
	}
	$reponse->closeCursor();

	$table2 = Spectrum_Reference;
	$reponse2 = $bdd->query('SELECT wavelength, intensity FROM '.$table2.' WHERE id='.$id_reference);
	$i=0;
	while ($donnees2 = $reponse2->fetch()){
		$data1[] = array($donnees2['wavelength'], $donnees2['intensity'], $dataTemp[$i][1]);
		$i++;
	}

	$reponse2->closeCursor(); // Termine le traitement de la requête

	$legend = array($mots[0], $_GET["capture"]);
	$plot->SetLegend($legend);
	$plot->SetTitle("Affichage des spectres");
	$plot->SetPlotType('lines');
	$plot->SetDataValues($data1);
	$plot->SetXTitle('Longueur d\'ondes');
	$plot->SetYTitle('Intensite');
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	//Draw it
	$plot->DrawGraph();
}
else if($_GET["capture"]){
	// on récupère l'id correspondant à la date et au numéro de série.
	$mots = explode(" ", $_GET["capture"]);
	$serial_num=$mots[0];
	$capture_date=$mots[1]." ".$mots[2];
	$selection = $bdd->query("SELECT id_spectre FROM Capture WHERE serial_num='".$serial_num."'"." AND capture_date='".$capture_date."'");
	while ($donnees = $selection->fetch()){
		$id_spectre=$donnees[0];
	}
	$selection->closeCursor();

	// affichage de la capture
	//Define the object
	$plot = new PHPlot(800,600);
	$plot->SetPrintImage(False);

	$table = Spectrum_Capture;
	$reponse = $bdd->query('SELECT wavelength, intensity FROM '.$table.' WHERE id='.$id_spectre);
	while ($donnees = $reponse->fetch()){
		$data1[] = array($donnees['wavelength'], $donnees['intensity']);
	}

	$reponse->closeCursor(); // Termine le traitement de la requête

	$legend = array($_GET["capture"]);
	$plot->SetLegend($legend);
	$plot->SetTitle("Affichage des spectres");
	$plot->SetPlotType('lines');
	$plot->SetDataValues($data1);
	$plot->SetXTitle('Longueur d\'ondes');
	$plot->SetYTitle('Intensite');
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	//Draw it
	$plot->DrawGraph();
}
else if($_GET["reference"]){
	// on récupère l'id de la référence
	$mots = explode(" ", $_GET["reference"]);
	$id_reference = $mots[1];

	// affichage de la reference

	//Define the object
	$plot = new PHPlot(800,600);
	$plot->SetPrintImage(False);

	$table = Spectrum_Reference;
	$reponse = $bdd->query('SELECT wavelength, intensity FROM '.$table.' WHERE id='.$id_reference);
	while ($donnees = $reponse->fetch()){
		$data1[] = array($donnees['wavelength'], $donnees['intensity']);
	}

	$reponse->closeCursor(); // Termine le traitement de la requête

	$legend = array($mots[0]);
	$plot->SetLegend($legend);
	$plot->SetTitle("Affichage des spectres");
	$plot->SetPlotType('lines');
	$plot->SetDataValues($data1);
	$plot->SetXTitle('Longueur d\'ondes');
	$plot->SetYTitle('Intensite');
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	//Draw it
	$plot->DrawGraph();
}
//else{
?>
<!DOCTYPE HTML>
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
<li><a id="menulink" href="index.php">Accueil</a></li>
<li><a id="menulink" href="capture_comparison.php">Analyse des captures</a></li>
<li><a id="menulinkactive" href="capture_visualization.php">Visualisation des spectres</a></li>
<!--
<li><a id="menulink" href="#">Visualization on a period</a></li>
<li><a id="menulink" href="#">Single Measurement</a></li>
<li><a id="menulink" href="#">Manage Results</a></li>
<li><a id="menulink" href="#">Configuration</a></li>-->
<img id="button_help" src="<?php echo $path;?>help.png" width="25px" height="25px" alt="help"/>
<div align="right"><a href="<?php echo "http://localhost/"?>fr/capture_visualization.php "><img src="<?php echo $path;?>drapeau_france.png" width="25px" height="25px" alt="France"/></a> <a href="<?php echo "http://localhost/"?>en/capture_visualization.php"><img src="<?php echo $path;?>drapeau_anglais.png" width="25px" height="25px" alt="English"/></a> <a href="<?php echo "http://localhost/"?>esp/capture_visualization.php"><img src="<?php echo $path;?>drapeau_espagne.png" width="25px" height="25px" alt="Espagnol"/></a> <a href="<?php echo "http://localhost/"?>pt/capture_visualization.php"><img src="<?php echo $path;?>drapeau_portugal.png" width="25px" height="25px" alt="Portugal"/></a></div>
</ul>
</div>

<form method="GET">
	<div id="formulaire">
	<fieldset id="selection_capture">
	<legend>Selectionnez une capture</legend>
		<p>
		<?php
			$table = Capture;

			if($_GET["id_spectro_pointer"]){			
				$selection = $bdd->query('SELECT serial_num, capture_date FROM '.$table." WHERE serial_num ='".$_GET["id_spectro_pointer"]."'");
				while ($donnees = $selection->fetch()){
					echo "<label>".$donnees['serial_num']." ".$donnees['capture_date']."</label><input type = \"radio\" name = \"capture\" id = \"".$donnees['serial_num']." ".$donnees['capture_date']."\" value = \"".$donnees['serial_num']." ".$donnees['capture_date']."\"/><br/>";
				}
			}
			else{
				$selection = $bdd->query('SELECT serial_num, capture_date FROM '.$table);
				while ($donnees = $selection->fetch()){
					echo "<label>".$donnees['serial_num']." ".$donnees['capture_date']."</label><input type = \"radio\" name = \"capture\" id = \"".$donnees['serial_num']." ".$donnees['capture_date']."\" value = \"".$donnees['serial_num']." ".$donnees['capture_date']."\"/><br/>";
				}
			}
			$selection->closeCursor();
		?> 	
		</p>       
	</fieldset>
	<fieldset id="selection_reference">
		<legend>Selectionnez une reference</legend>
		<p>
			<?php
				$table = ReferTo;
				$selection = $bdd->query('SELECT name, id FROM '.$table);
				while ($donnees = $selection->fetch()){
					echo "<label>".$donnees['name']." ".$donnees['id']."</label><input type = \"radio\" name = \"reference\" id = \"".$donnees['name']." ".$donnees['id']."\" value = \"".$donnees['name']." ".$donnees['id']."\"/><br/>";
				}
				$selection->closeCursor();
			?>	    	
		</p>       
	</fieldset>   
	<br/>
	<?php
		$table = Spectro_Pointer;
		$selection = $bdd->query('SELECT num FROM '.$table);
		while ($donnees = $selection->fetch()){
			echo $donnees['num']."<input type=\"radio\" name=\"id_spectro_pointer\" value=\"".$donnees['num']."\"/><br/>";
		}
		$selection->closeCursor();
	?> 
	Tous <input type="radio" name="id_spectro_pointer" value=""/><br/>
	<br/>
	<input type="submit" value="submit" id="submit_formulaire"/>
	<br/><br/>
	<?php if($_GET['capture']){
			$mots = explode(" ", $_GET["capture"]);
			$serial_num=$mots[0];
			$capture_date=$mots[1]." ".$mots[2];
			$reponse = $bdd->query("SELECT image FROM Capture WHERE serial_num='".$serial_num."'"." AND capture_date='".$capture_date."'");
			$donnee = $reponse->fetch();
			$nomImage = $donnee['image'];
			if($nomImage!="")
				echo "<img src=\"".$path.$nomImage."\" alt=\"photo prise juste avant la capture\"  height=\"480px\" width=\"640px\" />";
		}
	?>
	</div>
	<div id="plotPHP">
	<?php
	if($_GET["capture"] || $_GET["reference"]){
		echo "<img src=\"".$plot->EncodeImage()."\" alt=\"Plot Image\" /><br />";
	}
	if($_GET["capture"] && $_GET["reference"]){
		$resultat = exec('python ./comparaison.py '.$id_spectre.' '.$id_reference);
	 	echo "<p> Correlation : ".$resultat."</p>";}
	?>
	</div>
</form>
<script>
	var elem=document.getElementById("button_help");
	elem.onclick = function(){
		alert("Fonctionnement de la visualisation de spectres : \nSur cette page il est possible de visualiser le spectre d'une capture, celui d'une reference, ou les deux en meme temps. Tout en bas de la colonne sur la gauche, vous pouvez choisir quel est le spectro-pointer dont vous voulez voir les spectres.\n Lors de la visualtion d'un capture et d'une reference en meme temps, la correlation croisee entre ces deux spectres sera calculee. Si elle est inferieur a 65%, nous estimerons que la capture correspond a peu pres a la reference");
	}
</script>
</body>
