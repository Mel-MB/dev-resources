window.addEventListener('DOMContentLoaded', (event) => {
    let container = document.querySelector('div#tags');
    if(container){
        // render input with taggle.js 
        new Taggle('tags', {
            //New tag on whatespace,comma,tab ok enter keypress
            submitKeys: [32,188,9,13],
            placeholder: "Entrez le(s) sujet(s) concerné(s)",
            duplicateTagClass: 'bounce',
            async add = onTagAdd()
        });

    }
})