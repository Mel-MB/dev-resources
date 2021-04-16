import '@yaireo/tagify/src/tagify.scss';
const Tagify = require("@yaireo/tagify/dist/tagify.min.js");
// API GET request
async function getPreview(url){
    let token = '3564e019bb7d051784189285010d3a72';

    const response = await fetch(`http://api.linkpreview.net/?key=${token}&q=${url}`);;
    const data =  await response.json();

    return data;
}

document.addEventListener('DOMContentLoaded', () => {
    let input = document.querySelector('input[name="tags"]');
    let posts = document.querySelectorAll('.post');

    if(posts.textContent !== ""){
        const urlRegEx = /https?:\/\/([www\.]?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b)[-a-zA-Z0-9()@:%_\+.~#?&//=]*/

        posts.forEach(function(post){
            let url = post.innerText.match(urlRegEx);
            if(url){
                const preview = getPreview(url);
                preview.then((preview) => console.log(preview));

            };
            
        });
              
    };

    if(input !== null){ 
        new Tagify( input, {
            delimiters          : ",| ",
        });      
    };
});


