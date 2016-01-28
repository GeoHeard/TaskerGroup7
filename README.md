# TaskerGroup7

The tasker system is a method of creating and allocating tasks to users through a web client (TaskerMAN) web server (TaskerSVR) and a local client (TaskerCLI)

PREREQUISITES

Which Operating Systems will I be able to install taskerCLI on?

taskerCLI should work on all common Operating Systems, including all tested versions of Microsoft Windows, Mac OS, and Linux that can run a Java virtual machine.

Are there any required downloads for taskerCLI?

taskerCli requires the JDBC driver, which is currently bundled with the .java file.

Which Operating Systems will taskerMAN be usable on?

taskerMan will be platform and will run on any Operating System. We recommend the use of google chrome, as some of the features used are best implemented in chrome. 

Are there any required downloads for taskerMAN?

There are possibly no required downloads for taskerMAN although it is recommended that one uses the Operating Systems specified in the question above.

What is required for taskerSVR?

taskerSVR runs on an apache server using a MySQL DBMS. To access the database requires a password and login.

USING taskerCLI

How do I login?

Simply enter your email when prompted (in full) and then press the login button. If another use is logged into that instance of the system on a machine then you could log them out by pressing the logout button, or use another machine.

How do I update my task details?

One’s tasks will be available to them immediately after logging in, listed on the margin of the window. Click on the task that is the subject of interest and add any new data into the fields displayed on the main part of the window. After updating fields, the user can discard their changes by clicking ‘Cancel’ or confirm them by clicking ‘Submit’ to attempt to save the data to the database.

Can I view/ update another user’s tasks?

A user will only be able to see and edit their own task details after they login and before they log out; this is a security measure, and it also enables quick viewing of the tasks relevant to the one using the system.

taskerCLI ERRORS

HOW DO I FIX BUG??

Most errors that will occur with the client will arise from a loss of connection. If that is the case, the best thing to do is probably close the application down and reload it once the connection has returned.

USING taskerMAN

How do I create a new team member?

Select ‘Manage members’ in the top right corner of the page. Select ‘New Member’ underneath the taskerMAN header. You will now be prompted with Last name, First name, and Email address fields into which you must enter the details of the new team members. When you are finished you can select ‘Create’ to send the details to the database, or ‘Cancel’ to discard the update (and cause problems).

How do I edit an existing team member?

Select ‘Manage members’ in the top right corner of the page. Select the member you wish to edit. A form will appear in the main area of the screen with a member's details. You can make changes to a member and the click ‘Confirm changes’.

How do I delete a team member?

Select the team member you wish to delete, a delete button will appear. Upon clicking it you will be prompted to confirm your deletion. Once deleted you will be redirected to the main page.

How do I filter tasks?  &
Which parameters can I filter by?

Select ‘Manage tasks’ in the top right corner of the page. Select ‘Filter tasks’ underneath the taskerMAN header. You will be able to select a ‘task status’ and an allocated ‘team member’ to filter by with two separate drop-down boxes. Press ‘Submit’ and the list of tasks will change. Press ‘Cancel’ to remove the filter (and cause problems). An example of filtering is to select ‘allocated’ and ‘Smith, John (jsmith@mail.com)’ and to be shown all of the tasks belonging to John Smith which have the status ‘allocated’.

How do I create a new task?

Select ‘Manage tasks’ in the top right corner of the page. Select the ‘New Task’ underneath the taskerMAN header. You will now be prompted with Task Title, Allocated team member, Start date, and Expected completion date. Allocated team member is a drop down box which lists existing team members and their email addresses, to prevent incorrect input. Start date and Expected completion date will be displayed as calendars if one uses the recommended browser, Google Chrome, but may be free text in some other browsers (the date format is YYYY-MM-DD). Press ‘Create’ if you are happy with the details you have entered, and send them to the database, and ‘Cancel’ to discard the data (currently this asks you to enter data into the blank fields for some reason).

How do I edit an existing task?

Select ‘Manage tasks’ in the top right corner of the page. Select the task you wish to edit. A form will appear in the main area of the screen with a task’s details. You can make changes to a task and click ‘Confirm changes’.

taskerMAN ERRORS

HOW DO I FIX BUG??

Ask Chris?

taskerSVR

HELP I CANNOT CONNECT!!

You’re probably screwed.
Contact your network administrator for more details.

email: twd@aber.ac.uk for more information
