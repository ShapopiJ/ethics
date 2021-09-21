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
        echo '<h3>Status: <span style="'.$style.'">'.$status.'</span></br>';
        echo '</br><h4> Here is your feedback:</h4>';
        echo '<p style="border-style: solid;">'.$feedback_text.'</p>';
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
            echo('<h1>Please check your email again. That entry does not exist</h1>');
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
            echo('<h3>Redirecting...: </h3></br></br>');
            
            echo('<script> window.location.href= "'.$redirect.'";</script>');
            //echo('<a href='.$redirect.'>HERE</a>');
            exit;
        } else{
        
        echo('<h1> Welcome '.htmlentities($title).' '.htmlentities($name).' '.htmlentities($lname).'</h1>');
        details($research_title, $id_no);
        echo '</br></br>';
        get_feedback($feedback);
        }
    }
}
if (!isset($_POST['email'])) {
    echo('<h1>Please enter your information</h1>');
    echo('<form method="POST">');
    echo('<label for="email">Email</label>');
    echo('<input type="text" name="email" id="email">');
    echo('<label for="unique_id">Unique ID</label>');
    echo('<input type="text" name="unique_id" id="unique_id"><br/>');
    echo('<input type="submit" value="Search">');
    echo('<input type="submit" name="edit" value="Edit">');
    echo('</form>');
    echo('</br></br><h4 style="color: red;">Please note that all uploaded files must be re-uploaded when you edit your entry.</h4>');

}
?>

