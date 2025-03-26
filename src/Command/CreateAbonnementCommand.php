<?php
// src/Command/CreatePackCommand.php
namespace App\Command;

use App\Entity\Abonnement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CreateAbonnementCommand extends Command
{
    protected static $defaultName = 'app:create-abonnement';
    protected static $defaultDescription = 'Create three abonnement';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->setName('app:create-abonnement');
            
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $abonnement = [
            ['name' => 'week', 'price' => 20,'duration'=>7,'image'=>'abo1.png'],
            ['name' => 'month', 'price' => 50,'duration'=>30,'image'=>'abo2.png'],
            ['name' => '6month', 'price' => 250,'duration'=>180,'image'=>'abo3.png'],
        ];

        foreach ($abonnement as $abonnementData) {
            $abonnement = new Abonnement();
            $abonnement->setName($abonnementData['name']);           
            $abonnement->setPrice($abonnementData['price']);
            $abonnement->setDuration($abonnementData['duration']);
            $abonnement->setImage($abonnementData['image']);
            $this->entityManager->persist($abonnement);
        }

        $this->entityManager->flush();

        $io->success('Three abonnement have been created successfully.');

        return Command::SUCCESS;
    }
}