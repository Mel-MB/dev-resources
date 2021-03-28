<?php 
namespace Project\Core;

class Controller{
    public string $action = '';
    protected array $middlewares = [];

    // View rendering methods
    public function render($view, $data = []): string{
        $layoutContent = $this->renderLayout($data);
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
    private function renderLayout($data = null): string{
        $data ?? [
            'title' => 'Partage de ressources Kercode',
            'description' => 'Le blog de partage et classification de ressources de étudiants de Kercode'
        ];

        //Allow view to use the passed in data as varibles
        foreach ($data as $key => $value){
            //Create a variable named by data's key variable and affect it to its value
            $$key = $value;
        }
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