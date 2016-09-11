<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\Fixtures;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Kdyby\Doctrine\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultData extends Command
{
    /** @var EntityManager @inject */
    public $em;

    protected function configure()
    {
        $this
            ->setName('orm:default-data:load')
            ->setDescription('Load data fixtures to your database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $loader = new Loader();
            $loader->loadFromDirectory(__DIR__ . '/default-data/');
            $fixtures = $loader->getFixtures();

            $purger = new ORMPurger($this->em);

            $executor = new ORMExecutor($this->em, $purger);
            $executor->setLogger(function ($message) use ($output) {
                $output->writeln(sprintf('<comment>></comment><info>%s</info>', $message));
            });
            $executor->execute($fixtures);
            return 0; // zero return code means everything is ok
        } catch (\Exception $e) {
            $output->writeLn(sprintf('<error>%s</error>', $e->getMessage()));
            return 1; // non-zero return code means error
        }
    }
}