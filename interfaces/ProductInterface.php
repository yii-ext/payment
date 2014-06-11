<?php
namespace \yii_ext\payment\interfaces;


/**
 * Interface ProductInterface
 * @package payment\interfaces
 */
interface ProductInterface
{
    /**
     * @return mixed
     */
    public function createProduct();

    /**
     * @param $productId
     *
     * @return mixed
     */
    public function viewProduct($productId);

    /**
     * @param $productId
     *
     * @return mixed
     */
    public function updateProduct($productId);

    /**
     * @param $productId
     *
     * @return mixed
     */
    public function deleteProduct($productId);

    /**
     * @param $productId
     *
     * @return mixed
     */
    public function getProductPrice($productId);
}
