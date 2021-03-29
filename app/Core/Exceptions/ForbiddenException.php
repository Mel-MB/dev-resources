<?php

namespace Project\Core\Exceptions;

class ForbiddenException extends \Exception{
    protected $code = 403;
    protected $message = "Vous n'avez pas accès à cette page";

    public string $redirectLink = "/se-connecter";
}