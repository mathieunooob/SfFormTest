<?php 
namespace App\Controller;

use App\Entity\Property;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Repository\PropertyRepository;

class PropertyController extends AbstractController
{

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
      public function index(Request $request): Response
     {
        /*
        $propertyRepo = $this->getDoctrine()->getRepository(Property::class);
        // $properties = $propertyRepo->findAllVisible();
        // $properties = $propertyRepo->findBy(['sold' => false]);
        $property = $propertyRepo->findOneBy(['sold' => false]);
        dump($property);
        if(!isset($property) || $property === null)
        { 
            return $this->render('property/index.html.twig', [
                'no_properties_to_deal' => 'newview'
            ]);
        } else
        {
            $isSold = $property->getSold();
            if($isSold == false)
            {
                $property->setSold(true);
                $em = $this->getDoctrine()->getManager();
                $em->merge($property);
                $em->flush();
                dump($property);
            }
        }

        */
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show($slug, $id): Response
    {
        $property = $this->getDoctrine()
                ->getRepository(Property::class)
                ->find($id);
        dump($property);
        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show',[
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}