<?php

namespace App\Command;

use App\Exception\DuplicatedCardsException;
use App\Exception\InvalidCardListException;
use App\Service\PokerTableService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:poker-hand',
    description: 'Create two poker hand and compare them.',
    aliases: ['app:poker']
)]
class CompareHandsCommand extends Command
{

    public PokerTableService $tableService;

    /**
     * @param PokerTableService $tableService
     */
    public function __construct(PokerTableService $tableService)
    {
        parent::__construct();
        $this->tableService = $tableService;
    }


    protected function configure(): void
    {
        $this->setDescription("Create two poker hand and compare them.")
            ->setHelp('This commands allow you to create a poker hands and print which hands win.')
            ->addArgument('firstHand', InputArgument::REQUIRED, 'The first poker hand')
            ->addArgument('secondHand', InputArgument::REQUIRED, 'The second poker hand');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $firstHandString = $input->getArgument("firstHand");
            $secondHandString = $input->getArgument("secondHand");

            $this->tableService->init($firstHandString, $secondHandString);
            $this->tableService->play();
            $output->writeln($this->tableService->play());

        } catch (InvalidCardListException | DuplicatedCardsException $e) {
            $output->writeln($e->getMessage());
            return Command::INVALID;
        }


        return Command::SUCCESS;
    }

}