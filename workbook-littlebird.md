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

## Date 03/09/2021

* Change Campus and School to one list of DEC's
* Forwarded to UREC
* I must fix the no duplicates functionality:
    - Someone can just got to dec-admin page and enter the details of a review that already exists.
        * So I turned on "No Duplicates for Unique ID"
    - This however does not allow easypassthrough to work anymore.
    - Perhaps you must validate the duplication in the easypassthrough code snippet (gpedit)

## Date 09/09/2021

[x] Fix the field mapping for edits in easy passthrough. They are not properly matched.
* Now properly matching

## Date 13/09/2021

### Comments by Prof. Indongo:

[x] Professional status (is this to say whether Student or Academic staff???)
* I proposed to remove it. No confirmation received.
[x] Qualification and institution (can it optional for staff; may be important for students; my suggestion)
[x] Main campus is listed as DEC (Please check and specify which DEC is this else remove; check list of DEC; Prof Davis how many in total those are the ones to be included here. I also notice that Multidisciplinary Research is excluded)
* Main campus removed
[x] What if collaborators are external (we only need to indicate the institution and country may be)
* Added Institution and Country.

[x] I notice that after submission; the system can again give you option to edit when you want to check status. How will we control this?

Proposed solution:

1.	Add a password field that is required if they want to edit
2.	The password will be set by the DEC (in the form where they give feedback) if they require the applicant to edit their application.
3.	Then one of the following (Please choose one):
    *	This password will need to be sent by the DEC to the applicant when the DEC wants the application to be edited or
    *	The password will be automatically sent to the applicants email address if the DEC requires the application to be edited.

## Date 21/09/2021

### Comments by Prof. Davis:

[x] It would be useful to generate a pdf form of the entire application for the applicants records once it is complete so they can check it before submission.

[x] Under source of funding, can we add the option of other so applicants can fill in information which is not included in the options, perhaps most questions with options should also have the choice to select for other.

[x] Under this section: Research ethics considerations in the research proposal - when the applicant's response is no, can we add a text for them to explain why they said no. 
* Added one field for all of the fields in question.

[x] On some of the options such as for vulnerable populations.... Does study involve vulnerable groups, no should be an option.
* Added none of the above.

## Date 23/09/2021

[x] Fix the issue with the emailing going to junk.
[x] Fix the issue of emails not arriving in mailbox of @unam.

## Date 25/09/2021

[x] Setup backup system
* Backups will be uploaded to my gdrive

## Date 30/09/2021

[x] Fix the exemption section conditional problem.

## Date 14/10/2021

[ ] Links should open in different tabs.
- Unsuccefull

[ ] Number all the fields.
- Can't find a solution to this at the moment.

## Date 18/10/2021
[ ] Move backups to microsoft onedrive
- This requires a PHP update on the server. Ask about this.
- This cannot be accomplished this year. We can only do it when we recieve a new server.
- Same for getting a AD with UNAM credentials.


## Date 26/10/2021
[x] Links should open in different tabs.
[x] Fix "Go to Helpdesk button.
[x] Say the reply should be ready withing 14 days.
[x] Make the link sent, dynamically fill the Unique ID. 
- Make sure that when submitted it replaces any entry that is already in.
- Use a get response and a dynamic fill on the Unique ID field.

## Date 9/11/2021

[x] Ethics Certificate.

[x] Start making a directory of all applications that were submitted.
- Is there a way to make this directory show which are approved and declined?

## Date 9/11/2021

[x] Completed making of the directory.

## Date 3/2/2022

- Meeting with Ethics coordinators
[x] change rejected -> "please attend to the comments and resubmit"
[x] Add coordinators to notifications
[x] Send stats to Du Preez
[x] Change 14 day feedback -> Feedback will be given 14 days subject to the Decentralized Ethics Committe meeting. Please email ethics@unam.na to find out when the DEC will meet.

## Date 2/3/2022

- I cannot register an app on MS Azure with my UNAM credentials. Access denied.

# Tasks

* Fix no duplicate functionality. Problem described in 03/09/2021
* Make link with get variables the default also the default link sent to the DEC chairperson
* Number all the fields.
* Supervisor Signatures.
* Make dashboard of statistics

# Tasks 2022
* Get AD with UNAM credentials.
* Move backups to microsoft onedrive.
    - This requires a PHP update on the server. Ask about this.
