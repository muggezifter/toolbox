### Installation ###

Clone the repository, then run ```composer install```    
This will install the dependencies and configure autoload.    
If you don't need phpunit and phpdoc run ```composer install --no-dev```  

### Usage ###

``` php toolbox csv:table [--options] <filename.csv>``` print the contents of *filename.csv* to the console as a table.    
options:   
``` --headers ``` first row has column headers  
``` --separator=[separator] ``` use this separator (use *p* or *pipe* for "|")  
``` --vvv``` show debug information
  
  
  
``` php toolbox csv:json [--options] <filename.csv>``` print the contents of *filename.csv* to the console as JSON.  
options:      
``` --separator=[separator] ``` use this separator (use *p* or *pipe* for "|")  
``` --vvv``` show debug information

### Testing ###

```vendor/bin/phpunit tests```  
  
### Generating Docs ###
  
```vendor/bin/phpdoc -d ./src -t ./docs/```  