<?php
/**
 * Created by PhpStorm.
 * User: alceste
 * Date: 09/04/20
 * Time: 17.48
 */

namespace App\Services;


class PurchaseService implements PurchaseServiceInterface
{

    private $user;
    public function __construct($user)
    {
        $this->user = $user;
    }


    public function purchase($articleId)
    {
        if (!$this->user){
            throw new \Exception('User is null on auth-protected route!');
        }

        return 'OK';
    }
}