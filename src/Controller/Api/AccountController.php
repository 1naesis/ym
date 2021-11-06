<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/api/account/register", name="api_account_register")
     */
    public function register(Request $request): Response
    {
        return $this->json([
            'body' => $request->request->all(),
            'code' => 200,
            'status' => 'OK'
        ]);
    }
}
