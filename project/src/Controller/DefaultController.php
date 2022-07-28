<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\Video;

use App\Events\VideoCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Form\VideoFormType;

use App\Services\GiftsService;
use DateTime;

class DefaultController extends Controller
{

    public function __construct($logger, EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }


    /**
     * @Route("/default", name="default")
     */
    public function index(Request $request)
    {
        

        $entityManager = $this->getDoctrine()->getManager();
        $videos = $entityManager->getRepository(Video::class)->findAll();
        dump($videos);

        $video = new Video();
        // $video->setTitle('lotr');
        // $video->setCreatedAt(new DateTime('tomorrow'));

        $form = $this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('default');
            
        }
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
            'form' => $form->createView(),
        ]);
    }
}
