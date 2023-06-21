/*
    Async type function for fetching API data
*/
async function fetchAsyncBorrow (url, type, token, id) {
    let response = await fetch(url, {
        method: 'post',
        headers:new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        }),
        body: `token=${token}&data=${type}&id=${id}`
    });
    console.error(`token=${token}&data=${type}&id=${id}`);
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

//HTML field mappings
var feedback = fetchAsyncBorrow("/system/library_api.php", "get_book_by_id", token, book_id);
var book_title_header = document.getElementById('book-title');
var book_fields_el = document.getElementById('book-fields');

//Variables
var field_inputs = "";
var fields = [];

//Gather column names & display data from API
feedback.then(book => {
    book_title_header.innerHTML = `Book: ${book[0].title}`;
    document.title = `${book[0].title} | LIMS | v0.0.1`;
    var i;
    for(var field in book[0])
    {
        if(field == 'name' && field.length > 0) 
        {
            document.getElementById("book-cover-bg").style.backgroundImage = `url('/system/files/${book[0][field]}')`;
        }
        if(field == 'id' || field == 'filetype' || field == 'added_by' || field == 'name') continue;
        fields.push(field);
        field_inputs += `<div class='parameter'><b>${field}: </b>`;
        if(book[0][field] != null)
        {
            field_inputs += `${book[0][field]}</div>`;
        }else{
            field_inputs += `</div>`;
        }
        i++;
    }
    book_fields_el.innerHTML = field_inputs;
});

/*
Send borrow insert with status PENDING APPROVAL to the leases API
*/
function borrow()
{
    var borrow_req = fetchAsyncBorrow("/system/leases_api.php", "insert_lease", token, book_id);

    borrow_req.then(res => {
        if(res.status == "SUCCESS")
        {
            document.getElementById("alert-success").style.display = "block";
        }
    });
}