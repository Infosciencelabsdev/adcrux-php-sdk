Adcrux PHP SDK
================

This repository contains the PHP SDK for Adcrux to manage lists, subscribers, campaigns, templates and more.

The documentation website at https://api-docs.adcrux.io/ showcases all the API endpoints.  
You can find them in the examples folder as well.  

### Install
Install Dependencies:  
```bash
$ composer install
```
Then follow the instructions from `examples/setup.php` file.

## Test  
Following environment variables have to be set, with their proper values:  
`ADCRUX_API_URL`  
`ADCRUX_API_PUBLIC_KEY`  
`ADCRUX_API_PRIVATE_KEY` 
 
Then you can run the tests:
```bash
$ composer test
``` 

