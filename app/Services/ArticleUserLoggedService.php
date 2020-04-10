<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 13.03
 */

namespace App\Services;


use App\Repos\ArticleRepoInterface;

class ArticleUserLoggedService implements ArticleServiceInterface
{

    private $articleRepo;
    public function __construct(ArticleRepoInterface $articleRepo)
    {
        $this->articleRepo = $articleRepo;

    }

    public function all()
    {
        return $this->articleRepo->all();
    }


    public function findById($articleId)
    {
        return $this->articleRepo->findById($articleId);
    }
}