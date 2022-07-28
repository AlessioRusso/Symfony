<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\User;
use App\Entity\Video;
use App\Services\GiftsService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Zend\Crypt\Exception\NotFoundException;

use App\DataFixtures\AppFixtures;
class DefaultController extends Controller
{

    public function __construct($logger){

    }


    /**
     * 
     * @Route("/Followers", name="followers")
     */
    public function followers(){
        $entityManager = $this->getDoctrine()->getManager();

        
        $user = new User();
        $user->setName("Alessio");
        $entityManager->persist($user);
        $entityManager->flush();

        $user = new User();
        $user->setName("Robert");
        $entityManager->persist($user);
        $entityManager->flush();


        $user = new User();
        $user->setName("Alex");
        $entityManager->persist($user);
        $entityManager->flush();

        exit('A new user was saved with the id of'.$user->getId());

    }


    /**
     * @Route("/default", name="default")
     */
    public function index()
    {   
        dump('abc');
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
        ]);
    }


    /**
     * 
     * @Route("/User", name="create-user")
     */
    public function create_user(){
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName("Alessio");
        $entityManager->persist($user);
        $entityManager->flush();

        exit('A new user was saved with the id of'.$user->getId());

    }

    /**
     * 
     * @Route("/UserVideos", name="create-user-videos")
     */
    public function create_user_videos(){
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName("Alessio");
      
        for($i=1; $i<=3; $i++)
        {
            $video = new Video();
            $video->setTitle('title - '.$i);
            $user->addVideo($video);
            $entityManager->persist($video);

        }
        $entityManager->persist($user);
        $entityManager->flush();
        dump($user);
    }


    /**
     * 
     * @Route("/Videos/{id}", name="get-videos-user")
     */
    public function get_videos_user($id){
        $repository = $this->getDoctrine()->getRepository(Video::class);
        
        $videos = $repository->findBy(['user' => $id]);
        $res='';
        foreach($videos as $video){
            $res=$res.$video->getUser()->getName();
        }
        exit($res);
    }

    /**
     * 
     * @Route("/User/{id}", name="get_user_by_id")
     * 
     */
    public function get_user_by_id($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findWithVideos($id);
        dump($user);
    }


    /**
     *@Route("/UpdateUser/{id}", name="update_user_by_id") 
     */
    public function update_user_by_id($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);

        if(!$user)
        {
            throw $this->createNotFoundException('User not_exist');
        }

        $user->setName("New name");
        $entityManager->persist($user);
        $entityManager->flush();
        exit($user->getName());
    }

    // /**
    //  * @Route("/raw-query/", name="raw_query")
    //  */

    //  public function raw_query()
    //  {
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $conn = $entityManager->getConnection();
    //     $sql = '
    //         SELECT * FROM user
    //         Where user.id > :id
    //     ';

    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute(['id' => 3]);
    //     exit('exec');
    //  }

    /**
     * @Route("/DeleteUser/{id}", name = "delete_user")
     */
    public function delete_user($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);

        if(!$user){
            $this->createNotFoundException("User does not exist");
        }

        $entityManager->remove($user);
        $entityManager->flush();
        exit('User deleted');
    }


    /**
     * @Route("/param-converter/{id}", name = "param_converter")
     */
    public function param_converter(User $user)
    {
        exit($user->getName());
    }
    

    /**
     * @Route("/Videos", name="videos")
     */
    public function getVideos()
    {
        
        $videos = $this->getDoctrine()->getRepository(Video::class)->findAll();

        if(!$videos)
        {
            throw $this->createNotFoundException('The videos do not exist');

        }
        dump($videos);                
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
