<?php
use Project\Controllers\{PagesController,AuthController, PostsController};
use Project\Core\Application;

$config =[
    'db' => [
        'dsn' => "mysql:host=localhost:3306;dbname=ywst1652_dev-ressources;charset=utf8",
        'user' => "dbadmin",
        'password' =>"8sekpBIdVve0",
    ],
    'controllers' => [
        'post' => Project\Controllers\PostsController::class
    ]
];
$app = new Application(dirname(__DIR__),$config);


// Pages
$app->router->get('/',[PagesController::class, 'home']);
$app->router->get('/se-connecter', [PagesController::class, 'login']);
$app->router->get('/s-inscrire', [PagesController::class, 'register']);
$app->router->get('/posts/{string $tag_name}', [PagesController::class, 'category']);

// Authentified user restricted access pages
$app->router->get('/mon-compte', [AuthController::class, 'profile']);
$app->router->get('/modifier-mon-compte', [AuthController::class, 'edit']);
$app->router->get('/post/publier', "create");
$app->router->get('/mes-posts', [PostsController::class, 'userPublished']);
$app->router->get('/post/modifier/{int $id}', 'update');


// Actions
$app->router->post('/se-connecter', [PagesController::class, 'login']);
$app->router->post('/s-inscrire', [PagesController::class, 'register']);
$app->router->post('/rechercher', [PostsController::class, 'search']);

//  Authentified user restricted actions
$app->router->post('/modifier-mon-compte', [AuthController::class, 'edit']);
$app->router->post('/supprimer-mon-compte', [AuthController::class, 'delete']);
$app->router->post('/se-deconnecter', [AuthController::class, 'logout']);
$app->router->post('/post/tags', 'getTags');
$app->router->post('/post/publier', 'create');
$app->router->post('/post/modifier/{int $id}', 'update');
$app->router->post('/post/supprimer/{int $id}', 'delete');

$app->run();