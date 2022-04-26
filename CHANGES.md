moodle-block_onlineexam
=======================

Changes
-------

### Unreleased

* 2022-01-08 - Upgrade block_onlineexam to match the latest version and feature set of block_onlinesurvey.
               From now on, both plugins will be maintained simultaneously.
               However, block_onlineexam will only support SOAP connections from Moodle to evaexam from now on. The functionality for LTI connections was removed.
               This means, if you are upgrading an installation from a previous version of block_onlineexam to this version, you will have to switch from LTI to SOAP, review all plugin settings and test the plugin thoroughly.
