<?php
    // recupérer le mode du client :
    // format { "mode" : valueInt }
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$modeActif = $request->mode;


    echo $modeActif; 

// si on est en mode solo (1) alors on 
    // interrogation de l'api en mode solo:

    // retour des questions au client :
    $arr = array('retour' => 1);
    print_r(json_encode($arr));




// si on est en mode multi (2) alors on redirige vers le serveur (controller) websocket 
    // qui s'occupe du reste.

?>