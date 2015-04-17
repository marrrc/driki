Driki is a module that was specifically created to import Wiki articles based on their XML version into nodes
(although it is possible to import just any XML).
This module provides a custom field widget that enables you to define an internal/external path
to your XML of the Wiki entry. Along with the URL Driki asks for a text format the results should be filtered with.
Ideally you will already have any standard or contributed filter that understands a certain Wiki syntax.
Driki will store the body of your XML, and do the filtering during output.


Install
-----------
For more information, see INSTALL.txt.


Notes
-----------
Driki is an early public beta release.
- Currently the body object of your XML has to be called "text"
(otherwise a small adjustment in _driki_field_process() would be necessary).
A settings page where you can define the parts of the XML that should be imported is in the works.
- At the moment only 1 field instance of the same field per node is supported.