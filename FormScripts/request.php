<?php
//Check if it is post and validate.
function details($title, $id){
    echo('Research Title: '.$title.'</br>');
    echo('Student/Staff Number: '.$id.'</br>');
}

function get_feedback($feedback) {
    $approved = 'background-color: green;
                    padding: 10px 10px 10px 10px;
                    border-radius: 5px;
                    color: white;';
    $rejected = 'background-color: red;
                    padding: 10px 10px 10px 10px;
                    border-radius: 5px;
                    color: white;';
    $concern = 'background-color: yellow;
                    padding: 10px 10px 10px 10px;
                    border-radius: 5px;
                    color: black;';
    $nofeedback = 'background-color: blue;
                    padding: 10px 10px 10px 10px;
                    border-radius: 5px;
                    color: white;';
    $urec = 'background-color: blue;
                    padding: 10px 10px 10px 10px;
                    border-radius: 5px;
                    color: white;';
        
    /* Take a feedback entry and output some html for the applicant showing the status */
    if (!empty($feedback)) {
        $status = rgar($feedback, '4');
        $title = rgar($feedback, '2.2');
        $fname = rgar($feedback, '2.3');
        $lname = rgar($feedback, '2.6');
        $feedback_text = rgar($feedback, '5');

        // Editing
        $edit = rgar($feedback, '8');
        $edit_password = rgar($feedback, '6');
        $edit_password = trim($edit_password);


        //some styles
        
        if ($status == 'Approved'){
                        $style = $approved;
                    } elseif ($status == 'Declined' ){
                        $style = $rejected;
                    } elseif ($status == 'Forwarded to UREC') {
                        $style = $urec;
                    } else {
                        $style = $concern;
                    }
        //Output HTML
        
        echo '<h2> Your application was handled by '.$title. ' '.$fname. ' '.$lname . '</h2></br>';
        echo '<h3>Status: <span style="'.$style.'">'.$status.'</span></br></br>';
        if ($feedback_text !== ''){ // If there is no feedback text dont add these lines.
            echo '</br><h4> Specific Feedback:</h4>';
            echo '<p style="border-style: solid;">'.$feedback_text.'</p></br></br>';
        }
        if ($edit == 'Yes'){
            if ($edit_password !== ''){
                echo '<h1>You have been requested to edit your form. Please use the following password to edit the form: '.$edit_password.' </h1>';
            }
        }
        return;
    } else {
        $style = $nofeedback;
        $feedback_text = 'Please be a little patient as we process your application.
                        Ethics is serious and we must do this carefully. Thank you for your patience.';
        $status = 'In Review';
        echo '<h3>Status: <span style="'.$style.'">'.$status.'</span></br></br></br>';
        echo '<p style="border-style: solid;">'.$feedback_text.'</p>';
    }


}
$failure = false;
if ( isset($_POST['email']) && isset($_POST['unique_id'])) {
    if (strlen($_POST['email']) < 1) {
        $failure ="Please enter a valid email address";
        unset($_POST);
    } else {
        $email = $_POST['email'];
        $id = $_POST['unique_id'];

        //Search by unique id: Application Form
        $search_criteria['field_filters'][] = array('key' => '2', 'value' => $id);
        $entries = GFAPI::get_entries('4', $search_criteria);
        $entry = $entries[0];
        //$entry2 = GFAPI::get_entry('5');

        //Search by unique id: Feedback Form
        $form_id = 5; //form id

        $search_criteria2['field_filters'][] = array('key' => 1, 'value' => $id);
        $feedback_entries = GFAPI::get_entries($form_id, $search_criteria2);
        $feedback = $feedback_entries[0];
        
        if (empty($entry)) {
            //If email doesn't exist sent a message.
            $failure ="Please check your ID again. That entry does not exist";
            unset($_POST);
        } else {
            //Get Name
            $name = rgar($entry, '3.3');
            $lname = rgar($entry, '3.6');
            $title = rgar($entry, '3.2');
            $ep_token = rgar($entry, 'fg_easypassthrough_token');
            $redirect = 'https://research.unam.edu.na/ethics/?ep_token='.$ep_token;

            $research_title = rgar($entry, '15');
            $id_no = rgar($entry, '4');
            //$test1 = var_dump($entries);
            
        }
        if (isset($_POST['edit'])){
            
            //If the password matches the password given by the DEC redirect the applicant.
            $admin_pwd = rgar($feedback, '6');
            if ($_POST['pwd_edit'] == $admin_pwd){
                echo('<h3>Redirecting...</h3></br></br>');
                echo('<script> window.location.href= "'.$redirect.'";</script>');
                //echo('<a href='.$redirect.'>HERE</a>');
                exit;
            } else {
                $failure = "The DEC responsible has not yet given you permission to edit this form";
                unset($_POST);
            }
        } elseif (isset($_POST)){ //This elseif only makes sure that $_POST is still set so that it can write this information.
        
        echo('<h1> Welcome '.htmlentities($title).' '.htmlentities($name).' '.htmlentities($lname).'</h1>');
        details($research_title, $id_no);
        echo '</br></br>';
        get_feedback($feedback);
        }
    }
}
if (!isset($_POST['email'])) {
    if (isset($failure)) {
        echo('<h2 style="color: red;">'.$failure.'</h2>');
    }
    
    echo('<h1>Please enter your information</h1>');
    echo '<table>';

    echo('<form method="POST">');
    echo '<tr>';

        echo '<td>';
            echo('<label for="email">Email</label>');
        echo '</td>';

        echo '<td>';
            echo('<input type="text" name="email" id="email"></br>');
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo('<label for="unique_id">Unique ID</label>');
        echo '</td>';

        echo '<td>';
            echo('<input type="text" name="unique_id" id="unique_id"></br>');
        echo '</td>';
    echo '</tr>';
    echo '<tr>';
        echo '<td>';
            echo('<label for="pwd_edit">Password for Editing</label>');
        echo '</td>';

        echo '<td>';
            echo('<input type="text" name="pwd_edit" id="pwd_edit"></br>');
        echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
        echo '<td>';
            echo('<input type="submit" value="Search">');
        echo '</td>';
        echo '<td>';
            echo('<input type="submit" name="edit" value="Edit">');
        echo '</td>';
    echo '</tr>';
    echo('</form>');
    
    echo '</table>';
    echo('</br></br><h4 style="color: red;">Please note that all uploaded files must be re-uploaded when you edit your entry.</h4>');
}
?>

