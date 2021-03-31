<?php 
namespace Project\Core;

class Controller{
    public string $action = '';
    protected array $middlewares = [];

    private string $title = 'Partage de ressources Kercode';
    private string $description = 'Le blog de partage et classification de ressources de étudiants de Kercode';


    // View rendering methods
    public function render($view, $data = []): string{
        $layoutContent = $this->renderLayout($data['title']??null, $data['description']??null);
        $viewContent = $this->renderContent($view,$data);
         
        return str_replace('{{-content-}}',$viewContent,$layoutContent); 
    }
    public function renderContent($view, array $data = []): string{
        //Allow view to use the passed in data as varibles
        foreach ($data as $key => $value){
            //Create a variable named by its key variable and affect it to its value
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/$view.php";
        return ob_get_clean();
    }
    private function renderLayout($title, $description): string{
        if(!$title) $title = $this->title;
        if(!$description) $description = $this->description;
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/layouts/main.php";
        return ob_get_clean();
    }

    public function registerMiddleware(Middleware $middleware): void{
        $this->middlewares[] = $middleware;
    }
    public function getMiddlewares(): array{
        return $this->middlewares;
    }
}