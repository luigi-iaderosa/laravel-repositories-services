<?php

namespace Tests\Unit;

use App\Article;
use App\Repos\ArticleNoUserLoggedRepo;
use App\Repos\ArticleUserLoggedRepo;
use App\Services\ArticleNoUserLoggedService;
use App\Services\ArticleUserLoggedService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesBasicTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function articles_visible_by_auth_user()
    {
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        #Repo che preleva gli articoli visibili per l'utente autenticato

        $articleUserLoggedRepo = new ArticleUserLoggedRepo();
        $articleUserLoggedService = new ArticleUserLoggedService($articleUserLoggedRepo);
        $this->assertCount(2,$articleUserLoggedService->all());

    }

    /**
     * @test
     */
    public function articles_visible_by_foreigner()
    {
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        #Repo che preleva gli articoli visibili per l'utente autenticato

        $articleNoUserLoggedRepo = new ArticleNoUserLoggedRepo();
        $articleNoUserLoggedService = new ArticleNoUserLoggedService($articleNoUserLoggedRepo);
        $this->assertCount(1,$articleNoUserLoggedService->all());

    }

    /**
     * @test
     */
    public function reserved_article_visible_only_by_user()
    {
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $articleReserved = Article::where('user_reserved',true)->first();


        $articleUserLoggedRepo = new ArticleUserLoggedRepo();
        $articleUserLoggedService = new ArticleUserLoggedService($articleUserLoggedRepo);

        $article = $articleUserLoggedService->findById($articleReserved->id);
        $this->assertNotNull($article);
        $this->assertTrue(isset($article->user_reserved));

    }



    /**
     * @test
     */
    public function article_special_column_invisible_to_foreigner()
    {
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $articleNotReserved = Article::where('user_reserved',false)->first();

        $articleUserNoLoggedRepo = new ArticleNoUserLoggedRepo();
        $articleUserNoLoggedService = new ArticleUserLoggedService($articleUserNoLoggedRepo);

        $article = $articleUserNoLoggedService->findById($articleNotReserved->id);
        $this->assertNotNull($article);
        $this->assertTrue(!isset($article->user_reserved));

    }


    /**
     * @test
     */
    public function reserved_article_invisible_to_foreigner()
    {
        $this->withoutExceptionHandling();
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $articleReserved = Article::where('user_reserved',true)->first();

        $articleUserNoLoggedRepo = new ArticleNoUserLoggedRepo();
        $articleUserNoLoggedService = new ArticleUserLoggedService($articleUserNoLoggedRepo);

        $article = $articleUserNoLoggedService->findById($articleReserved->id);
        $this->assertNull($article);
    }

}
