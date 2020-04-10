<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 13.11
 */

namespace App\Repos;


use App\Article;

class ArticleUserLoggedRepo implements ArticleRepoInterface
{
    public function all()
    {
       return Article::all();
    }

    public function findById($articleId)
    {
        return Article::where('id',$articleId)->first();
    }


}