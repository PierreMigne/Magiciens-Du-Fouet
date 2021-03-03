<?php

namespace App\Controller\Admin;

use App\Entity\Cook;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {

        return Cook::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname','Prénom'),
            TextField::new('lastname', 'Nom'),
            SlugField::new('slug')->setTargetFieldName('lastname'),
            ImageField::new('illustration')
                ->setBasePath('uploads/cooks')
                ->setUploadDir('public/uploads/cooks')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
        ];
    }


}
