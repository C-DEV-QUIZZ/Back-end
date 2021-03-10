<?php
    include '../class/ClassModelView.class.php';
    $adresseDistante ="https://quizz.servehttp.com/";
    $adresseLocal ="http://127.0.0.1:6969/";
    $route ="questions/modesolo";

    // recupérer le mode du client :
    // format { "mode" : valueInt }
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$modeActif = $request->mode;

    // si on est en mode solo (1) alors on 
    if($modeActif == 1){

        // interrogation de l'api en mode solo:


        $adresse = $adresseLocal . $route;

        // ************* Call API en get:
        
        // create & initialize a curl session
        $ch = curl_init();
        
        // set our url with curl_setopt()
        curl_setopt($ch, CURLOPT_URL, $adresse );
        
        
        //decommenter la ligne pour le post:
        // curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
        
        // return the transfer as a string, also with setopt()
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // recup json result
        $json = curl_exec($ch);

        // close http caller
        curl_close ($ch);

        // convert json string to an object (array or simple object)
        $questions = json_decode($json);

        // retour des questions au client :
        //$arr = array('chemin' => 'demarrage solo');
        //print_r(json_encode($arr));

        //print_r("test");

        $jsonResult = $questions;
    
        $arrayQuestionViewModel = array();

        foreach ($jsonResult as $jResult) {
            array_push($arrayQuestionViewModel, new QuestionViewModel($jResult));
        }

        print_r( json_encode($arrayQuestionViewModel));

    }
    else{    // si on est en mode multi (2) alors on redirige vers le serveur (controller) websocket 
        // qui s'occupe du reste.
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }

?>