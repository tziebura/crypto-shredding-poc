<?php

namespace App\UI\CLI;

use App\PatientIdentity\Application\UseCases\RegisterNewPatient;
use App\PatientIdentity\Application\UseCases\RegisterNewPatientDTO;
use App\PatientIdentity\Domain\PatientId;
use App\PatientIdentity\Domain\PatientRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:patient:register-new')]
class RegisterNewPatientCommand extends Command
{
    public function __construct(
        private readonly RegisterNewPatient $registerNewPatient,
        private readonly PatientRepository $patientRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $patientId = $this->registerNewPatient->execute(new RegisterNewPatientDTO(
            'John',
            'Doe',
            'ABC123456',
            'test@exmaple.com',
            '123456789',
        ));

        dump($this->patientRepository);
        dump($this->patientRepository->find(PatientId::fromString($patientId)));
        die;
    }
}