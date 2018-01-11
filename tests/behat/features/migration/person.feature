Feature: Person

  @api
  Scenario: Person bio pages
    Given I log in as an administrator
    When I visit "admin/content-migration/person"
    Then I should see the following table portion
    |Chris Geiger | Person | Current Member, Founding Member, Viewable bio page | public://geiger-square.png | public://geiger-square.png | Geiger |
    Then I should see the following table portion
    | Claire Friedman            | Person       | Emeritus, Viewable bio page                        | public://friedman-profile_0.jpg | public://filed_image_lead/person/friedman-profile--square.jpg      | Friedman       |
    Then I should see the following table portion
    | Renata Graw     | Person |                             |                                  |                                 | Graw |
    Then I should see the following table portion
    |Alex Talavera | Person | Emeritus, Founding Member | public://talavera-profile.jpg | public://filed_image_lead/person/alex-profile--square_0.jpg | Talavera |
