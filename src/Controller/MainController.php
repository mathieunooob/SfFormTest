<?php
namespace App\Controller;

use App\Entity\Property;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        $propertiesRepo = $this->getDoctrine()->getRepository(Property::class);
        $properties = $propertiesRepo->findLatest();
        dump($properties);
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}