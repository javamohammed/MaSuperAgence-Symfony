<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;


class AdminPropertyController extends AbstractController
{
    private $repository;
    private $manager;
    public function __construct(PropertyRepository $repository,ObjectManager $manager){
        $this->repository = $repository;
        $this->manager = $manager;
    }
    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        $properties =  $this->repository->findAll();
        return $this->render('property/admin/index.html.twig',compact('properties'));
    }

    /**
     * @Route("admi/property/create", name="admin.property.new")
     */
    public function new ( Request $request)
    {
        $property = new Property();
        $Form =  $this->createForm(PropertyType::class,$property);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid() )
        {
            $this->manager->persist($property);
            $this->manager->flush();

            $this->addflash('success', 'Bien ajouté avec succées !!');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('property/admin/new.html.twig',[
            'property' => $property,
            'form' => $Form->createView()
        ]);


    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit" , methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        $Form =  $this->createForm(PropertyType::class,$property);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid() )
        {
            $this->manager->flush();
            $this->addflash('success', 'Bien modifié avec succées !!');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('property/admin/edit.html.twig',[
            'property' => $property,
            'form' => $Form->createView()
        ]);
    }
    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     */

    public function delete(Property $property, Request $request)
    {

        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token')))
        {
            $this->manager->remove($property);
            $this->manager->flush();
            $this->addflash('success', 'Bien supprimé avec succées !!');
        }
        return $this->redirectToRoute('admin.property.index');

    }
}
