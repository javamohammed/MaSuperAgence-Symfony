<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends AbstractController
{
    private $repository;
    private $manager;
    public function __construct(PropertyRepository $repository,ObjectManager $manager){
        $this->repository = $repository;
        $this->manager = $manager;
    }
    /**
     * @Route("/biens", name="property.index")
     */
    public function index(PaginatorInterface $paginator,Request $request )
    {
        /*
        $property = $this->repository->findAll();
        $property[0]->setSold(false);
        $this->manager->flush();
        */
        $search = new PropertySearch();
        $form = $this->createForm(\App\Form\PropertySearchType::class, $search);
        $form->handleRequest($request);

        
        $query = $this->repository->findAllVisibleQuery($search);

        $Allproperties = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        12 /*limit per page*/
        );
        return $this->render('property/index.html.twig',[
            'menu_current' => 'properties',
            'Allproperties' => $Allproperties,
            'form' => $form->createView()
        ]);

        //
       /*
        $repo = $this->getDoctrine()->getRepository(Property::class);
        dump($repo);
        $proprety = new Property();
        $proprety->setTitle('Mon deuxième bien')
                 ->setDescription('une description parfait')
                 ->setSurface(70)
                 ->setRooms(4)
                 ->setBedrooms(6)
                 ->setFloor(5)
                 ->setPrice(150000)
                 ->setHeat(1)
                 ->setCity('Rabat')
                 ->setAddress('Hay hassani')
                 ->setPostalCode('80000');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($proprety);
        $entityManager->flush();
     */ 

    }
     /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */


    public function show(Property $property,string  $slug)
    {
        $getSlug = $property->getSlug();
        dump($getSlug);
        if($getSlug !== $slug){
            return $this->redirectToRoute('property.show',[
                'id' => $property->getId(),
                'slug' => $getSlug
            ],301);
        }

        //$property = $this->repository->find($id);
        //dump($property);
        return $this->render('property/show.html.twig',[
             'menu_current' => 'properties',
              'property' => $property
        ]);

    }
}
