moodle-block_onlineexam
=========================

[![Moodle Plugin CI](https://github.com/evasys-community/moodle-block_onlineexam/workflows/Moodle%20Plugin%20CI/badge.svg?branch=master)](https://github.com/evasys-community/moodle-block_onlineexam/actions?query=workflow%3A%22Moodle+Plugin+CI%22+branch%3Amaster)

Moodle block plugin which allows you to quickly and easily integrate exams from evaexam into Moodle. With this block, you can place links to evaexam online exams directly on the Moodle frontpage and dashboard as well as on course overview pages.


Moodle requirements
-------------------

This plugin requires Moodle 3.11+


evaexam requirements
-------------------

Please note that this plugin requires a commercial subscription of evaexam and a running instance of at least evaexam version 7.1 (2151).

For details about evaexam, please see
https://en.evasys.de/evaexam (english) or
https://www.evasys.de/evaexam (german).


Plugin description
------------------

This plugin allows you to quickly and easily integrate exams from evaexam into Moodle. With this block, you can place links to evaexam online exams directly on the Moodle frontpage and dashboard as well as on course overview pages.

Data will be exchanged via SOAP web services. Exam information can only be displayed in the learner view.

By implementing a single sign-on solution, learners as well as instructors only have to register with Moodle. It is not necessary to enter evaexam PSWDs to participate in exams.


Installation
------------

Install the plugin like any other plugin to folder
/blocks/onlineexam

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

To configure the plugin and its behaviour, please visit:
Site administration -> Plugins -> Blocks -> Exams (evaexam).

There, you find multiple sections:

### Appearance

The settings in this section define how the evaexam block will be displayed.

### Communication

The settings in this section define how the evaexam block will communicate with evaexam.

### SOAP settings

The settings in this section define how the evaexam block will communicate with evaexam.
These settings are only required if you selected "SOAP" in the "Communication protocol" setting.

### Expert settings

The settings in this section normally don't need any modification and are provided for special usage scenarios.


Documentation
-------------

An in-depth documentation of the plugin's settings and its usage is provided as PDF on
https://github.com/evasys-community/moodle-block_onlineexam/blob/master/DOCUMENTATION.en.pdf (english) and
https://github.com/evasys-community/moodle-block_onlineexam/blob/master/DOCUMENTATION.de.pdf (german).


Theme support
-------------
This plugin has been developed on and tested with Moodle Core's Boost and Clean (until Moodle 3.6) and Classic (from Moodle 3.7 on) themes.
While this plugin should also work with other Bootstrap-based third party themes, we can't support any other theme than Boost, Clean and Classic.


Plugin repositories
-------------------

This plugin is published and regularly updated in the Moodle plugins repository:
http://moodle.org/plugins/view/block_onlineexam

The latest development version can be found on Github:
https://github.com/evasys-community/moodle-block_onlineexam


Bug and problem reports / Support requests
------------------------------------------

Please report bugs and problems on Github:
https://github.com/evasys-community/moodle-block_onlineexam/issues


Feature proposals
-----------------

Please issue feature proposals on Github:
https://github.com/evasys-community/moodle-block_onlineexam/issues

Please create pull requests on Github:
https://github.com/evasys-community/moodle-block_onlineexam/pulls


Translating this plugin
-----------------------

This Moodle plugin is shipped with an english language pack only. All translations into other languages must be managed through AMOS (https://lang.moodle.org) by what they will become part of Moodle's official language pack.

As the plugin creator, we manage the translation into german on AMOS. Please contribute your translation into all other languages in AMOS where they will be reviewed by the official language pack maintainers for Moodle.


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


Maintainers & Copyright
-----------------------

Product owner:\
evasys GmbH\
www.evasys.de

Current maintainer and developer:\
Moodle partner lern.link\
www.lernlink.de


Credits
-------

This plugin was initially developed by:\
Soon-Systems-GmbH\
www.soon-systems.de
