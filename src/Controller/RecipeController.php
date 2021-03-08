<?php

namespace App\Controller;

use App\Entity\Cook;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/recettes', name: 'recipes')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $this->entityManager->getRepository(Recipe::class)->findAllQuery(),
            $request->query->getInt('page', 1),
            5
        );
        $recipes->setCustomParameters([
            'position' => 'centered',
            'align' => 'center',
            'size' => 'large',
            'rounded' => true,
        ]);

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

    #[Route('/recettes/{slug}/like', name: 'recipe_like')]
    public function like($slug): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug'=>$slug]);
        if (!$recipe) {
            return $this->redirectToRoute('recipes');
        }

        $recipe = $recipe->setLikes($recipe->getLikes()+1);
        $this->entityManager->persist($recipe);
        $this->entityManager->flush();
        setcookie('isLiked_'.$recipe->getId().'', 'oui', time() + 365*24*3600, null, null, false, true);
        return $this->redirectToRoute('recipe',['slug'=>$slug]);
    }

    #[Route('/recettes/{slug}/dislike', name: 'recipe_dislike')]
    public function dislike($slug): Response
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['slug'=>$slug]);
        if (!$recipe) {
            return $this->redirectToRoute('recipes');
        }

        $recipe = $recipe->setLikes($recipe->getLikes()-1);
        $this->entityManager->persist($recipe);
        $this->entityManager->flush();
        setcookie('isLiked_'.$recipe->getId().'');
        unset($_COOKIE['isLiked_'.$recipe->getId().'']);
        return $this->redirectToRoute('recipe',['slug'=>$slug]);
    }

}
