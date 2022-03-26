<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use App\Service\Security\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/signup", name="security_signup")
     */
    public function signUp(Request $request, EntityManagerInterface $manager, PasswordService $pass): Response{
        $user = new User();

        $form = $this->createForm(SignUpType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //--setup des datas non renseignées
            $user->setRoles(["ROLE_USER"]);
            $user->setIsValidate(false);

            //--hash Password
            $user->setPassword($pass->hashPassword($user));
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }
        

        return $this->render('security/signUp.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("bo_dashboard");
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){}
}
