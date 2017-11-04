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


    When I visit "node/1981/edit"
    And I press "field_image_header_0_remove_button"
    And I attach the file "fisticuffs-tag.jpg" to "Header Image"
    And I press "Save"


  When I visit "node/2014/edit"
  And I press "field_image_header_0_remove_button"
  And I attach the file "fisticuffs-tag.jpg" to "Header Image"
  And I press "Save"

  When I visit "node/2071/edit"
  And I press "field_image_header_0_remove_button"
  And I attach the file "fisticuffs-tag.jpg" to "Header Image"
  And I press "Save"

  When I visit "node/2007/edit"
  And I press "field_image_header_0_remove_button"
  And I attach the file "fisticuffs-tag.jpg" to "Header Image"
  And I press "Save"
  When I visit "node/1943/edit"
  And I press "field_image_header_0_remove_button"
  And I attach the file "fisticuffs-tag.jpg" to "Header Image"
  And I press "Save"
  When I visit "node/1929/edit"
  And I press "field_image_header_0_remove_button"
  And I attach the file "fisticuffs-tag.jpg" to "Header Image"
  And I press "Save"
  When I visit "node/1928/edit"
  And I press "field_image_header_0_remove_button"
  And I attach the file "fisticuffs-tag.jpg" to "Header Image"
  And I press "Save"
