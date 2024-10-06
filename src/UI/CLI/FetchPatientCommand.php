<?php

namespace App\UI\CLI;

use App\PatientIdentity\Application\UseCases\FetchPatient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:patient:fetch')]
final class FetchPatientCommand extends Command
{
    public function __construct(
        private readonly FetchPatient $useCase,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('patient', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('patient');

        $patient = $this->useCase->execute($id);

        dump($patient);

        return Command::SUCCESS;
    }
}