<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
            IdField::new('id'),
            TextField::new('first_name'),
            TextField::new('last_name'),
            TextField::new('email'),
            TextField::new('password')
                ->setRequired(false)  // Make password field optional when editing
                ->setFormTypeOption('attr', ['autocomplete' => 'new-password']),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new Users();

        // Set the password if provided
        if ($plainPassword = $user->getPassword()) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        }

        // Persist the entity and flush
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
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
