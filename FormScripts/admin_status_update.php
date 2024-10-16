<?php

//Check if it is post and validate.
$form_id = 5; //form id
$field_id_of_unique_id = 1;
$failure = false;
//setcookie('gp_easy_passthrough_session', "", time() - 3600);
//$entry = NULL;
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
            $email = rgar($application, '7');
            $email_sup = rgar($application, '30');
            //$sup_name = rgar($application, '24');
            $sup_title = rgar($application, '24.2');
            $sup_fname = rgar($application, '24.3');
            $sup_lname = rgar($application, '24.6');
            $student_num = rgar($application, '4');
            $r_title = rgar($application, '15');
            
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
                    //setcookie('gp_easy_passthrough_session','', time() - 1000);
                    //setcookie('_lscache_vary','', time() - 1000);
                    //if(isset($_COOKIE['gp_easy_passthrough_session'])) {
                    //    echo "<script> console.log('I am in a new entry the session cookie should not be set'); </script>";
                    //    echo "<script> console.log(".$_COOKIE['gp_easy_passthrough_session']."); </script>";
                    //}
                    
                    $url = 'https://research.unam.edu.na/dec-admin/?unique_id='.$unique_id.'&email='.$email.'&email_sup='.$email_sup.'&student_num='.$student_num.'&r_title='.$r_title;
                    //$url = 'https://research.unam.edu.na/dec-admin/?unique_id='.$unique_id.'&email='.$email.'&email_sup='.$email_sup.'&sup_title='.$sup_title.'&sup_fname='.$sup_fname.'&sup_lname='.$sup_lname;
                    echo('<script> window.location.href= "'.$url.'";</script>');
                    exit;
                } else { //If it already exists, edit the existing
                    echo('<h1></br>Redirecting...</h1>');
                    $ep_token = rgar($entry, 'fg_easypassthrough_token');
                    $redirect = 'https://research.unam.edu.na/dec-admin/?ep_token='.$ep_token.'&email='.$email.'&email_sup='.$email_sup.'&student_num='.$student_num.'&r_title='.$r_title;
                    //$redirect = 'https://research.unam.edu.na/dec-admin/?ep_token='.$ep_token.'&email='.$email.'&email_sup='.$email_sup.'&sup_title='.$sup_title.'&sup_fname='.$sup_fname.'&sup_lname='.$sup_lname;
                    //setcookie('gp_easy_passthrough_session', "", time() - 3600);
                    //unset($_COOKIE["gp_easy_passthrough_session"]);
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
//echo "<script> console.log('Test');</script>";
if(isset($_COOKIE['gp_easy_passthrough_session'])) {
   echo "<script> console.log('Deleting all cookies'); </script>";
   // unset cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
}
/*if(isset($_COOKIE['gp_easy_passthrough_session'])) {
    echo "<script> console.log('Deleting all cookies'); </script>";
   // unset cookies
   echo "<script> localStorage.clear(); </script>";
}*/
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

