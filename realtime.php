<?php
session_start();
$sessionId = session_id();
$pseudo = $_POST['pseudo'];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Real time</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>

	<body>
		<input type="hidden" id="pseudoUser" value="<?php echo $pseudo; ?>"/>
		<input type="hidden" id="sessionId" value="<?php echo $sessionId; ?>"/>

		<div id="wrapper">

			<div id="lobby">
				<div id="waitingRoom">
				</div>

				<button id="lobbyReady">Ready</button>
			</div>

			<div id="chat">
				<div id="chat_output">
				</div>

				<textarea id="chat_input" placeholder="Votre message..."></textarea>
			</div>

		</div>
		
	</body>
</html>