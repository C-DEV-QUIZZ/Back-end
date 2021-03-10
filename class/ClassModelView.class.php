<?php

    class QuestionViewModel
    {
        public $id;
        public $texte ;
        public $points ;
        public $reponses = array(); 
        public function __construct($JsonResult)
        {
            $this->id = $JsonResult->id;
            $this->texte = $JsonResult->texte;
            $this->points = $JsonResult->points;

            foreach ($JsonResult->reponses as $reponse) {
                array_push($this->reponses,new ReponseViewModel($reponse));
            }
        }

    }

    class ReponseViewModel
    {
        public $id;
        public $texte;

        public function __construct($reponses)
        {
            $this->id = $reponses->id;
            $this->texte = $reponses->texte;
        }

    }
?>