Feature: Video

  @api
  Scenario: Video nodes table
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration/quotes"
    Then I should see the following table portion
    | Kay Liston Reviews the World - Cat Sweater | https://www.youtube.com/watch?v=5OUSsxXkUdk | Joe Gennaro, Claire Friedman, Mary Beth Smith | 2014-02-13 |

