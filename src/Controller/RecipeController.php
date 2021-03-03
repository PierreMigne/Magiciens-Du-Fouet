<?php

namespace App\Controller;

use App\Entity\Cook;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/recettes', name: 'recipe')]
    public function index(): Response
    {
        $recipes = $this->entityManager->getRepository(Recipe::class)->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes'=>$recipes
        ]);
    }
}
