<?php

require_once __DIR__."/../../Database.php";

class Repository
{
    protected $databse;

    public function __construct()
    {
        $this->databse = new Database();
    }
}