<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update('index', 'new', function (Action $action) {
                return $action->setLabel('Créer Recette');
            })
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre'),
            SlugField::new('slug')->setTargetFieldName('title'),
            ImageField::new('illustration')
                ->setBasePath('uploads/recipes')
                ->setUploadDir('public/uploads/recipes')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            ChoiceField::new('difficulty', 'Difficultée')->setChoices([
                '1'=>1,
                '2'=>2,
                '3'=>3,
                '4'=>4
            ])->hideOnIndex(),
            IntegerField::new('duration', 'Durée')->hideOnIndex(),
            ChoiceField::new('cost', 'Coût')->setChoices([
                '1'=>1,
                '2'=>2,
                '3'=>3,
                '4'=>4
            ])->hideOnIndex(),
            TextareaField::new('ingredients','Ingrédients')->hideOnIndex(),
            TextareaField::new('description'),
            TextareaField::new('steps','Étapes')->hideOnIndex(),
            DateField::new('created_At','Créée le')->hideOnIndex(),
            DateField::new('update_At','Mis à jour le')->hideOnIndex(),
            IntegerField::new('people', 'Personnes')->hideOnIndex(),
            IntegerField::new('likes','J\'aimes'),
            BooleanField::new('isVisible','Afficher'),
            AssociationField::new('cook_id','Cuisinier'),
            MoneyField::new('price', 'Prix')->hideOnIndex()->setCurrency('EUR'),
        ];
    }

}
