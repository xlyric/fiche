<?php

namespace App\Controller\Admin;

use App\Entity\Fiche;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\ErrorHandler\Collecting;

class FicheCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fiche::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           // IdField::new('id'),
            TextField::new('titre'),
            TextField::new('url'),
            AssociationField::new('categorie'),

        ];
    }
    
}
