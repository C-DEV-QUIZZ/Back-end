<?php
$pseudo = 'flav';
$sessionId = 17;
$connexionId = 92;

try 
{
 	$bdd = new PDO('mysql:host=localhost; dbname=quizz; charset=utf8', 'root', '');
}
catch (Exception $e)
{
 	die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('INSERT INTO onlineuser (connexionId, sessionId, pseudo) VALUES (:connexionId, :sessionId, :pseudo);');
$req->execute(array(
'sessionId' => $sessionId,
'pseudo' => $pseudo,
'connexionId' => $connexionId
));
?>



<!-- 
		foreach($this->clients as $client)
		{
			$client->send(json_encode(array("type"=>'welcome',"msg"=>$conn->resourceId . ' a deco')));
		} -->