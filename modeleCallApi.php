<?php

$adresseLocal ="http://127.0.0.1:6969/questions/getall";
$adresseDistante ="https://quizz.servehttp.com/questions/getall";

// ************* Call API en get:

// create & initialize a curl session
$ch = curl_init();

// set our url with curl_setopt()
curl_setopt($ch, CURLOPT_URL, $adresseDistante );


//decommenter la ligne pour le post:
// curl_setopt($ch, CURLOPT_POST, 1);// set post data to true

// return the transfer as a string, also with setopt()
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// recup json result
$json = curl_exec($ch);
// print_r($json);

// close http caller
curl_close ($ch);

// convert json string to an object (array or simple object)
$questions = json_decode($json);
// print_r($questions);

// parse all result and get each property for the question
foreach ($questions as $question){ 
	
	print_r("<h2>QUESTIONS</h2><br>");
	print_r('id: ' .$question->id .'<br>');
	print_r('texte: ' .$question->texte .'<br>');
	print_r('points: ' .$question->points .'<br>');
	print_r('<br>');

	print('<h2>BONNE REPONSE</h2><br>');
	print_r('id bonne reponse: ' .$question->bonneReponse->id .'<br>');
	print_r('texte bonne reponse: ' .$question->bonneReponse->texte .'<br>');
	print_r('<br>');

	print('<h2>REPONSES</h2><br>');
	$reponses = $question->reponses;    //response is an array
	foreach ($reponses as $reponse){
		print_r('id reponse: ' . $reponse->id . '<br>');
		print_r('texte reponse: ' . $reponse->texte . '<br>');
	}
	print_r('<br>');

	print('<h2>DIFFICULTE</h2><br>');
	print_r('id difficultes: ' .$question->difficultes->id .'<br>');
	print_r('texte difficultes: ' .$question->difficultes->nom .'<br>');

	print_r('========================================'. '<br>');
}
?>
