<?php

namespace App\Controller;

use App\Entity\Cook;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/cuisiniers', name: 'cooks')]
    public function index(): Response
    {
        $cooks = $this->entityManager->getRepository(Cook::class)->findAll();
        return $this->render('cook/index.html.twig', [
            'cooks'=>$cooks
        ]);
    }

    #[Route('/cuisiniers/{slug}', name: 'cook')]
    public function show($slug): Response
    {
        $cook = $this->entityManager->getRepository(Cook::class)->findOneBy(['slug'=>$slug]);
        if (!$cook) {
            return $this->redirectToRoute('cooks');
        }

        return $this->render('cook/show.html.twig', [
            'cook'=>$cook
        ]);
    }

    #[Route('/cuisiniers/{slug}/recettes', name: 'cookRecipes')]
    public function recipes($slug): Response
    {
        $cook = $this->entityManager->getRepository(Cook::class)->findOneBy(['slug'=>$slug]);

        if (!$cook) {
            return $this->redirectToRoute('cooks');
        }

        return $this->render('cook/cookRecipes.html.twig', [
            'cook'=>$cook,
        ]);
    }
}
