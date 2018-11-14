<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\PropertyRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $repo)
    {
        $properties = $repo->findLatest();

        return $this->render('pages/home.html.twig',[
            'properties' => $properties
        ]);
    }
}
