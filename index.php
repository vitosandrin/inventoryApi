<?php
require __DIR__.'/vendor/autoload.php';

date_default_timezone_set("America/Sao_Paulo");
header("Content-type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");

use App\Utils\Environment;
use App\Db\Database;
use App\Entity\Product;

Environment::load(__DIR__);

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT'),
    getenv('DB_DRIVER'),
);

$products = Product::getProduct($_GET['CicCodERP']);

print_r($products);