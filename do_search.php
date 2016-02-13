<?php
//if we got something through $_POST
if (isset($_POST['search'])) {

    // here you would normally include some database connection
    include('TestLogin.php');
    $db = new db();

    // never trust what user wrote! We must ALWAYS sanitize user input
    $word = mysql_real_escape_string($_POST['search']);
    // $word = htmlentities($word);
    echo $word;
    // sql query where user search word is in firstname, lastname, or email
    $sql = "SELECT DISTINCT firstname, lastname, user_id FROM mgroupmat_master.Users WHERE firstname LIKE '%" . $word . "%' OR lastname LIKE '%" . $word . "%' OR email LIKE '%" . $word . "%'";
    // get results
    $row = $db->select_list($sql);
    if(count($row)) {
        $end_result = '';
        foreach($row as $r) {
            $result         = $r['firstname'];
            // we will use this to bold the search word in result
            $bold           = '<span class="found">' . $word . '</span>';    
            $end_result     .= '<li>' . str_ireplace($word, $bold, $result) . '</li>';            
        }
        echo $end_result;
    } else {
        echo '<li>No results found</li>';
    }
}
?>