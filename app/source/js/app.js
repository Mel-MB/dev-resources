import '@yaireo/tagify/src/tagify.scss';
const Tagify = require("@yaireo/tagify/dist/tagify.min.js");


document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.querySelector("form#search input");
    const buttons = document.querySelectorAll(".fa-trash-alt");
    const tagsInput = document.querySelector('input[name="tags"]');
    const posts = document.querySelectorAll('.post');

    if(searchBar) searchPosts(searchBar)
    if(buttons) handleDelete(buttons)
    if(tagsInput !== null){ 
        new Tagify( tagsInput, {
            delimiters          : ",| ",
        })      
    }
    
});

// Search function fires of when user press "Enter" key
const searchPosts = (input) =>{

    input.addEventListener('keydown', async (e) => {
        if(e.key === "Enter"){
            e.preventDefault()
            let value = e.target.value;
            let container = document.getElementById('content')

            if(value){
                const posts = await postThenFetchJson(
                    e.target.parentElement.action,{
                    body: JSON.stringify({query: value})
                })
                container.classList.add('fadeOut')
                await timeout(300)
                container.innerHTML =''
                await timeout(300)
                container.innerHTML = posts.sourceCode
                container.classList.remove('fadeOut')

            }
        }
    })
}

// Handle delete buttons
const handleDelete = (buttons) =>{

    buttons.forEach(button => (button.closest("form[id^='delete']").addEventListener('submit', async (e) => {
        e.preventDefault()
        const conf = confirm("Êtes-vous sûr(e)? La suppression du post est irréversible.")

        if(conf){
            const success = await postThenFetchJson(e.target.action)
            if(success !== true){
                window.location.reload();
            }
            const element = button.closest('article, .comment')

            element.classList.add('fadeOut')
            await timeout(700)
            element.remove()
        }
    
    })))
}

/*========== General helpers ==========*/
const timeout = ms => new Promise(resolve => setTimeout(resolve, ms));

/*===== Fetch helpers =====*/
const fetchJson = async (url, options = {}) => {
    const init = {
        ...options,
        headers: {...options.headers, 'X-Requested-With': 'XMLHttpRequest'}
    }

    const resp = await fetch(url,init)

    return resp.json();
}
//Make an HTTP POST Request (also used for DELETE http purposes in order to remain accessible on disabled scripts)
const postThenFetchJson = async (url, options = {}) => {
    const init = {
        ...options, 
        method: 'POST',
        headers: {...options.headers, 'Content-Type': 'application/json'}
    }
    console.log(init)
    return fetchJson(url,init)
}
