<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 13.11
 */

namespace App\Repos;


use App\Article;

class ArticleNoUserLoggedRepo implements ArticleRepoInterface
{
    public function all()
    {
       return Article::where('user_reserved',false)->get();
    }

    public function findById($articleId)
    {
        return Article::where('user_reserved',false)->where('id',$articleId)->first(['id','description','price']);
    }
}