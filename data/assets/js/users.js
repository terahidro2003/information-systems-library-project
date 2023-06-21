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

var users_request_type = "get_all_users"; //determined whether we want to get all leases 
if(!is_admin)                                //or leases of the current user (if not admin)
{
    console.log("not admin user");
}                                            

var feedback = fetchAsync("/system/users_api.php", users_request_type, token);

var users_rows = document.getElementById('users-rows');
var row_content = "";
feedback.then(users => {
    if(users.length == 0)
    {
        //check for impossible condition
        row_content += `<div class="alert alert-warning">No users found</div>`;
    }else{
        row_content += `
                <div class="divTableRow divTableHeaderRow">
                    <div class="divTableCell">ID</div>
                    <div class="divTableCell">Email </div>
                    <div class="divTableCell">Role </div>
                    <div class="divTableCell">Language </div>
                    <div class="divTableCell">Created</div>
            `;

            // Display poosible actions if user is admin
            if(is_admin) row_content+= `<div class="divTableCell">Actions</div></div>`;
            else row_content += `</div>`;
        
        users.forEach(user => {
            var iterator = 0;
            row_content += `
                <div class="divTableRow">
                    <div class="divTableCell">${user.id}</div>
                    <div class="divTableCell">${user.email}</div>
                    <div class="divTableCell">${user.role}</div>
                    <div class="divTableCell">${user.language}</div>
                    <div class="divTableCell">${user.created_at}</div>
            `;

            // Display poosible actions if user is admin
            if(is_admin) row_content += `<div class="divTableCell">`;
            
            //Diversify available actions according to lease status
            if(is_admin && user.role == 0) row_content += `<a onclick="makeAdmin(${user.id})" class="btn btn-primary">Make admin</a><a onclick="deleteUser(${user.id})" class="ml-5 btn btn-danger">Delete</a></div>`;

            row_content += `</div></div>`;
            iterator++;
        });
    }
    users_rows.innerHTML = row_content;
});

function makeAdmin(id)
{
    if(id == null || id < 0) return; //id not provided --> unable to perform operation

    var body = `token=${token}&data=make_admin&id=${id}`;
    var response = fetchAsyncUpdate('/system/users_api.php', 'make_admin', token, body);
    

    response.then(r => {
        if(r.status == "SUCCESS")
        {
            console.log("OK");
            location.reload();
        }else console.error("FAILED UPDATE");
    });
    location.reload();
}

function deleteUser(id)
{
    if(id == null || id < 0) return; //id not provided --> unable to perform operation

    var body = `token=${token}&data=delete_user&id=${id}`;
    var response = fetchAsyncUpdate('/system/users_api.php', 'delete_user', token, body);
    

    response.then(r => {
        if(r.status == "SUCCESS")
        {
            console.log("OK");
            location.reload();
        }else console.error("FAILED UPDATE");
    });
    location.reload();
}