function uploadmp3(cy, Cypress) {



}








describe('Make a podcast episode node with an uploaded file ', function(){
  context('Make some nodes', function(){
    it('Logs in', function(){

      cy.visit('user');
      cy.get('input[name=name]').type(Cypress.env('USER_CONTENT_ADMIN'))
      cy.get('input[name=pass]').type(Cypress.env('PASS_CONTENT_ADMIN') + '{enter}')

      cy.visit('node/add/podcast_episode');
      var d = new Date();
      var n = d.getTime();
      const title = 'H ' + n;
      cy.get('input[name="title[0][value]"]').type(title, {force: true})

      cy.contains('Required').click({force: true});
      cy.get("#edit-field-ref-podcast-83").click({force: true});
      cy.contains('MP3').click({force: true});


      cy.get('#edit-field-file summary').click();

      cy.contains('Select entities').click();

      cy.wait(2112);
      cy.get('iframe.entity-browser-modal-iframe').then($iframe => {

        const iframe = $iframe.contents();

        const myInput = iframe.find('input[type=file]');

        cy.wait(2112);

        cy.get(myInput).then(subject => {
          // Adapted from From Cypress document: https://docs.cypress.io/api/utilities/blob.html#Examples
          return cy.fixture('mp3s/nerdologues_demo.mp3', 'base64').then((base64) => {
            return Cypress.Blob.base64StringToBlob(base64, "audio/mpg").then((blob) => {
              const el = subject[0]
              const testFile = new File([blob], 'nerdologues_demo.mp3', { type: 'audio/mpg' })
              const dataTransfer = new DataTransfer()
              dataTransfer.items.add(testFile)
              el.files = dataTransfer.files
            })
          })
        })

        const mySubmit = iframe.find("#edit-submit");
        cy.wrap(mySubmit).click();



      });


      cy.wait(3000);
      cy.get('#edit-submit').click();
      cy.wait(500);
      cy.get('h1.page-title').contains(title);
      cy.get('.field--name-field-file a').should('have.attr', 'href', 'http://podcasts.nerdologues.com/yourstories/Decemberpart1.mp3');
    })
  })
})









/*

describe('Make a podcast episode node with a remote file ', function(){
  context('Make some nodes', function(){
    it('Logs in', function(){

      cy.visit('user');
      cy.get('input[name=name]').type(Cypress.env('USER_CONTENT_ADMIN'))
      cy.get('input[name=pass]').type(Cypress.env('PASS_CONTENT_ADMIN') + '{enter}')

      cy.visit('node/add/podcast_episode');
      var d = new Date();
      var n = d.getTime();
      const title = 'H ' + n;
      cy.get('input[name="title[0][value]"]').type(title, {force: true})

      cy.contains('Required').click({force: true});
      cy.get("#edit-field-ref-podcast-83").click({force: true});
      cy.contains('MP3').click({force: true});


cy.get('#edit-field-file summary').click();

    cy.contains('Select entities').click();

      cy.wait(2112);
      cy.get('iframe.entity-browser-modal-iframe').then($iframe => {
        cy.wait(2112);
        const iframe = $iframe.contents();
         cy.wait(2112);
        cy.wrap(iframe.find('body')).contains('remote_stream').click();
         cy.wait(2112);
      });

      cy.get('iframe.entity-browser-modal-iframe').then($iframe => {
        cy.wait(2112);
        const iframe = $iframe.contents();

        const myInput = iframe.find("#edit-url");

         cy.wait(2112);
        cy.wrap(myInput).type("http://podcasts.nerdologues.com/yourstories/Decemberpart1.mp3");


        const mySubmit = iframe.find("#edit-submit");
        cy.wrap(mySubmit).click();
      });

      cy.wait(3000);
      cy.get('#edit-submit').click();
      cy.wait(500);
      cy.get('h1.page-title').contains(title);
      cy.get('.field--name-field-file a').should('have.attr', 'href', 'http://podcasts.nerdologues.com/yourstories/Decemberpart1.mp3');
    })
  })
})


*/

