<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Article;
class PurchaseFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function purchase_route_working_with_auth_user()
    {


        $this->withoutExceptionHandling();
        $article = factory(Article::class)->create(['user_reserved'=>true]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('purchase/'.$article->id);
        $response->assertStatus(200);
        $resultString = $response->getOriginalContent();
        $this->assertEquals($resultString,'OK');

    }

    /**
     * @test
     */
    public function purchase_route_not_working_with_unauthenticated()
    {

        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);
        $article = factory(Article::class)->create(['user_reserved'=>true]);

        $this->get('purchase/'.$article->id);


    }





}
