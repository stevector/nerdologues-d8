<?php

namespace Drupal\menulauncher\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Drupal\Console\Command\Shared\ContainerAwareCommandTrait;
use Drupal\Console\Style\DrupalStyle;

/**
 * Class DefaultCommand.
 *
 * @package Drupal\menulauncher
 */
class DefaultCommand extends BaseCommand {

  use ContainerAwareCommandTrait;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('menulauncher:default')
      ->setDescription($this->trans('commands.menulauncher.default.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $io->info('I am a new generated command.');
  }

}
