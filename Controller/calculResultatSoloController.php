<?php

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

//recupere l'id de la premiere questions et la reponse donne par le joueur
//print_r($request[0]->questionId);
//print_r($request[0]->reponseUtilisateurId);

/*
    [ 
        {questionsId = 1 , reponseUtilisateurId=5} , 
        {questionsId = 2 , reponseUtilisateurId=10} , 
    ]

*/

// boulcer sur tous les resultat 
// stocker les id des questions dans une liste 
// envoyer cette liste a l'api 

// une fois la reponse :
// on compare les reponses utilisateurs avec les bonne réponse des questions
// a chaque fois qu'il a une bonne réponse on incremente une variable avec le bombre de point de la question.
foreach($request as $reponse)
{
    print_r($reponse->questionId);
}




//@$resultatQuestion = $request->mode;




// on va renvoyé au mode solo la localisation 
$arr = array('chemin' => 'resultatSolo');

?>