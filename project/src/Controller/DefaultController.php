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
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
        ]);
    }


}
