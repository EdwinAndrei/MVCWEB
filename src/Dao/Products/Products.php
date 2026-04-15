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

  public static function getProductById(int $productId)
  {
    $sqlstr = "SELECT productId, productName, productDescription, productPrice, productImgUrl, productStock, productStatus FROM products WHERE productId = :productId";
    $params = ["productId" => $productId];
    return self::obtenerUnRegistro($sqlstr, $params);
  }

  public static function insertProduct(string $productName, string $productDescription, float $productPrice, string $productImgUrl, int $productStock, string $productStatus)
  {
    $sqlstr = "INSERT INTO products(productName, productDescription, productPrice, productImgUrl, productStock, productStatus) VALUES
                    (:productName, :productDescription, :productPrice, :productImgUrl, :productStock, :productStatus)";
    $params = [
      "productName" => $productName,
      "productDescription" => $productDescription,
      "productPrice" => $productPrice,
      "productImgUrl" => $productImgUrl,
      "productStock" => $productStock,
      "productStatus" => $productStatus
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function updateProduct(int $productId, string $productName, string $productDescription, float $productPrice, string $productImgUrl, int $productStock, string $productStatus)
  {
    $sqlstr = "UPDATE products SET
                    productName = :productName,
                    productDescription = :productDescription,
                    productPrice = :productPrice,
                    productImgUrl = :productImgUrl,
                    productStock = :productStock,
                    productStatus = :productStatus
                   WHERE productId = :productId";
    $params = [
      "productId" => $productId,
      "productName" => $productName,
      "productDescription" => $productDescription,
      "productPrice" => $productPrice,
      "productImgUrl" => $productImgUrl,
      "productStock" => $productStock,
      "productStatus" => $productStatus
    ];
    return self::executeNonQuery($sqlstr, $params);
  }

  public static function deleteProduct(int $productId)
  {
    $sqlstr = "DELETE FROM products WHERE productId = :productId";
    $params = ["productId" => $productId];
    return self::executeNonQuery($sqlstr, $params);
  }





  public static function reduceStock(int $productId, int $quantity): bool
  {
    $sqlstr = "UPDATE products 
               SET productStock = productStock - :quantity
               WHERE productId = :productId AND productStock >= :quantity";

    return self::executeNonQuery($sqlstr, [
      "productId" => $productId,
      "quantity" => $quantity
    ]);
  }


  public static function increaseStock(int $productId, int $quantity): bool
  {
    $sqlstr = "UPDATE products 
               SET productStock = productStock + :quantity
               WHERE productId = :productId";

    return self::executeNonQuery($sqlstr, [
      "productId" => $productId,
      "quantity" => $quantity
    ]);
  }
}