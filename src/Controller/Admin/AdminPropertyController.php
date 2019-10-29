<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class AdminPropertyController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->getDoctrine()->getRepository(Property::class)->findAll();
        dump($properties);

        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', 'Bien créé avec succès !');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     */
    public function edit(Request $request, Property $property, $id)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        $property = $this->getDoctrine()->getRepository(Property::class)->find($id);
        dump($property);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Bien modifié avec succès !');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'id' => $property->getId(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     */

    public function delete(property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        $em = $this->getDoctrine()->getManager();
        $em->remove($property);
        $em->flush();
        $this->addFlash('success', 'Bien supprimé avec succès !');
        return new Response('suppression');
        return $this->redirectToRoute('admin.property.index');
    }
}