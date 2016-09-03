Feature: blogpost

  @api
  Scenario: blogpost nodes
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration/blogpost"
    Then I should see the following table portion
    | Title                                                           | Content type | URI                                                         | Blog tags  | Authors      | Date Published |
    | MORE Best of Your Stories 2015 -- So Many Stories!              | Blog Post    | public://YourStorieslogo.jpg                                |            | Eric Garneau | 2015-12-28     |
    | Help Us Put Together The "Best Of" Your Stories 2015!           | Blog Post    | public://YourStorieslogo.jpg                                |            | Eric Garneau | 2015-11-02     |
    | Fisticuffs! in the Chicago Reader                               | Blog Post    | public://fisticuffs.jpg                                     | Fisticuffs |              | 2015-10-28     |
    | Fisticuffs! - Character Update #6 - The Congo Bongo             | Blog Post    | public://bongo.jpg                                          | Fisticuffs |              | 2015-10-01     |
    | Fisticuffs! - Character Update #5 - The Saxomagician            | Blog Post    | public://saxo.jpg                                           | Fisticuffs |              | 2015-09-22     |
    | Fisticuffs! - Character Update #4 - The Metal Devil             | Blog Post    | public://metal-devil.jpg                                    | Fisticuffs |              | 2015-09-08     |
    | Fisticuffs! - Character Update #3 - The Thunder From Down Under | Blog Post    | public://thunder.png                                        | Fisticuffs |              | 2015-08-25     |
    | Fisticuffs! - Character Update #2 - The Lady of Liberty         | Blog Post    | public://lady-of-liberty.png                                | Fisticuffs |              | 2015-08-18     |
    | Fisticuffs! - Character Update #1 - The Lion Son                | Blog Post    | public://lion-son.png                                       | Fisticuffs |              | 2015-08-11     |
    | Please, Enjoy This Ketchup                                      | Blog Post    | public://KetchupSized.jpg                                   |            | Eric Garneau | 2015-08-06     |
    | We're in the Chicago Tribune!                                   | Blog Post    | public://11709549_960185614024002_1197481110235861978_n.jpg |            |              | 2015-07-03     |
    | MORE Best of Your Stories 2014 - the stuff that wouldn't fit!   | Blog Post    | public://eric-your-stories-blogpost.jpg                     |            | Eric Garneau | 2014-12-29     |
