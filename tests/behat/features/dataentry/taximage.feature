Feature: Taxonomy image
  This is not so much a test as it is a janky migration.
  This feature is meant to be run once to attach an image

  @api
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/structure/taxonomy/manage/blog_tags/overview"
    Then I click "Edit" in the "Fisticuffs" row
    And I attach the file "fisticuffs.jpg" to "Image"
    And I press "Upload"

    #And I fill in "Alternative text" with "Fisticuffs cards"


    And I press "Save"
  #  And print last response
  And print current URL
#    And I fill in "Existing system path" with "/node/81/clips"
#    And I fill in "Path alias" with "/podcasts/your-stories/clips"
#    And I press "Save"
#    And I visit "/podcasts/your-stories/clips"
