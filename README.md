# TOOLBOX #

A first attempt at writing a console utility in PHP using the Symfony2 Console component. 

### Installation ###

Clone the repository, then run composer update. 
This will install the dependencies and configure autoload.

### Usage ###

php toolbox csv:show filename.csv [--options]: Print the contents of filename.csv to the console in tabular from

options:

* --headers: first row has column headers

* --separator=[separator]: use this separator (use *p* or *pipe* for |)

* --debug: show debug information


