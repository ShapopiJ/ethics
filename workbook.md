This highlights work done on this project.

## Date: 25/08/2021

* All forms have been modelled.
* Editing entries has been setup by appending the ep_token to the url.
* The display page work has been started
    - Applicants can search for their entry using their unique id.
    - Applicants can edit their entries.

## Date: 27/08/2021

* Today I design an admin form that is fed with the uniqe id for an application using easy pass through.
    - Step 1: design form
    - Step 2: Set up easy passthrough entry for this form
    - Step 3: Ask for Unique ID then process the $_POST
        * If entry exist go to it and replace it
            - This requires another entry in the snippet to replace entries
        * If it doesn't: make new one.
* The form for giving feedback is done.
* It can be updated by the DEC
* Next item is to set hashed Password

## Date: 28/08/2021

* Setting the password.
* I find this only necessary for the Admins.
* I will set a basic passowrd and hash it.
* Password is set up and hashed with MD5 (unam@2021)
* Many contingencies were also set.
* Next is to find a way to lock the page where the admin form is and only make it accessible from the dec-request page.

## Date: 29/08/2021

* I change the admin page to reather display the form if the entry does not exist yet and move to a different page with easy passthrough if entry already exists.
* I changed back to a simple redirect because this one does not add default css.
* I simply password protected the admin form page.
* Added numbering functionality to the feedback area.