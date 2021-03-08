<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $recipeMostLiked = $this->entityManager->getRepository(Recipe::class)->findMostLiked();
        $recipes = $this->entityManager->getRepository(Recipe::class)->findLatest();
        return $this->render('home/index.html.twig', [
            'recipeMostLiked'=>$recipeMostLiked,
            'recipes'=>$recipes
        ]);
    }
}
