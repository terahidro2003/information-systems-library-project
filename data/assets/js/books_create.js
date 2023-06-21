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

async function fetchAsyncUpdate (url, type, token, b) {
    let response = await fetch(url, {
        method: 'post',
        headers:new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        }),
        body: b
    });
    let data = await response.json();
    return data;
}

async function fetchGoogleBooksAPI(keyword)
{
    let response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=intitle:${keyword}`, {
        method: 'get',
        headers: new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        })
    });
    let data = await response.json();
    return data;
}


var feedback = fetchAsync("/system/library_api.php", "", token);

var book_title_header = document.getElementById('book-title');
var book_fields_el = document.getElementById('book-fields');
var field_inputs = "";
var fields = [];

feedback.then(book => {
    book_title_header.innerHTML = `New book`;
    var i = 0;
    for(var field in book)
    {
        if(field == 'id' || field=="added_by_user" || field == 'created_at' || field == 'updated_at' || field == 'deleted_at' || field == 'cover_image_id') continue;
        fields.push(field);
        if(field == 'type')
        {
            field_inputs+= `<select id='type' class='form-control'><option value='ebook'>Electronic</option><option value='physical'>Physical</option></select>`;
            continue;
        }
        field_inputs += `<div class='parameter'><b>${field}</b>`;
        var disabled_field = '';
        if(field == 'id') disabled_field = 'disabled';
        field_inputs += `<input type='text' id='${field}' class='form-control' placeholder='Enter ${field}...'/></div>`;
        i++;
    }
    book_fields_el.innerHTML = field_inputs;
});

function fill_google_books_api()
{
    var feedback = fetchGoogleBooksAPI(document.getElementById("title").value);
    feedback.then(book => {
        let p_book = book[0];
        console.log(book.items[0].volumeInfo.title);
        document.getElementById("title").value = book.items[0].volumeInfo.title;
        document.getElementById("description").value = book.items[0].volumeInfo.description;
        document.getElementById("year_published").value = book.items[0].volumeInfo.publishedDate.slice(0,4);
        document.getElementById("author").value = book.items[0].volumeInfo.authors[0];
        document.getElementById("ISBN_identifier").value = book.items[0].volumeInfo.industryIdentifiers[0].identifier;
        document.getElementById("page_count").value = book.items[0].volumeInfo.pageCount;
        document.getElementById("language").value = book.items[0].volumeInfo.language;
    });
}

function create()
{
    var valid = true;
    var body = ``;
    body += `token=${token}&data=insert_books`;
    for(var i = 0; i<fields.length; i++)
    {
        if(document.getElementById(fields[i]).value.length > 0)
        {
            body += `&${fields[i]}=${document.getElementById(fields[i]).value}`;
            document.getElementById(fields[i]).style.border = "1px solid #c4c4c4";
        }else{
            valid = false;
            document.getElementById(fields[i]).style.border = "1px dashed red";
        }
    }

    if(!valid)
    {
        document.getElementById("alert-validation").style.display = 'block';
        return;
    }

    var response = fetchAsyncUpdate("/system/library_api.php", "insert_books", token, body);
    response.then(r => {
        console.log(r);
        if(r.status == 'SUCCESS') {
            console.log("OK");
            document.getElementById("alert-success").style.display = 'block';
            document.getElementById("phase1").style.display = 'none';
            document.getElementById("file-upload-panel").style.display = 'block';
            document.getElementsByTagName("h4").innerHTML = "Phase 2: Book Cover";
            document.getElementById("book-id").value = r.id;
            // location.href = "/system/index.php";
        }
        else 
        {
            document.getElementById("alert-error").style.display = 'block';
        }
        console.log(r);
    });
}