<?php


namespace Core;

use Core\Request\Request;

class Controller
{
    /**
     * @var Request
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function view(string $viewName, array $params = [])
    {
        foreach ($params as $key => $value) {
            ${$key} = $value;
        }

        ob_start();
        require App::path("views/{$viewName}.php");
        $content = ob_get_clean();
        require App::path('views/layout.php');
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

}
