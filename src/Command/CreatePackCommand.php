<?php
// src/Command/CreatePackCommand.php
namespace App\Command;

use App\Entity\Pack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CreatePackCommand extends Command
{
    protected static $defaultName = 'app:create-packs';
    protected static $defaultDescription = 'Create three packs';

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
            ->setName('app:create-packs');
            
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $packs = [
            ['name' => 'One', 'quantity' => 1, 'price' => 2.0],
            ['name' => 'Three', 'quantity' => 3, 'price' => 5.0],
            ['name' => 'Ten', 'quantity' => 10, 'price' => 10.0],
        ];

        foreach ($packs as $packData) {
            $pack = new Pack();
            $pack->setName($packData['name']);
            $pack->setQuantity($packData['quantity']);
            $pack->setPrice($packData['price']);
            $this->entityManager->persist($pack);
        }

        $this->entityManager->flush();

        $io->success('Three packs have been created successfully.');

        return Command::SUCCESS;
    }
}