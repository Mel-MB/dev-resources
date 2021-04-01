<?php

namespace Project\Core\Exceptions;

class NotFoundException extends \Exception{
    protected $code = 404;
    protected $message = "Cette page n'existe pas";
    
    public string $redirectLink = "/";
    public string $redirectLinkTitle = "Retour à la page d'accueil";
}