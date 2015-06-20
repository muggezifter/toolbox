### Branch: Alternative ###
This is the "functional" version, where I avoid storing state as much as possible.

### Installation ###

Clone the repository, then run composer update.  
This will install the dependencies and configure autoload.

### Usage ###

``` php toolbox csv:table filename.csv [--options] ``` print the contents of *filename.csv* to the console as a table.    

options:   
``` --headers ``` first row has column headers  
``` --separator=[separator] ``` use this separator (use *p* or *pipe* for "|")

``` php toolbox csv:json filename.csv [--options] ``` print the contents of *filename.csv* to the console as JSON.

options:      
``` --separator=[separator] ``` use this separator (use *p* or *pipe*: for |)  
