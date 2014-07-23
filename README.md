SampleCode
==========

This repository is a collection of PHP files that:

1) Create an object from a database wrapper class (object-oriented PHP). 

2) Using the database object, initiate a connection to a MySQL database. 

3) Populate an employee/coworker screen with data (retrieved via the database class).  The screen also allows you to edit existing coworkers and add new ones as well. 



This repository consists of the following files: 

1) coworker.php - This contains the code to build the coworker data entry screen.

coworker.php contains the following include files:

2) intranet.inc.php - Gather the necessary include files and handle up the initial database login. 

3) session.inc - Set up the PHP session variables (user name, password). 

4) traffic.inc - A PHP file which ouputs JavaScript code involved with redirecting the user to different pages. 

5) globals.inc - Define global variables such as database name, username, password, and some global arrays. 

6) databases.inc - Open source database wrapper classes.


