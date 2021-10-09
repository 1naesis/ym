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
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        } else {
            return $this->redirectToRoute("app_login");
        }
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('starting_activity');
        }
        $user = $this->getUser();
        return $this->render('front/account/profile.html.twig', [
            'user' => $user,
        ]);
    }

//    /**
//     * @Route("/register", name="register")
//     */
//    public function register(): Response
//    {
//        return $this->render('front/account/register.html.twig', [
//            'controller_name' => 'AccountController',
//        ]);
//    }

//    /**
//     * @Route("/login", name="login")
//     */
//    public function login(): Response
//    {
//        return $this->render('front/account/login.html.twig', [
//            'controller_name' => 'AccountController',
//        ]);
//    }
}
