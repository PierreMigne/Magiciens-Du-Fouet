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

    #[Route('/recettes', name: 'recipes')]
    public function index(): Response
    {
        $recipes = $this->entityManager->getRepository(Recipe::class)->findBy(['isVisible'=>'1']);
        return $this->render('recipe/index.html.twig', [
            'recipes'=>$recipes
        ]);
    }

    #[Route('/recettes/{slug}', name: 'recipe')]
    public function show($slug): Response
    {
        $cooks = $this->entityManager->getRepository(Cook::class)->findAll();
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug'=>$slug]);
        if (!$recipe) {
            return $this->redirectToRoute('recipes');
        }

        return $this->render('recipe/show.html.twig', [
            'recipe'=>$recipe,
            'cooks'=>$cooks
        ]);
    }
}
