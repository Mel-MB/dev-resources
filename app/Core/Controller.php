<?php 
namespace Project\Core;

class Controller{
    public string $action = '';
    protected array $middlewares = [];

    public static string $title = 'Partage de ressources Kercode';
    public static string $description = 'Le blog de partage et classification de ressources des étudiants de Kercode';


    // View rendering methods
    public static function render($view, $data = []): string{
        $layoutContent = self::renderLayout($data['title'] ?? $data['title'] = self::$title, $data['description'] ?? $data['description'] = self::$description);
        $viewContent = self::renderContent($view,$data);

        return str_replace('{{-content-}}',$viewContent,$layoutContent); 
    }
    public static function renderContent($view, array $data = []): string{
        //Allow view to use the passed in data as varibles
        foreach ($data as $key => $value){
            //Create a variable named by its key variable and affect it to its value
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/$view.php";
        return ob_get_clean();
    }
    private static function renderLayout($title, $description): string{
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