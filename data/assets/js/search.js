async function fetchAsync (url, type, query, token) {
    let response = await fetch(url, {
        method: 'post',
        headers:new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        }),
        body: `token=${token}&data=${type}&query=${query}`
    });
    let data = await response.json();
    return data;
}


var search_query_input = document.querySelector('#search-input'); 
var search_results_panel = document.querySelector('#search-results-panel');
var search_dialog = document.querySelector('#search-dialog');
var results_html = "";

search_query_input.addEventListener("input", function() { 
    //clear previuos results from dialog
    search_results_panel.innerHTML = "";
    results_html = "";

    //prepare request and store promise
    var feedback = fetchAsync("/system/search_api.php", "yes", search_query_input.value, token);

    //process promise from POST request
    feedback.then(result =>{
        console.log(result); //DEBUG
        result.forEach(r => {
            
            results_html += `<div class="result">${r.title} (${r.author})</div>`;
        });

        //display results
        search_results_panel.innerHTML = results_html;
    });

    if(search_query_input.value.length == 0)
    {
        search_dialog.style.display = "none";
    }
}); 


function opensearchdialog()
{
    //clear previuos results from dialog
    search_results_panel.innerHTML = "";
    search_dialog.style.display = "block";    
}

function closesearchdialog()
{
    //clear previuos results from dialog
    search_results_panel.innerHTML = "";
    search_dialog.style.display = "none";    
}