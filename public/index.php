<?php

include_once __DIR__ . "/../vendor/autoload.php"; 
use app\model\Crud;
use app\helper\Helper;


Helper::dd(parse_url($_SERVER['REQUEST_URI']));