<?php

namespace App\UI\CLI;

use App\KeyStorage\Application\KeyStorageApi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:key-storage:delete-key')]
final class DeleteEncryptionKeyCommand extends Command
{
    public function __construct(
        private readonly KeyStorageApi $keyStorageApi,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('key', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('key');
        $this->keyStorageApi->deleteKey($id);

        $output->writeln(sprintf('Key "%s" deleted', $id));
        return Command::SUCCESS;
    }
}