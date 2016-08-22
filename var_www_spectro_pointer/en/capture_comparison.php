<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=DataBase_Spectro_Pointer;charset=utf8', 'root', 'xxxx');
}
catch(Exception $e){
	die('Erreur : '.$e->getMessage());
}

require_once '/var/www/phpmyadmin/phplot.php';

$path = "http://sp-uc.ddns.net//images/";

if($_GET["capture"]) {

	// on récupère la méthode
	$methode_comparaison=$_GET["methode_comparison"];
	// on récupère l'id correspondant à la date et au numéro de série.
	$mots = explode(" ", $_GET["capture"]);
	$serial_num=$mots[0];
	$capture_date=$mots[1]." ".$mots[2];

	$selection = $bdd->query("SELECT id_spectre FROM Capture WHERE serial_num='".$serial_num."'"." AND capture_date='".$capture_date."'");
	while ($donnees = $selection->fetch()){
		$id_spectre=$donnees[0];
	}
	$selection->closeCursor();

	// comparison of the capture with every references
	$dataTemp = array();
	$table1 = Spectrum_Capture;
	$reponse = $bdd->query('SELECT wavelength, intensity FROM '.$table1.' WHERE id='.$id_spectre);

	while ($donnees = $reponse->fetch()){
		$dataTemp[] = array($donnees['wavelength'],$donnees['intensity']);
	}
	$reponse->closeCursor();

	//$tableId = ReferTo;
	$tableId='ReferTo';
	$id_max=1;
	$corr_max=0;
	$name_reference="";
	$reponseId = $bdd->query('SELECT id,name FROM '.$tableId);
	$i=0;
	while ($id_reference = $reponseId->fetch()){
		if($methode_comparaison=="2"){
			$resultat = exec('python ./comparaison_number2.py '.$id_spectre.' '.$id_reference['id']);
		}
		else{ // si aucun choix
			$resultat = exec('python ./comparaison_number1.py '.$id_spectre.' '.$id_reference['id']);
		}
		$resultat = (float) $resultat;
	 	if($resultat>$corr_max){
			$corr_max=$resultat;
			$id_max=$id_reference['id'];
			$name_reference=$id_reference['name'];
		}
	}	
	$reponseId->closeCursor();

	// affichage du résultat
	//Define the object
	$plot = new PHPlot(800,600);
	$plot->SetPrintImage(False);

	$table2 = Spectrum_Reference;
	$reponse2 = $bdd->query('SELECT wavelength, intensity FROM '.$table2.' WHERE id='.$id_max);
	$i=0;
	while ($donnees2 = $reponse2->fetch()){
		$data1[] = array($donnees2['wavelength'], $donnees2['intensity'], $dataTemp[$i][1]);
		$i++;
	}

	$reponse2->closeCursor(); // Termine le traitement de la requête

	$legend = array($name_reference,$_GET["capture"]);
	$plot->SetLegend($legend);
	$plot->SetTitle("Comparison with the ".$name_reference);
	$plot->SetPlotType('lines');
	$plot->SetDataValues($data1);
	$plot->SetXTitle('Wavelength');
	$plot->SetYTitle('Intensity');
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
<li><a id="menulink" href="index.php">Index</a></li>
<li><a id="menulinkactive" href="capture_comparison.php">Analysis of a capture</a></li>
<li><a id="menulink" href="capture_visualization.php">Visualization of the specter</a></li>
<!--<li><a id="menulink" href="#">Visualization on a period</a></li>
<li><a id="menulink" href="#">Single Measurement</a></li>
<li><a id="menulink" href="#">Manage Results</a></li>
<li><a id="menulink" href="#">Configuration</a></li>-->
<img id="button_help" src="<?php echo $path;?>help.png" width="25px" height="25px" alt="help"/>
<div align="right"><a href="<?php echo "http://sp-uc.ddns.net//"?>fr/capture_comparison.php "><img src="<?php echo $path;?>drapeau_france.png" width="25px" height="25px" alt="France"/></a> <a href="<?php echo "http://sp-uc.ddns.net//"?>en/capture_comparison.php"><img src="<?php echo $path;?>drapeau_anglais.png" width="25px" height="25px" alt="English"/></a> <a href="<?php echo "http://sp-uc.ddns.net//"?>esp/capture_comparison.php"><img src="<?php echo $path;?>drapeau_espagne.png" width="25px" height="25px" alt="Espagnol"/></a> <a href="<?php echo "http://sp-uc.ddns.net//"?>pt/capture_comparison.php"><img src="<?php echo $path;?>drapeau_portugal.png" width="25px" height="25px" alt="Portugal"/></a></div>
</ul>
</div>

<form method="GET">
	<div id="formulaire">
	<fieldset id="selection_capture">
	<legend>Select a capture to analyse</legend>
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
	<p>
		Cross-correlation : <input type="radio" name="methode_comparison" value="1" /><br/>
		Standard correlation : <input type="radio" name="methode_comparison" value="2" /><br/>
	</p>    
	<br/>
	<?php
		$table = Spectro_Pointer;
		$selection = $bdd->query('SELECT num FROM '.$table);
		while ($donnees = $selection->fetch()){
			echo $donnees['num']."<input type=\"radio\" name=\"id_spectro_pointer\" value=\"".$donnees['num']."\"/><br/>";
		}
		$selection->closeCursor();
	?> 
	All <input type="radio" name="id_spectro_pointer" value=""/><br/>
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
	<?php if($_GET['capture']){
		echo "<img src=\"".$plot->EncodeImage()."\" alt=\"Plot Image\" />";}
	?>
	<br />
	<?php
	if($_GET["capture"]){
		if($resultat>65.0){
			$conclusion="corresponds to ".$name_reference;
		}
		else{
			$conclusion="don't correspond to our references.<br/>We don't know what is this capture";
		}
	 	echo "<p> The best correlation is with the ".$name_reference.".  Correlation of ".$resultat." %.<br/><b>So we can conclude that this capture ".$conclusion."</b></p>";
	}
	?>
	</div>
</form>
<script>
	var elem=document.getElementById("button_help");
	elem.onclick = function(){
		alert("Fonctionnement de la comparaison de spectres : \nSur cette page il est possible de rechercher la reference qui correspond le plus a un spectre. Tout en bas de la colonne sur la gauche, vous pouvez choisir quel est le spectro-pointer dont vous voulez analyser un spectre.\n Il y a deux methodes de comparaison de spectres de disponible : la premiere est la correlation croisee. Elle est baeucoup moins restrictive que la seconde methode, lacorrelation standard, mais peut cependant trouver des correspondances entre deux spectres alors qu'il n'y en a pas. Lorsque une correlation est superieur a 65%, on peut en conclure que la capture ressemble fortement a la reference. Le cas echeant, on ne peut pas identifier la capture a partir de nos spectres de reference.");
	}
</script>
</body>
<?php //} ?>
