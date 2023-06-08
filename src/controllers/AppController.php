<?php

class AppController {
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER["REQUEST_METHOD"];
    }

    protected function isGet(): bool
    {
        return $this->request === "GET";
    }

    protected function isPost(): bool
    {
        return $this->request === "POST";
    }

    protected function isPut(): bool
    {
        return $this->request === "PUT";
    }

    protected function isDelete(): bool
    {
        return $this->request === "DELETE";
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = "public/views/".$template.".php";
        $output = "<h1>Not found</h1>";

        if(file_exists($templatePath))
        {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }

}