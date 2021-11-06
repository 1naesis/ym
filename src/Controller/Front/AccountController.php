<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/setting", name="setting")
     */
    public function info(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('starting_activity');
        }

        $user = $this->getUser();
        return $this->render('front/account/setting.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/friends", name="friends")
     */
    public function friends(Request $request, UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('starting_activity');
        }

        $listUsers = null;
        $search = '';
        if ($request->query->has('find')) {
            $search = trim($request->query->get('find'));
            $listUsers = $userRepository->findUsersLike($search);
        }

        $user = $this->getUser();
        return $this->render('front/account/friends.html.twig', [
            'user' => $user,
            'listUsers' => $listUsers,
            'search' => $search
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
