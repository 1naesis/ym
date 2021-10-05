<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/", name="starting_activity")
     */
    public function index(): Response
    {
        return $this->redirectToRoute("profile");
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('front/account/profile.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }


    /**
     * @Route("/register", name="register")
     */
    public function register(): Response
    {
        return $this->render('front/account/register.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('front/account/login.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
