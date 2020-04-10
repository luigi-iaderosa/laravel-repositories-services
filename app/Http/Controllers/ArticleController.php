<?php

namespace App\Http\Controllers;

use App\Services\ArticleServiceInterface;
use App\Services\PurchaseServiceInterface;
use Illuminate\Http\Request;

class ArticleController extends Controller
{


    private $articleService;
    private $purchaseService;
    public function __construct(ArticleServiceInterface $articleService,PurchaseServiceInterface $purchaseService)
    {
       $this->articleService = $articleService;
       $this->purchaseService = $purchaseService;
    }


    public function all(){

        return $this->articleService->all();
    }

    public function show($id){
        return $this->articleService->findById($id);
    }

    public function purchase($id){
        return $this->purchaseService->purchase($id);
    }



}
