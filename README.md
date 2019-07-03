moodle-block_onlineexam
=====================================
The moodle plugin allows you to view open exams within a block in Moodle.

Detail: 
By using the "onlineexam" plug-in, open exams for a user are displayed within a block in Moodle. The data request for open exams of a user can is carried out via LTI. 
The connection to a user can be established either on the basis of the user name or the email address. 
If the user name is used, a specified EvaExam custom field can serve as a method of authentication. 
It is possible to define customized LTI parameters and to map the LTI specific roles "Instructor" and "Learner" in Moodle, e.g. "Learner" --> "Student".
It is also possible to use a pop-up message to alert participants about open exams. 


Requirements
------------
This plug-in requires Moodle version 3.1 or higher and EvaExam version 8.0 (2200). 


Installation
------------

Please install the plug-in into the directory "blocks":
/blocks/onlineexam


Usage & Settings
----------------
After installation, the plug-in has to be configured.
To do this, please go to:
Site administration--> Plugins --> Blocks --> Exams (EvaExam)

There are three sections:

### General Settings

Here you can enter information about the block title that is displayed, user identification, connection timeout and the display of the pop-up dialog.


### LTI Settings

Connection data for LTI is entered here. Furthermore, additional parameters can be defined which will be transferred as well. You can also define role mappings. 
If the pop-up dialog shall be used, a regular expression must be specified in order to determine whether the LTI result contains open exams.