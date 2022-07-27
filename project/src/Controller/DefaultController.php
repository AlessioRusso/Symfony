<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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
