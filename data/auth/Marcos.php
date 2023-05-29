<?php
//LOGIN CHECKLIST
// 1. Check if POST request was created (with isset(param1, param2))
    // for ex.: if(isset($_POST['field1'], $_POST['field2']))
//2. Validate password and username (check if they're not empty and passsword is minimum 8 symbols)
//3. Execute select query that selects password from users table where username = $_POST['username']
//4. Check if returned rows count > 0
//5. Check if password from DB equals to $_POST['password']
//6. Redicrect to home page or whatever

/*
SIGNUP CHECKLIST
1. Check if POST request was created (with isset(param1, param2))
2. Validate password and username (check if they're not empty and passsword is minimum 8 symbols)
3. Insert username, password into users table
4. Return to login page
*/

//CRUD 
/*
create read update delete
insert select update remove (sql)
insert = update
select = remove
*/

//Books table
/*
TODO: description and inputs with parenthesis are not supported
TODO: remove system-only fields from user perspective (timestamps, id's)
TODO: picture support

CREATE - implemented
READ - implemented
UPDATE - implemented
DELETE - implemented
*/

?>