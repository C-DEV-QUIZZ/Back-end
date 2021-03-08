
<?php
    // recupérer le mode du client :
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$modeActif = $request->mode;

    // si on est en mode solo (1) alors on 
    if($modeActif == 1){

        $arr = array('chemin' => 'demarrage-solo');
        print_r(json_encode($arr));

    }
    else{    // si on est en mode multi (2) alors on redirige vers le serveur (controller) websocket 
        // qui s'occupe du reste.
        $arr = array('chemin' => 'salle-attente');
        print_r(json_encode($arr));
    }

?>