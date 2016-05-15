# Behat Directories

## Click Driving Behat Features

This is a directory of Behat feature files that are specifically NOT fulfilling Behavior-Driven-Development. These feature files simply drive a series of clicks and browser interactions that confirm that this Drupal 8 site behaves in a way that matches the the Drupal 7 site.

One clear giveaway for these files not being a product of BDD is the overly detailed selectors used in the feature files. Instead of custom definitions that highlight the wants and needs of real people these feature files highlight CSS selectors and the names of form elements.

So why use Behat if the end result is not BDD? Because I don't expect to be able to jump into BDD without learning the nuts and bolts of the tool first.

## Migration Features

Similar to the clickdriving directory, the migration directory exists as a checker rather than a means of driving development. They are separated out into a different directory because

* Running of these checks may not be needed once the D8 site is live.
* Because these feature files are meant to be run against a remote site (on Pantheon) they have a more limited set of definitions. The Drush Driver can be used with remote sites but doesn't have support for all of the definitions that are available when Behat and the Drupal site live on the same server (like in local usage or when both the tests and the site execute within Circle CI).