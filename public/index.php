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
    ],
    'userEntity' => Project\Entities\User::class,
];
$app = new Application(dirname(__DIR__),$config);


// Pages
$app->router->get('/','home');
// User related pages
$app->router->get('/se-connecter', [AuthController::class, 'login']);
$app->router->get('/s-inscrire', [AuthController::class, 'register']);
$app->router->get('/mon-profil', [AuthController::class, 'profile']);

// Posts related pages
$app->router->get('/publier', [PostController::class, 'create']);
$app->router->get('/mes-posts', [PostController::class, 'published']);
$app->router->get('/modifier-post/{id}', [PostController::class, 'update']);
$app->router->get('/supprimer-post/{id}', [PostController::class, 'delete']);

// Actions
// User related actions
$app->router->post('/se-connecter', [AuthController::class, 'login']);
$app->router->post('/s-inscrire', [AuthController::class, 'register']);
$app->router->post('/se-deconnecter', [AuthController::class, 'logout']);
// Post related actions
$app->router->post('/publier', [PostController::class, 'create']);
$app->router->post('/modifier-post/{id}', [PostController::class, 'update']);

$app->run();