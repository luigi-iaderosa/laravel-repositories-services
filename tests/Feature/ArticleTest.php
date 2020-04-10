<?php

namespace Tests\Feature;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ArticleTest extends TestCase
{


    use RefreshDatabase;
    /**
     * @test
     */
    public function logged_user_sees_all_articles()
    {


        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $this->assertCount(2,$response->getOriginalContent());

    }


    /**
     * @test
     */
    public function no_logged_user_sees_only_non_reserved_articles()
    {


        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $this->withoutExceptionHandling();

        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertCount(1,$response->getOriginalContent());

    }



    /**
     * @test
     */
    public function reserved_article_visible_only_by_logged_user()
    {
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $articleReserved = Article::where('user_reserved',true)->first();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('article/'.$articleReserved->id);
        $this->assertEquals($articleReserved->id,$response->getOriginalContent()->id);
        $this->assertTrue(isset($response->getOriginalContent()->discount_user_visible));
    }


    /**
     * @test
     */
    public function article_special_column_invisible_if_not_logged_in()
    {
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $articleNotReserved = Article::where('user_reserved',false)->first();
        $response = $this->get('article/'.$articleNotReserved->id);
        $this->assertEquals($articleNotReserved->id,$response->getOriginalContent()->id);
        $this->assertTrue(!isset($response->getOriginalContent()->discount_user_visible));

    }


    /**
     * @test
     */
    public function reserved_article_invisible_if_not_logged_in()
    {
        $this->withoutExceptionHandling();
        factory(Article::class)->create(['user_reserved'=>true]);
        factory(Article::class)->create(['user_reserved'=>false]);

        $articleReserved = Article::where('user_reserved',true)->first();
        $response = $this->get('article/'.$articleReserved->id);
        $this->assertNull($response->getOriginalContent());
    }




}
