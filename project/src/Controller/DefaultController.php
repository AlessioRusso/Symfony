<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Entity\File;
use App\Entity\Author;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AuthorRepository;


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
        // $items = $entityManager->getRepository(File::class)->findAll();
        // dump($items);

        $author = $entityManager->getRepository(Author::class)->findByIdWithPdf(1);

        dump($author);

        foreach ($author->getFiles() as $file)
        {
            if($file instanceof Pdf)
            dump($file->getFileName());
            
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
        ]);
    }

    

}
