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
    public static function getProductReserved()
    {
        return (new Database('dbo.TRN699'))->selectOnlyReserved()
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por cadastrar um produto no BD
     * @return boolean
     */
    public function cadastrar()
    {
        //INSERIR DADO NO BANCO
        $obDatabase = new Database('dbo.TRN699');
        $this->id = $obDatabase->insert([
            'field'    => $this->field,
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar um campo no DB
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('dbo.TRN699'))->update('CicCodERP = ' . $this->id, [
            'field'    => $this->field,
        ]);
    }

    /**
     * Método responsável por excluir o produto do DB
     * @return boolean
     */
    public function excluir()
    {
        return (new Database('dbo.TRN699'))->delete('CicCodERP = ' . $this->id);
    }
}
