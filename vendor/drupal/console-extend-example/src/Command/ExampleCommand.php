<?php

/**
 * @file
 * Contains \Drupal\Console\Extend\Command\ExampleCommand
 */

namespace Drupal\Console\ExtendExample\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drupal\Console\Core\Command\Shared\CommandTrait;
use Drupal\Console\Core\Style\DrupalStyle;

/**
 * Class ExampleCommand
 *
 * @package Drupal\Console\GlobalExtend\Command
 */
class ExampleCommand extends Command
{
    use CommandTrait;
    /**
     * {@inheritdoc}
     */

    /**
     * ExampleCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('extend:example')
            ->setDescription('Drupal Console extend example');
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new DrupalStyle($input, $output);
        $io->commentBlock('Drupal Console extend example command.');
    }
}
