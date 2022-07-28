<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\User;

use App\Events\VideoCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use App\Services\GiftsService;


class DefaultController extends Controller
{

    public function __construct($logger, EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }


    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        $video = new \stdClass();

        $video->title = 'Funny movie';
        $video->category = 'funny';

        $event = new VideoCreatedEvent($video);

        $this->dispatcher->dispatch('video.created.event', $event);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
        ]);
    }
}
