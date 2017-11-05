Feature: Main Main

  @api
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I log in as an administrator
    When I visit "admin/structure/menu/link/standard.front_page/edit"
    And I uncheck the box "Enable menu link"
    And I press "Save"

    When I visit "admin/structure/menu/manage/main/add"
    And I fill in "Menu link title" with "About"
    And I fill in "Link" with "/nerds-are-funny"
    And I fill in "Weight" with "0"
    And I press "Save"


    When I visit "admin/structure/menu/manage/main/add"
    And I fill in "Menu link title" with "Nerds"
    And I fill in "Link" with "/nerds"
    And I fill in "Weight" with "8"
    And I press "Save"

    When I visit "admin/structure/menu/manage/main/add"
    And I fill in "Menu link title" with "Events & Shows"
    And I fill in "Link" with "/events"
    And I fill in "Weight" with "10"
    And I press "Save"


    When I visit "admin/structure/menu/manage/main/add"
    And I fill in "Menu link title" with "Podcasts"
    And I fill in "Link" with "/podcasts"
    And I fill in "Weight" with "14"
    And I press "Save"

    When I visit "admin/structure/menu/manage/main/add"
    And I fill in "Menu link title" with "Videos"
    And I fill in "Link" with "/videos"
    And I fill in "Weight" with "18"
    And I press "Save"


    When I visit "admin/structure/menu/manage/main/add"
    And I fill in "Menu link title" with "Fisticuffs!"
    And I fill in "Link" with "/fisticuffs"
    And I fill in "Weight" with "20"
    And I press "Save"



