<?php

namespace Drupal\menulauncher\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Drupal\Console\Command\Shared\ContainerAwareCommandTrait;
use Drupal\Console\Style\DrupalStyle;
use Symfony\Component\Console\Input\InputArgument;

use Drupal\Core\Menu\MenuTreeParameters;

/**
 * Class MenuLauncherItemCommand.
 *
 * @package Drupal\menulauncher
 */
class MenuLauncherItemCommand extends BaseCommand {

  use ContainerAwareCommandTrait;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('menulauncher:item')

      ->addArgument(
        'menu-item',
        InputArgument::REQUIRED,
        $this->trans('commands.config.edit.arguments.menu-item')
      )

      ->setDescription($this->trans('commands.menulauncher.item.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // field_ui.display_mode

    $io = new DrupalStyle($input, $output);

    $io->info('I am a new generated command.');
  }


  protected function interact(InputInterface $input, OutputInterface $output)
  {
    $io = new DrupalStyle($input, $output);

    $menuItem = $input->getArgument('menu-item');
    $options = $this->getChildMenuItemOptions($menuItem);
    
      $menuItem = $io->choice(
        'Choose a configuration',
        $options
      );

      $input->setArgument('menu-item', $menuItem);
    }






  function getChildMenuItemOptions($menuItem) {
    $menuLinkTree = $this->getDrupalService('menu.link_tree');
    $parameters = new MenuTreeParameters();
    $parameters->setMaxDepth(1);

    $parameters->setRoot($menuItem);

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


        foreach ($subtree['#items'] as $key => $item) {
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
            $options[$key] = $item['url']->toString() . '    ' . $item['title'];
          }


        }





      } else {
        $output = '';
      }
    }


    return $options;



  }






}
