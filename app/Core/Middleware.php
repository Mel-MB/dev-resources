<?php

namespace Project\Core;

abstract class Middleware{
    private array $actions;
    
    public function __construct(array $actions = []){
        $this->actions = $actions;
    }

    public abstract function execute();
}