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

var feedback = fetchAsync("/system/library_api.php", "", token);

var book_title_header = document.getElementById('book-title');
var book_fields_el = document.getElementById('book-fields');
var field_inputs;
var fields = [];

feedback.then(book => {
    book_title_header.innerHTML = `New book`;
    var i;
    for(var field in book)
    {
        fields.push(field);
        field_inputs += `<div class='input-group'><label>${field}</label>`;
        var disabled_field = '';
        if(field == 'id') disabled_field = 'disabled';
        field_inputs += `<input type='text' id='${field}' class='form-control' placeholder='Enter ${field}...'/>`;
        i++;
    }
    book_fields_el.innerHTML = field_inputs;
});

function create()
{
    var body = ``;
    body += `token=${token}&data=insert_books`;
    for(var i = 0; i<fields.length; i++)
    {
        if(document.getElementById(fields[i]).value.length > 0)
        {
            body += `&${fields[i]}=${document.getElementById(fields[i]).value}`;
        }
    }

    var response = fetchAsyncUpdate("/system/library_api.php", "insert_books", token, body);
    response.then(r => {
        if(r == 'SUCCESS') {
            console.log("OK");
            location.href = "/system/index.php";
        }
        else console.error("FAILED UPDATE");
        console.log(r);
    });
}