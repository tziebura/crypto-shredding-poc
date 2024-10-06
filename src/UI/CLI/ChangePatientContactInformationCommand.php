<?php

namespace App\UI\CLI;

use App\PatientIdentity\Application\UseCases\ChangePatientContactInformation;
use App\PatientIdentity\Application\UseCases\ChangePatientContactInformationDTO;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:patient:change-contact-information')]
final class ChangePatientContactInformationCommand extends Command
{
    public function __construct(
        private readonly ChangePatientContactInformation $changePatientContactInformation,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('patient', InputArgument::REQUIRED);
        $this->addOption('email', null, InputOption::VALUE_OPTIONAL);
        $this->addOption('phone', null, InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('patient');

        $newEmail = $input->getOption('email');
        $newPhone = $input->getOption('phone');

        if (!$newEmail || !$newPhone) {
            throw new RuntimeException('Provide new contact information');
        }

        $this->changePatientContactInformation->execute(
            new ChangePatientContactInformationDTO(
                $id,
                $newEmail,
                $newPhone,
            )
        );

        $output->writeln('Patient contact information changed');

        return Command::SUCCESS;
    }
}