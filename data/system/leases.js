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

var leases_request_type = "get_all_leases"; //determined whether we want to get all leases 
if(!is_admin)                                //or leases of the current user (if not admin)
{
    console.log("not admin user");
    leases_request_type = "get_current_leases";
}                                            

var feedback = fetchAsync("/system/leases_api.php", leases_request_type, token);

var leases_rows = document.getElementById('leases-rows');
var leases_title = document.getElementById('leases-title');
var row_content = "";
feedback.then(leases => {
    if(leases.length == 0)
    {
        row_content += `<div class="alert alert-warning">No lease history found</div>`;
    }else{
        row_content += `
                <div class="divTableRow divTableHeaderRow">
                    <div class="divTableCell">&nbsp;ID</div>
                    <div class="divTableCell">Book Title </div>
                    <div class="divTableCell">Author </div>
                    <div class="divTableCell">Leased to </div>
                    <div class="divTableCell">Deadline </div>
                    <div class="divTableCell">Status</div>
            `;

            // Display poosible actions if user is admin
            if(is_admin) row_content+= `<div class="divTableCell">Actions</div></div>`;
            else row_content += `</div>`;
        
        leases.forEach(lease => {
            var iterator = 0;
            row_content += `
                <div class="divTableRow">
                    <div class="divTableCell">${lease.id}</div>
                    <div class="divTableCell">${lease.title}</div>
                    <div class="divTableCell">${lease.author}</div>
                    <div class="divTableCell">${lease.email}</div>
                    <div class="divTableCell">${lease.deadline}</div>
                    <div class="divTableCell">${lease.status}</div>
            `;

            // Display poosible actions if user is admin
            if(is_admin) row_content += `<div class="divTableCell">
                <a onclick="changeStatus('authorize', ${lease.id})" class="btn btn-primary">Authorize</a>
                <a onclick="changeStatus('end', ${lease.id})" class="btn btn-danger">End lease</a>
            </div></div>`;
            else row_content += `</div>`;

            iterator++;
        });
    }
    leases_rows.innerHTML = row_content;
});

function changeStatus(to, id)
{
    //if librarian chooses to authorize lease request (confirm it)
    if(to == "authorize")
    {
        var changableStatus = 'AUTHORIZED';
    }else if(to == "end") var changableStatus = 'TERMINATED'; 
    else{return;} //if no status code provided, something's wrong -- going back

    if(id == null || id < 0) return; //id not provided --> unable to perform operation

    var response = fetchAsyncUpdate('/system/leases_api.php', 'change_status', token, body);
    var body = `token=${token}&data=change_status&id=${id}&status=${changableStatus}`;

    response.then(r => {
        if(r == "SUCCESS")
        {
            console.log("OK");
            location.reload();
        }else console.error("FAILED UPDATE");
    });
}

function update()
{
    var body = ``;
    body += `token=${token}&data=edit_books`;
    for(var i = 0; i<fields.length; i++)
    {
        console.log(fields[i]);
        body += `&${fields[i]}=${document.getElementById(fields[i]).value}`;
    }
    console.log(body);
    var response = fetchAsyncUpdate('/system/library_api.php', 'edit_books', token, body);
    response.then(r => {
        if(r == 'SUCCESS') {
            console.log("OK");
            location.reload();
        }
        else console.error("FAILED UPDATE");
    });
}