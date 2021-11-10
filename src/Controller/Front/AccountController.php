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
     * @Route("/game", name="game")
     */
    public function game(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('starting_activity');
        }
        $invite = "not invite";
        if ($request->query->has('invite') && !empty(trim($request->query->get('invite')))) {
            $invite = trim($request->query->get('invite'));
        }
        return $this->redirect("http://192.168.0.8:3000");
        return new Response("<h2>GameZone с $invite</h2>");
//        return $this->render('front/account/messenger.html.twig',[
//
//        ]);
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

        $user = $this->getUser();

        $listUsers = null;
        $search = '';
        if ($request->query->has('find') && !empty(trim($request->query->get('find')))) {
            $search = trim($request->query->get('find'));
            $listUsers = $userRepository->findUsersLike($search, $user);
        } else if ($request->query->has('add') && !empty(trim($request->query->get('add')))) {
            $newUuid = trim($request->query->get('add'));
            $userRepository->addFriend($newUuid, $user);
        } else if ($request->query->has('remove') && !empty(trim($request->query->get('remove')))) {
            $removeUuid = trim($request->query->get('remove'));
            $userRepository->removeFriend($removeUuid, $user);
        }
        $friends = $userRepository->findFriendsByUser($user);

        return $this->render('front/account/friends.html.twig', [
            'user' => $user,
            'listUsers' => $listUsers,
            'search' => $search,
            'friends' => $friends
        ]);
    }

    /**
     * @Route("/messenger", name="messenger")
     */
    public function messenger(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('starting_activity');
        }
        return $this->render('front/account/messenger.html.twig',[
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
