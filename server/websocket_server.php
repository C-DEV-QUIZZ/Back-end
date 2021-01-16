<?php
set_time_limit(0);

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require_once '../vendor/autoload.php';

class Chat implements MessageComponentInterface {
	protected $clients;
	protected $users;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
		//$this->users[$conn->resourceId] = $conn;
		$connexionId = $conn->resourceId;

		try 
		{
		 	$bdd = new PDO('mysql:host=localhost; dbname=quizz; charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
		 	die('Erreur : ' . $e->getMessage());
		}

		$req = $bdd->prepare('INSERT INTO onlineuser (sessionId, pseudo, connexionId) VALUES (:sessionId, :pseudo, :connexionId);');
		$req->execute(array(
		'sessionId' => '',
		'pseudo' => '',
		'connexionId' => $connexionId
		));
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
		// unset($this->users[$conn->resourceId]);
		$disconnectedId = $conn->resourceId;

		try 
		{
		 	$bdd = new PDO('mysql:host=localhost; dbname=quizz; charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
		 	die('Erreur : ' . $e->getMessage());
		}

		$req = $bdd->prepare('SELECT pseudo FROM onlineuser WHERE connexionId = :connexionId');
		$req->execute(array(
		'connexionId' => $conn->resourceId
		));

		while ($donnees = $req->fetch())
		{
			$goodbyeMsg = '<center><p><b>' . $donnees['pseudo'] . '</b> vient de quitter le lobby</p><br /></center>';
			foreach($this->clients as $client)
			{
				$client->send(json_encode(array("type"=>'chat',"msg"=>$goodbyeMsg)));
			}
			$req2 = $bdd->prepare('DELETE FROM onlineuser WHERE connexionId = :connexionId');
			$req2->execute(array(
			'connexionId' => $conn->resourceId
			));
		}
	}

	public function onMessage(ConnectionInterface $from,  $data) {
		$from_id = $from->resourceId;
		$data = json_decode($data);
		$type = $data->type;
		switch ($type)
		{
			case 'chat':
				$user_id = $data->user_id;
				$chat_msg = $data->chat_msg;
				$response_from = '<p class="sendFrom"><b>' . $user_id . ': </b>' . $chat_msg . '</p><i class="dateFrom">' . date('d/m/Y') . ' à ' . date('H:i') . ' </i><br />';
				$response_to = '<p class="sendTo"><b>' . $user_id . ': </b>' . $chat_msg . '</p><i class="dateTo">' . date('d/m/Y') . ' à ' . date('H:i') . ' </i><br />';
				// Output
				$from->send(json_encode(array("type"=>$type,"msg"=>$response_from)));
				foreach($this->clients as $client)
				{
					if($from!=$client)
					{
						$client->send(json_encode(array("type"=>$type,"msg"=>$response_to)));
					}
				}
				break;

			case 'welcome':
				$user_id = $data->user_id;
				$chat_msg = $data->chat_msg;
				$sessionId = $data->sessionId;
				$connexionId = $from->resourceId;
				$welcomeMsg = 
				'<center><p><b>' . $user_id . '</b>' . $chat_msg . '</p><br /></center>';
				foreach($this->clients as $client)
				{
					$client->send(json_encode(array("type"=>$type,"msg"=>$welcomeMsg)));
				}

				try 
				{
				 	$bdd = new PDO('mysql:host=localhost; dbname=quizz; charset=utf8', 'root', '');
				}
				catch (Exception $e)
				{
				 	die('Erreur : ' . $e->getMessage());
				}

				$req = $bdd->prepare('UPDATE onlineuser SET sessionId = :sessionId, pseudo = :pseudo WHERE connexionId = :connexionId');
				$req->execute(array(
				'sessionId' => $sessionId,
				'pseudo' => $user_id,
				'connexionId' => $connexionId
				));
				
				break;
		}
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		$conn->close();
	}
}
$server = IoServer::factory(
	new HttpServer(new WsServer(new Chat())),
	8080
);
$server->run();
?>