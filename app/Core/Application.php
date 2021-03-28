<?php
namespace Project\Core;
use  Project\Core\{Response,Request,Router,Database,Manager,Entity};
use Project\Entities\User;

class Application{

    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Session $session;
    public Response $response;
    public Controller $controller;

    public Database $db;
    private $userModel;

    public ?User $user;

    public function __construct($rootPath,array $config){
        self::$ROOT_DIR     = $rootPath;
        self::$app          = $this; //allows to call actual instance of class app anywhere
        $this->request      = new Request();
        $this->response     = new Response();
        $this->router       = new Router($this->request,$this->response);
        $this->db           = new Database($config['db']);
        $this->userModel    = $config['userEntity']();

        $this->session      = new Session();
        $this->user         = $this->connected();

    }

    // Complementary instantiation methods
    private function connected(){
        $identifierValue = $this->session->get('user');
        if($identifierValue){
            return $this->userModel::newInstanceFromPrimaryKey($identifierValue);
        }else{
            return null;
        }
    }
    public function setController(Controller $controller){
        $this->controller   = $controller;
    }

    //Session related methods
    public static function isGuest(): bool{
        return !self::$app->user;
    }
    public function login(Entity $user): void{
        $this->user = $user;
    }
    public function logout(): void{
        $this->user = null;
        $this->session->remove('user');
    }

    // Router exceptions handdling
    public function run(){
        try{
            echo $this->router->resolve();
        } catch( \Exception $e) {
            $this->response->setStatusCode($e->getCode());
            $this->setController(new Controller());
            echo $this->controller->render('error', ['exception' => $e]);
        }
    }
}