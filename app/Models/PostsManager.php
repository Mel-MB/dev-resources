<?php

namespace Project\Models;

class PostsManager extends Manager {
    public function __construct(){
        $this->db = $this->dbConnect();
    }
    public function postCreate(){
        
    }
}