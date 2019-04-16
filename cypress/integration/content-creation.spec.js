describe('Hello world ', function(){
  context('Make some nodes', function(){
    it('Logs in', function(){

      cy.visit('user');
      cy.get('input[name=name]').type(Cypress.env('DRUPAL_USERNAME'))
      cy.get('input[name=pass]').type(Cypress.env('DRUPAL_USERPASS') + '{enter}')

      cy.visit('node/add/article');
      var d = new Date();
      var n = d.getTime();
      const title = 'Hello World ' + n;
      cy.get('input[name="title[0][value]"]').type(title, {force: true})
      cy.get('#edit-submit').click();
      cy.wait(500);
      cy.get('h1.page-title').contains(title);
    })
  })
})
