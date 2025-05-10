<?php

namespace App\Controller\Admin;

use App\Entity\TravelDocuments;
use App\Entity\Cities;
use App\Entity\Drivers;
use App\Repository\DriversRepository;
use App\Repository\CitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Filesystem\Filesystem;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TravelDocumentsCrudController extends AbstractCrudController
{

    private DriversRepository $driversRepository;
    private CitiesRepository $citiesRepository;

    public function __construct(
        DriversRepository $driversRepository,
        CitiesRepository $citiesRepository
    ) {
        $this->driversRepository = $driversRepository;
        $this->citiesRepository = $citiesRepository;
    }
    
    public static function getEntityFqcn(): string
    {
        return TravelDocuments::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Travel Document')
            ->setEntityLabelInPlural('Travel Documents');
    }
    public function configureFields(string $pageName): iterable
    {
        $driverChoices = [];
        foreach ($this->driversRepository->findAll() as $driver) {
            $driverChoices[$driver->getFirstName() . ' ' . $driver->getLastName()] = $driver->getId();
        }

        $cityChoices = [];
        foreach ($this->citiesRepository->findAll() as $city) {
            $cityChoices[$city->getName()] = $city->getId();
        }

        return [
            TextField::new('name'),

            ChoiceField::new('drivers', 'Drivers')
                ->setChoices($driverChoices)
                ->allowMultipleChoices()
                ->renderExpanded(false)
                ->setFormTypeOption('mapped', false),

            ChoiceField::new('cities', 'Cities')
                ->setChoices($cityChoices)
                ->allowMultipleChoices()
                ->renderExpanded(false)
                ->setFormTypeOption('mapped', false),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof TravelDocuments) return;

        $filesystem = new Filesystem();

        // Path to template
        $templatePath = $this->getParameter('kernel.project_dir') . '/assets/excel/template.xlsx';
        $spreadsheet = IOFactory::load($templatePath);

        // This is a pseudocode
        // I need to fill cells in template from Drivers Entity - first_name, last_name, address, car_name, car_plate - the best way is to just choose the whole drivers loaded in the form
        // Then from Cities Entity - name, distance
        // Then fill cells of the date that I will choose in the form

    }
}
