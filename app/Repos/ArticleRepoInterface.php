<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 13.10
 */

namespace App\Repos;


interface ArticleRepoInterface
{
    public function all();

    public function findById($articleId);


}