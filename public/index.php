<?php
use Project\Controllers\{PagesController,AuthController};
use Project\Core\{Application};


require_once(__DIR__.'/../vendor/autoload.php');
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config =[
    'db' => [
        'dsn' =>$_ENV['DB_DSN'],
        'user' =>$_ENV['DB_USER'],
        'password' =>$_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__),$config);

$app->router->get('/', [PagesController::class, 'home']);
$app->router->get('/se-connecter', [AuthController::class, 'login']);
$app->router->post('/se-connecter', [AuthController::class, 'login']);
$app->router->get('/s-inscrire', [AuthController::class, 'register']);
$app->router->post('/s-inscrire', [AuthController::class, 'register']);

$app->run();