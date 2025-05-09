<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[Route(path:"/admin/users", name:"users")]
class UsersCrudController extends AbstractCrudController
{    
    private $passwordHasher;
    private $entityManager;

    // Injecting the password hasher service
    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('first_name'),
            TextField::new('last_name'),
            DateField::new('date_of_birth'),
            TextField::new('phone_number'),
            TextField::new('category'),
            TextField::new('email'),
            TextField::new('password')
                ->setRequired(false)  // Make password field optional when editing
                ->setFormTypeOption('attr', ['autocomplete' => 'new-password']),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Users) {
            return;
        }
    
        $plainPassword = $entityInstance->getPassword();
        if (!empty($plainPassword)) {
            $hashed = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashed);
        } else {
            // Reload the original password from the database to avoid blanking it
            $originalUser = $entityManager->getUnitOfWork()->getOriginalEntityData($entityInstance);
            $entityInstance->setPassword($originalUser['password']);
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
    

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Users) {
            return;
        }

        if ($plainPassword = $entityInstance->getPassword()) {
            $hashed = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashed);
        }

        $entityManager->flush();
    }
}
