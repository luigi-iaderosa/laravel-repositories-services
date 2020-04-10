<?php

namespace Tests\Unit;

use App\Services\PurchaseService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Article;
class PurchaseUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function purchase_logic()
    {

        $article = factory(Article::class)->create(['user_reserved'=>true]);
        $user = factory(User::class)->create();
        $purchaseService = new PurchaseService($user);
        $result = $purchaseService->purchase($article->id);
        $this->assertEquals($result,'OK');
    }
}
