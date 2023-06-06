<?php

namespace App\Controllers;

use App\Classes\DB\Database;
use App\Classes\Http\Request;

abstract class BaseController
{

    protected Database $database;

    protected Request $request;

    public function __construct()
    {
        global $request;
        $this->database = Database::getInstance();
        $this->request = $request;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

}