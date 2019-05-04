function uploadmp3(cy, Cypress, sample_words) {
    const imageName = sample_words.ingredients[sample_words.ingredients.length - 1].Name;
    const imageNameLower = imageName.replace(/\s+/g, '-').toLowerCase();

    cy.get('input[type=file]').then(subject => {
        // Adapted from From Cypress document: https://docs.cypress.io/api/utilities/blob.html#Examples
        return cy.fixture('images/'  +  imageNameLower + '.jpg', 'base64').then((base64) => {
                return Cypress.Blob.base64StringToBlob(base64, "image/jpeg").then((blob) => {
                const el = subject[0]
                const testFile = new File([blob], 'logo.jpg', { type: 'image/jpeg' })
                const dataTransfer = new DataTransfer()
                dataTransfer.items.add(testFile)
                el.files = dataTransfer.files
            })
        })
    })

    cy.get('input[name="field_image[0][alt]"]').type('image alt', {force: true})
}


describe('Hello world ', function(){
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

//      cy.contains('file').click({force: true});





cy.get('#edit-field-file summary').click();

    cy.contains('Select entities').click();

      cy.wait(2000);
      cy.get('iframe.entity-browser-modal-iframe').then($iframe => {



        cy.wait(1000);
        const iframe = $iframe.contents();

        const myInput = iframe.find("#edit-url");


        var d = new Date();
        var n = d.getTime();
        const title = 'Hello World ' + n;
        cy.wrap(myInput).type("http://podcasts.nerdologues.com/yourstories/Decemberpart1.mp3");


        const mySubmit = iframe.find("#edit-submit");
        cy.wrap(mySubmit).click();

        //you don't need to trigger events like keyup or change

      });
      cy.wait(3000);


      cy.get('#edit-submit').click();
      cy.wait(500);

      cy.get('h1.page-title').contains(title);
    })
  })
})
