<?php

namespace Project\Controllers;

use Project\Core\{Application, Controller, Request};

class PagesController extends Controller{
    public function home(){
        $data = [
            'title' => 'Partage de ressources Kercode',
            'description' => 'Le blog de partage et classification de ressources de étudiants de Kercode'
        ];

        return $this->render('front/home',$data);
    }

}