<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 13.02
 */

namespace App\Services;


interface ArticleServiceInterface
{
    public function all();
    public function findById($articleId);
}