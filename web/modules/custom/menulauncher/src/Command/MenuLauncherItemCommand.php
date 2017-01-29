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

      ->addArgument(
        'action',
        InputArgument::REQUIRED,
        $this->trans('commands.config.edit.arguments.action')
      )


      ->setDescription($this->trans('commands.menulauncher.item.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // field_ui.display_mode

    $io = new DrupalStyle($input, $output);


    $action = $input->getArgument('action');
    $menuItem = $input->getArgument('menu-item');


    switch($action) {
      case 'edit':
        $io->info('You want to edit');
       exec('open ' . $this->getDrupalService('url_generator')->generateFromRoute('menu_ui.link_edit', ['menu_link_plugin' => $menuItem], ['absolute' => TRUE]));
//        menu_ui.link_edit
        break;

      case 'open':

        $menuLink = $this->getMenuLink($menuItem);
        //print_r(get_class_methods($menuLink->getUrlObject()->toString()));
        exec('open ' . $menuLink->getUrlObject()->setAbsolute()->toString());
        //print_r();
        $io->info('You want to open');
        break;


    }



    $io->info('I am a new generated command.');
  }


  protected function getActions($menuItem) {
      return [
        'parent' => '--See Parent',
        'edit' => '--Edit Menu Item',
        'open' => '--Open Menu Item',

      ] + $this->getChildMenuItemOptions($menuItem);
  }


  protected function interact(InputInterface $input, OutputInterface $output)
  {
    $io = new DrupalStyle($input, $output);


    $action = $input->getArgument('action');
    $menuItem = $input->getArgument('menu-item');

    if (empty($menuItem)) {
      print_r('no handling yet for empty menuItem');
      die();
    }

    if (empty($action)) {
      $action_or_child = $io->choice(
        'what do you want to do with this Menu Item: ' . $menuItem,
        $this->getActions($menuItem)
      );

      if (in_array($action_or_child, ['parent', 'edit', 'open'])) {

        $input->setArgument('action', $action_or_child);
      }
      else {
        $input->setArgument('menu-item', $action_or_child);
      }

      $this->interact($input, $output);
    }


    if ($action === 'parent') {
      $parent = $this->getParent($menuItem);
      $input->setArgument('menu-item', $parent);
      $input->setArgument('action', '');
      $this->interact($input, $output);
    }
  }





  function getParent($menuItem) {
      return  $this->getMenuLinkTreeElement($menuItem)->link->getParent();
  }

  function getMenuLink($menuItem) {

    return  $this->getMenuLinkTreeElement($menuItem)->link;
  }


  function getChildMenuItemOptions($menuItem) {
    $options = [];
    $menuLinkTree = $this->getDrupalService('menu.link_tree');
      $element = $this->getMenuLinkTreeElement($menuItem);

      if ($element->subtree) {
        $subtree = $menuLinkTree->build($element->subtree);

        foreach ($subtree['#items'] as $key => $item) {
          if (method_exists($item['url'], 'toString')) {
            // @todo Does the title need to be escaped?
            $options[$key] = /*$item['url']->toString() . '    ' . */$item['title'];
          }
        }

      } else {
//        $output = '';
      }

    return $options;

  }


  function getMenuLinkTreeElement($menuItem) {
    $menuLinkTree = $this->getDrupalService('menu.link_tree');
    $parameters = new MenuTreeParameters();
    $parameters->setMaxDepth(1);
    $parameters->setRoot($menuItem);
    $adminMenu = $menuLinkTree->load('admin', $parameters);
    $adminMenu = $menuLinkTree->transform($adminMenu, []);


    foreach ($adminMenu as $element) {
      return $element;
    }


  }
}
