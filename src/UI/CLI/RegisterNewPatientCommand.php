<?php

namespace App\UI\CLI;

use App\PatientIdentity\Application\UseCases\RegisterNewPatient;
use App\PatientIdentity\Application\UseCases\RegisterNewPatientDTO;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:patient:register-new')]
final class RegisterNewPatientCommand extends Command
{
    public function __construct(
        private readonly RegisterNewPatient $registerNewPatient,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $patientId = $this->registerNewPatient->execute(new RegisterNewPatientDTO(
            'John',
            'Doe',
            'ABC123456',
            'test@example.com',
            '123456789',
        ));

        $output->writeln("New patient id: $patientId");
        return Command::SUCCESS;
    }
}