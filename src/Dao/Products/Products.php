<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    public static function getProducts()
    {
        $sqlstr = "SELECT productId, productName, productDescription, productPrice, productImgUrl, productStock, productStatus FROM products ORDER BY productId DESC;";
        $params = [];
        return self::obtenerRegistros($sqlstr, $params);
    }
}
