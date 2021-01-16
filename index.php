<!DOCTYPE html>
<html>
	<head>
		<title>Connexion</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>

	<body>
		<div>

				<h1>Connectez-vous</h1><br /><br />
				<!--Comment l.16 and l.15 decomment for test for call api -->
				<!-- <form action="modeleCallApi.php" method="post"> -->
				<form action="realtime.php" method="post">
					<input type="text" id="pseudo" name="pseudo" required /><br /><br />
					<input type="submit" name="sendPseudo" id="sendPseudo" value="Connexion">
				</form>
	
		</div>

	</body>
</html>