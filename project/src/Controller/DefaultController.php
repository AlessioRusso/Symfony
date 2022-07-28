<?php

namespace App\Controller;

use App\Entity\SecurityUser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Form\RegisterUserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends Controller
{

    public function __construct($logger){

    }


    /**
     * @Route("/default", name="default")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $users = $entityManager->getRepository(SecurityUser::class)->findAll();
        dump($users);
        $user = new SecurityUser();
        $form = $this->createForm(RegisterUserType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            $user->setEmail($form->get('email')->getData());

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('default');
        }

        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

}
