<?php

//Check if it is post and validate.
$form_id = 5; //form id
$field_id_of_unique_id = 1;
$failure = false;
if (isset($_POST['unique_id']) && isset($_POST['pwd'])){
    if (strlen($_POST['unique_id']) < 1 || strlen($_POST['pwd']) < 1) {
        $failure = 'Please enter the ID and Password';
    } else {
        $unique_id = $_POST['unique_id'];
        //Check password here.
        $hash = 'd676911c1af0fc39b0587b20278d09d8';
        $check = md5($_POST['pwd']);
        if ($check == $hash) {
            //See if an application with that ID exists:
            $search['field_filters'][] = array('key' => '2', 'value' => $unique_id);
            $applications = GFAPI::get_entries('4', $search);
            $application = $applications[0];
            
            if (empty($application)) {
                $failure = 'That application ID does not exist please check again';
            } else {

                //Search for the entry in the form for admins
                $search_criteria['field_filters'][] = array('key' => $field_id_of_unique_id, 'value' => $unique_id);
                $entries = GFAPI::get_entries($form_id, $search_criteria);
                $entry = $entries[0];


                if (empty($entry)){
                    //gravity_form(5,$field_values = array('1' => $unique_id));
                    echo('<h1></br>Redirecting...</h1>');
                    $url = 'https://research.unam.edu.na/dec-admin';
                    echo('<script> window.location.href= "'.$url.'";</script>');
                    exit;
                } else { //If it already exists, edit the existing
                    echo('<h1></br>Redirecting...</h1>');
                    $ep_token = rgar($entry, 'fg_easypassthrough_token');
                    $redirect = 'https://research.unam.edu.na/dec-admin/?ep_token='.$ep_token;
                    echo('<script> window.location.href= "'.$redirect.'";</script>');
                    exit;
                }
            }
        } else {
            $failure = 'You do not have permission to review applications';
        }
    }
}
/*
if (!isset($_POST['unique_id'])) {
    echo('<h1>This page is for DEC and URECs only!</h1></br>');
    echo('<form method="POST">');
    echo('<label for="unique_id">Please enter the Unique id for the application</label>');
    echo('<input type="text" name="unique_id" id="unique_id"><br/>');
    echo('<label for="pwd">Password</label>');
    echo('<input type="text" name="pwd" id="pwd"><br/>');
    echo('<input type="submit" value="Search">');
    echo('</form>');

}
*/
if ($failure !== false){
    echo '<h1 style="color:red;">'.htmlentities($failure).'</h1>';
}
echo('<h1>This page is for DEC and URECs only!</h1></br>');
echo('<form method="POST">');
echo '<table>';
echo '<tr>';
    echo '<td>';
        echo('<label for="unique_id">Please enter the Unique id for the application</label>');
    echo '</td>';
    echo '<td>';
        echo('<input type="text" name="unique_id" id="unique_id"><br/>');
    echo '</td>';
echo '</tr>';

echo '<tr>';
    echo '<td>';
        echo('<label for="pwd">Password</label>');
    echo '</td>';
    echo '<td>';
        echo('<input type="password" name="pwd" id="pwd"><br/>');
    echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo('<input type="submit" value="Search">');
echo '</td>';
echo '<tr>';
echo '</table>';
echo('</form>');
?>

