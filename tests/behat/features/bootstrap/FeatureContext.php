<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements Context, SnippetAcceptingContext {
  /**
   * Initializes context.
   * Every scenario gets its own context object.
   *
   * @param array $parameters
   *   Context parameters (set them in behat.yml)
   */
  public function __construct(array $parameters = []) {
    // Initialize your context here
  }

//
// Place your definition and hook methods here:
//
//  /**
//   * @Given I have done something with :stuff
//   */
//  public function iHaveDoneSomethingWith($stuff) {
//    doSomethingWith($stuff);
//  }
// Configure all content types
// Audit content types
// Decide what to do with date fields
// Remote file fields? - reporting of file size for remote files
// Migrate all content
// Configure roles
// Configure taxonomy terms
// Migrate taxonomy terms
// Migrate users
// Make theme
// header and footer
// All Views
// Audit D7 module functionality
// Check on status of clipper
// RSS Feeds / itunes
// Behat testing on PRs for D8
// Create Twig files
// Special fisticuffs handling
// Youtube embedding
// Mp3 player
// Preserve nids?
// How do run a migration on Pantheon
// Local dev
// PHPStorm
// Config lock for live env


    /**
     * @Given I wait for the progress bar to finish
     */
    public function iWaitForTheProgressBarToFinish() {
      $this->iFollowMetaRefresh();
    }

    /**
     * @Given I follow meta refresh
     *
     * https://www.drupal.org/node/2011390
     */
    public function iFollowMetaRefresh() {
      while ($refresh = $this->getSession()->getPage()->find('css', 'meta[http-equiv="Refresh"]')) {
        $content = $refresh->getAttribute('content');
        $url = str_replace('0; URL=', '', $content);
        $this->getSession()->visit($url);
      }
    }

    /**
     * @Given I have wiped the site
     */
    public function iHaveWipedTheSite()
    {
        $site = getenv('PSITE');
        $env = getenv('PENV');

        passthru("terminus --yes --site=$site --env=$env site wipe");
    }

    /**
     * @Given I have reinstalled :arg1
     */
    public function iHaveReinstalled($arg1)
    {
        $site = getenv('PSITE');
        $env = getenv('PENV');
        passthru("drush @pantheon.$site.$env --strict=0 site-install --yes standard --site-name='$arg1' --account-name=admin");
    }

    /**
     * @Given I have run the drush command :arg1
     */
    public function iHaveRunTheDrushCommand($arg1)
    {
        $site = getenv('PSITE');
        $env = getenv('PENV');
        passthru("drush @pantheon.$site.$env --strict=0 --yes $arg1");
    }

    /**
     * @Given I have committed my changes with comment :arg1
     */
    public function iHaveCommittedMyChangesWithComment($arg1)
    {
        $site = getenv('PSITE');
        $env = getenv('PENV');

        passthru("terminus --yes --site=$site --env=$env site code commit --message='$arg1'");
    }

    /**
     * @Given I have exported configuration
     */
    public function iHaveExportedConfiguration()
    {
        $site = getenv('PSITE');
        $env = getenv('PENV');
        passthru("drush @pantheon.$site.$env --strict=0 config-export --yes");
    }

    /**
     * @Given I wait :seconds seconds
     */
    public function iWaitSeconds($seconds)
    {
        sleep($seconds);
    }

    /**
     * @Given I wait :seconds seconds or until I see :text
     */
    public function iWaitSecondsOrUntilISee($seconds, $text)
    {
        $errorNode = $this->spin( function($context) use($text) {
            $node = $context->getSession()->getPage()->find('named', array('content', $text));
            if (!$node) {
              return false;
            }
            return $node->isVisible();
        }, $seconds);

        // Throw to signal a problem if we were passed back an error message.
        if (is_object($errorNode)) {
          throw new Exception("Error detected when waiting for '$text': " . $errorNode->getText());
        }
    }

    // http://docs.behat.org/en/v2.5/cookbook/using_spin_functions.html
    // http://mink.behat.org/en/latest/guides/traversing-pages.html#selectors
    public function spin ($lambda, $wait = 60)
    {
        for ($i = 0; $i <= $wait; $i++)
        {
            if ($i > 0) {
              sleep(1);
            }

            $debugContent = $this->getSession()->getPage()->getContent();
            file_put_contents("/tmp/mink/debug-" . $i, "\n\n\n=================================\n$debugContent\n=================================\n\n\n");

            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }

            // If we do not see the text we are waiting for, fail fast if
            // we see a Drupal 8 error message pane on the page.
            $node = $this->getSession()->getPage()->find('named', array('content', 'Error'));
            if ($node) {
              $errorNode = $this->getSession()->getPage()->find('css', '.messages--error');
              if ($errorNode) {
                return $errorNode;
              }
              $errorNode = $this->getSession()->getPage()->find('css', 'main');
              if ($errorNode) {
                return $errorNode;
              }
              return $node;
            }
        }

        $backtrace = debug_backtrace();

        throw new Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            $backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );

        return false;
    }

  /**
   * @Given I log in as an administrator
   */
  public function ILogInAsAnAdmin()
  {
    $this->minkContext->visit('user');
    $this->minkContext->fillField('Username', getenv('BEHAT_USER_ADMIN'));
    $this->minkContext->fillField('Password', getenv('BEHAT_PASS_ADMIN'));
    $this->minkContext->pressButton('Log in');
  }
  /**
   * @Given I log in as a content_administrator
   */
  public function ILogInAsAnContentAdmin()
  {
    $this->minkContext->visit('user');
    $this->minkContext->fillField('Username', getenv('BEHAT_USER_CONTENT_ADMIN'));
    $this->minkContext->fillField('Password', getenv('BEHAT_PASS_CONTENT_ADMIN'));
    $this->minkContext->pressButton('Log in');
  }

  /**
   * @Given I log in as an admin
   */
  public function iLogInAsAnAdmin2()
  {
    $this->ILogInAsAnAdmin();
  }

}
