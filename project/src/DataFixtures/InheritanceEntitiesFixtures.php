<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Author;
use App\Entity\File;
use App\Entity\Pdf;
use App\Entity\Video;
use App\Entity\Video as EntityVideo;

class InheritanceEntitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=1; $i<=2; $i++)
        {
            $author = new Author;
            $author->setName('name - '.$i);
            $manager->persist($author);

            for($k=1;$k<=3;$k++)
            {
                $pdf = new Pdf;
                $pdf->setFilename('pdf - '.$k);
                $pdf->setSize(100);
                $pdf->setDescription('a pdf - '.$k);
                $pdf->setPagesNumber(10);
                $pdf->setOrientation('portrait');
                $pdf->setAuthor($author);
                $manager->persist($pdf);
            }

            for($j=1;$j<=3;$j++)
            {
                $video = new Video;
                $video->setFilename('video - '.$j);
                $video->setSize(100);
                $video->setDescription('a video - '.$j);
                $video->setFormat('jpeg');
                $video->setDuration(10);
                $video->setAuthor($author);
                $manager->persist($video);
            }
        }

        $manager->flush();
    }
}
