<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RegistrationController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @return Response
     * @Route("/register", name="register")
     *
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('starting_activity');
        }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setUuid(time());
            $user->setNickname($user->getUuid());
            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $request->getSession()->set(Security::LAST_USERNAME, $user->getEmail());

            return $this->redirectToRoute('app_login');
        }
        $error = null;

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'error' => $error
        ]);
    }
}
