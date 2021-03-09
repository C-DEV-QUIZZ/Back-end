<?php
    $adresseLocal ="http://127.0.0.1:6969/";
    $route ="questions/modesolo";
    $adresse = $adresseLocal . $route;
    $postdata = file_get_contents("php://input");

    // $dataFake='[{"questionId":1,"reponseUtilisateurId":2},{"questionId":6,"reponseUtilisateurId":19}]';
    // $ListReponsesJoueur = json_decode($dataFake);
    $ListReponsesJoueur = json_decode($postdata);


    // tableau envoyé a l'api pour recuperer les questions.
    $IdQuestions = array();

    // boucle sur tous les resultat 
    // stocker les id des questions dans le tableau 
    foreach ($ListReponsesJoueur as $reponseJoueur ) {
        array_push($IdQuestions, $reponseJoueur->questionId);
    }

    // envoyer le tableau à l'api 
    $ch = curl_init('http://127.0.0.1:6969/questions/QuestionResult');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($IdQuestions));
    $json = curl_exec($ch);
    curl_close ($ch);
    // convert json string to an object (array or simple object)
    $AllQuestionsApi = json_decode($json);



    // print_r($ListReponsesJoueur);

    // recupere l'id de la premier questions :

    
    // print_r("<br><br>");
    // print_r("<br><br>");

    // $IdQuestionJoueur= $ListReponsesJoueur[0]->questionId;
    // print_r($IdQuestionJoueur);    
    // print_r("<br><br>");        
    // $IdReponseJoueur= $ListReponsesJoueur[0]->reponseUtilisateurId;
    // print_r($IdReponseJoueur);    

    // print_r("<br><br>");
    // print_r("<br><br>");
    // print_r("<br><br>");
    // print_r("====================================");
    // print_r("<br><br>");
    // print_r("<br><br>");
    // print_r("<br><br>");
    // print_r("<br><br>");
    // print_r("<br><br>");

    $nbPointJoueur =0;

    // fait le tour des reponses du joueur 
    foreach ($ListReponsesJoueur as $Reponse) {

        // recupere l'id de sa question et l'id de sa réponse
        $IdQuestionJoueur= $Reponse->questionId;
        $IdReponseJoueur= $Reponse->reponseUtilisateurId;

        // recherche dans les questions de l'api si le joueur a la bonne réponse :
        foreach ($AllQuestionsApi as $QuestionsApi) {
            // print_r($QuestionsApi);

            if($QuestionsApi->id == $IdQuestionJoueur)
            {
                // print_r("La reponse pour la question :" . $QuestionsApi->id . " est " . $QuestionsApi->bonneReponse-> id);
                // print_r("<br><br>");

                if($IdReponseJoueur == $QuestionsApi->bonneReponse-> id)
                {
                    // print_r("bonne reponse question :" . $QuestionsApi->id . " => +". $QuestionsApi->points ." points");
                    // print_r("<br><br>");

                    $nbPointJoueur = $nbPointJoueur +$QuestionsApi->points;
                }
                // print_r("<br><br>");
            }

        }
    }

    // print_r("<br><br>");
    // print_r($nbPointJoueur);
    // print_r("<br><br>");


    // on va renvoyé au mode solo la localisation 
    $arr = array('points' => $nbPointJoueur);
    print_r(json_encode($arr));
?>