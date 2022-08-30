<?php

namespace App\Entity;

use App\Db\Database;
use \PDO;

class Product
{

    /**
     * Id do produto
     * @var string
     */
    public $id;

    /**
     * Nome do produto
     * @var string
     */
    public $nome;

    /**
     * Quantidade no estoque geral
     * @var int
     */
    public $estoque;

    /**
     * Reserva no estoque geral
     * @var string(s/n)
     */
    public $upEstoque = 'S';

    /**
     * Método responsável por retornar todos os produtos do BD
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getProducts($where = null, $order = null, $limit = null)
    {
        return (new Database('dbo.TRN699'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por buscar um produto com base na sua flag de reserva
     * @param string $upEstoque - $CicIndUpdE
     * @return Product
     */
    public static function getProduct($CicCodERP)
    {
        return (new Database('dbo.TRN699'))->select('id = '.$CicCodERP)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
