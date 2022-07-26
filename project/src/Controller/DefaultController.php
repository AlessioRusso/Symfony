<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\User;

use App\Services\GiftsService;


class DefaultController extends Controller
{

    public function __construct($logger){

    }


    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = new User;
        $user->setName('Adam');
       
        $user2 = new User;
        $user2->setName('Robert');
       
        $user3 = new User;
        $user3->setName('John');
        
        $user4 = new User;
        $user4->setName('Susan');

        $entityManager->persist($user);
        $entityManager->persist($user2);
        $entityManager->persist($user3);
        $entityManager->persist($user4);

        exit($entityManager->flush());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
        ]);
    }

    /**
     * @Route("/Users", name="users")
     */
    public function getUsers(GiftsService $gifts, Request $request)
    {
        
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        if(!$users)
        {
            throw $this->createNotFoundException('The users do not exist');

        }
        

        // $this->addFlash(
        //     'notice',
        //     'Your changes were saved!'
        // );
        
        // $this->addFlash(
        //     'warning',
        //     'Your changes were saved!' 
        // );
        

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'random_gift' => $gifts->gifts,
        ]);
    }


    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */

     public function index2()
     {
        return new Response('Optional parameters in url and requirements for parameters');
     }

     /**
      * @Route(
      *         "/articles/{_locale}/{years}/{slug}/{category}",
      *         name= "article_list",
      *          defaults= {"category": "computers"},  
      *          requirements={
      *             "_locale": "en|fr",
      *             "category": "computers|rtv",
      *             "year": "\d+"
      *             }
      * )            
      */
      public function index3()
      {
        return new Response('An advanced route example');
      }


      /**
       * 
       * @Route("/generate-url/{params?}", name="generate_url")
       * 
       */

       public function generate_url()
       {
        exit($this->generate_url(
            'generate_url',
            array('param' => 10),
            //UrlGeneratorInterface::ABSOLUTE_URL
        ));
       }

       /**
        * @Route("/download")
        * 
        */

        public function download()
        {
            $path = $this->getParameter('download_directory');
            return $this->file($path.'file.pdf');
        }

        
        /**
        * @Route("/redirect-test")
        * 
        */
        public function redirectTest()
        {
            return $this->redirectToRoute('route_to_redirect', array('param'=>10));
        }

         /**
        * @Route("/url_to_redirect/{param?}", name="route_to_redirect")
        * 
        */
        public function route_to_redirect()
        {
            exit('redirection');
        }

        /**
        * @Route("/forwarding-to-controller")
        * 
        */
        public function forwarding()
        {
            $response = $this->forward(
                'App\Controller\DefaultController::methodToForwardTo',
                array('param' => '1')
            );

            return $response;
        }

        /**
        * @Route("/url-to-forward-to/{param?}", name="route_to_forward_to")
        * 
        */
        public function methodToForwardTo($param)
        {
            exit('Test controller forwarding - '.$param);
        }



}
