<?php

namespace Drupal\menulauncher\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Drupal\Console\Command\Shared\ContainerAwareCommandTrait;
use Drupal\Console\Style\DrupalStyle;
use Drupal\Core\Menu\MenuTreeParameters;

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

      ->addArgument(
        'menu-item',
        InputArgument::REQUIRED,
        $this->trans('commands.config.edit.arguments.menu-item')
      )

      ->setDescription($this->trans('commands.menulauncher.default.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $io->info('I am a new generated command.');
  }


  protected function interact(InputInterface $input, OutputInterface $output)
  {
    $io = new DrupalStyle($input, $output);

    $menuItem = $input->getArgument('menu-item');
    if (!$menuItem) {
      $menuLinkTree = $this->getDrupalService('menu.link_tree');

   //   print_r(get_class_methods($menuLinkTree));


      $parameters = new MenuTreeParameters();
     // $parameters->setMinDepth(2)->setMaxDepth(4)->onlyEnabledLinks();

      $adminMenu = $menuLinkTree->load('admin', $parameters);




      $adminMenu = $menuLinkTree->transform($adminMenu, []);

//      print_r($adminMenu);

      foreach ($adminMenu as $element) {
        /** @var \Drupal\Core\Menu\MenuLinkInterface $link */
        $link = $element->link;
        print_r("\n\n");
//        print_r(get_class($link));
        print_r($link->getTitle());

print_r("\n\n");
        print_r($link->getPluginId());
        print_r("\n\n");

        if ($element->subtree) {
          print_r("inside");
          print_r("\n\n");
          $subtree = $menuLinkTree->build($element->subtree);
print_r(array_keys($subtree['#items']));
          print_r(get_class($subtree));



          $options = [
            'up' => 'parent',
            'launch' => 'launch',

          ];


          foreach ($subtree['#items'] as $item) {
            print_r("\n\n");

            print_r(array_keys($item));

            print_r("title  \n ");
            print_r($item['title']);

            print_r("\n\n");

            print_r("URL  \n ");

            if (method_exists($item['url'], 'toString')) {

              print_r($item['url']->toString());
              print_r(get_class_methods($item['url']));

              // @todo Does the title need to be escaped?
              $options[$item['url']->toString()] = $item['title'];
            }


          }





        } else {
          $output = '';
        }
      }





      $menuItem = $io->choice(
        'Choose a configuration',
        $options
      );

      $input->setArgument('menu-item', $menuItem);
    }
  }


}
