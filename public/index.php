<?php
use Project\Controllers\{PagesController,AuthController};
use Project\Core\Application;

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


// Pages
$app->router->get('/',[PagesController::class, 'home']);
$app->router->get('/se-connecter', [PagesController::class, 'login']);
$app->router->get('/s-inscrire', [PagesController::class, 'register']);

// Connected user restricted access pages
$app->router->get('/mon-compte', [AuthController::class, 'profile']);
$app->router->get('/modifier-mon-compte', [AuthController::class, 'edit']);
$app->router->get('/publier', [PostController::class, 'create']);
$app->router->get('/mes-posts', [PostController::class, 'published']);
$app->router->get('/modifier-post/{id}', [PostController::class, 'update']);
$app->router->get('/supprimer-post/{id}', [PostController::class, 'delete']);

// Actions
$app->router->post('/se-connecter', [PagesController::class, 'login']);
$app->router->post('/s-inscrire', [PagesController::class, 'register']);

//  Connected user restricted actions
$app->router->post('/modifier-mon-compte', [AuthController::class, 'edit']);
$app->router->post('/se-deconnecter', [AuthController::class, 'logout']);
$app->router->post('/publier', [PostController::class, 'create']);
$app->router->post('/modifier-post/{id}', [PostController::class, 'update']);

$app->run();