<?php

namespace App\Classes\Http;

class Request
{
    private $method;
    private $params;

    private $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->params = $this->parseRequestParams();
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getUri() {
        return $this->uri;
    }

    private function parseRequestParams(): array
    {
        $params = [];

        if ($this->method === 'GET') {
            $params = $_GET;
        } elseif ($this->method === 'POST') {
            $params = $_POST;
        }

        return $params;
    }

    public function get($key = null) {
        if(is_null($key)) {
            return $_GET;
        }
        return array_key_exists($key, $_GET) ? $_GET[$key] : null;
    }

    public function post($key = null) {
        if(is_null($key)) {
            return $_POST;
        }
        return array_key_exists($key, $_POST) ? $_POST[$key] : null;
    }

}
