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
                <div class="book-card-bg" style='background-image: url("files/${book.name}")'></div>
                <h3>${book.title}</h3>
                <span class="card-subtitle">${book.title}</span>
                <br/>
                <span class="card-text">Published: ${book.year_published}</span>
                </br>
                <form method='get' action='/system/books_view.php'>
                    <input type='hidden' name='book_id' value='${book.id}'>
                    <button type='submit' class="link mt-7">Learn more</button>
                </form>
                <form method='get' action='/system/books_edit.php'>
                    <input type='hidden' name='book_id' value='${book.id}'>
                    <button type='submit' class="link mt-7 ml-5">Edit</button>
                </form>
            </div>
        `;
        iterator++;
    });
    cardsrow.innerHTML = cardsrowcontent;
});