<?php

namespace View;

class Response
{
    private $resources;

    public function __construct()
    {
        $this->resources = __DIR__ . '/../Resources/';
    }

    public function render($view, $parameters = [], $headers = [], $send = true)
    {
        $filename = $this->resources . $view;

        if (!file_exists($filename)) {
            return false;
        }

        $contents = file_get_contents($filename);

        foreach ($parameters as $key => $value) {
            $contents = str_replace('{% ' . $key . ' %}', $value, $contents);
        }

        if ($send) {
            foreach ($headers as $key => $value) {
                header($key . ': ' . $value);
            }
            echo $contents;
            exit;
        }

        return $contents;
    }

    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);

        return true;
    }
}
