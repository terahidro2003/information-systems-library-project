function get_current_url()
{
    return window.location.href;
}
var contentFrame = document.getElementById("system-body");
var books_menu_link = document.getElementById("nav-books-link");

async function fetchAsync (url, data) {
    let response = await fetch(url, {
        method: 'get',
        body: `data='${data}'`;
    });
    let data = await response.json();
    return data;
}
