async function fetchAsync (url, type, token) {
    let response = await fetch(url, {
        method: 'post',
        headers:new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        }),
        body: `token=${token}&data=${type}`
    });
    let data = await response.json();
    return data;
}

var feedback = fetchAsync("/system/library_api.php", "get_all_books", token);

var cardsrow = document.getElementById("books-content");
var cardsrowcontent;

feedback.then(books => {
    cardsrowcontent = "";
    var iterator = 0;
    books.forEach(book => {
        if(iterator == 4)
        {
            cardsrowcontent += `</div>`;
            iterator = 0;
        }
        if(iterator == 0)
        {
            cardsrowcontent += `<div class='row' id='cards-row'>`;
        }
        cardsrowcontent += `
            <div class="card">
                <div class="background" style='background-image: url("https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Gutenberg_Bible%2C_Lenox_Copy%2C_New_York_Public_Library%2C_2009._Pic_01.jpg/640px-Gutenberg_Bible%2C_Lenox_Copy%2C_New_York_Public_Library%2C_2009._Pic_01.jpg")'></div>
                <h3>${book.title}</h3>
                <span class="card-subtitle">${book.title}</span>
                <br/>
                <span class="card-text">Published: ${book.year_published}</span>
                </br>
                <a class="link mt-7" href="">Learn more</a>
            </div>
        `;
        iterator++;
    });
    cardsrow.innerHTML = cardsrowcontent;
});