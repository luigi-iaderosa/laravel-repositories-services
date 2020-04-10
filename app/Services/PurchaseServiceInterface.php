<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 17.48
 */

namespace App\Services;


interface PurchaseServiceInterface
{
    public function purchase($articleId);
}