<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


use App\Entity\User;

use App\Services\GiftsService;
use Doctrine\ORM\Mapping\Cache;

class DefaultController extends Controller
{

    public function __construct($logger){

    }


    /**
     * @Route("/default", name="default")
     */
    public function index()
    {

        $cache = new FilesystemAdapter();
        $posts = $cache->getItem('database.get_posts');

        if (!$posts->isHit())
        {
            $posts_from_db = ['post 1', 'post 2', 'post 3'];
            dump('Connected with database...');

            $posts->set(serialize($posts_from_db));
            $posts->expiresAfter(5);
            $cache->save($posts);
        }

        // $cache->deleteItem('database.get_posts');
        // $cache->clear();

        dump(unserialize($posts->get()));

        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => [],
        ]);
    }


}
