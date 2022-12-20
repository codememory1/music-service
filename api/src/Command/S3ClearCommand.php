<?php

namespace App\Command;

use App\Rest\S3\Bucket;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    'app:s3:clear',
    'Complete cleanup s3'
)]
final class S3ClearCommand extends Command
{
    public function __construct(
        private readonly Bucket $bucket
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Recycle bin is being emptied');

        $this->bucket->clearAllBuckets();

        $io->success('Recycle bin emptying completed successfully');

        return self::SUCCESS;
    }
}