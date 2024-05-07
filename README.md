# NXD BluePrint Example Module for Joomla 5.x
This is a simple example module for Joomla 5.x. It shows Joomla! Content. This module can be used as Blueprint.

## Features
- New Joomla! Module Structure Example Code
- Example Code for WebAssets
- Example Code for Language Files
- Use Composer to setup the module

## Configuration / Usage
### Setup using Composer
1. Clone the repository
2. Run `composer setup` to rename the module and set up the module
3. Install the module via Joomla! Extension Manager


### Setup using manual Method via Search and Replace
#### Module Information
1. Search & Replace all occurrences of `mod_blueprint` with your module name
2. Search & Replace all occurrences of `BluePrint` with your module title (used for namespacing & naming in Language files)
3. Search & Replace all occurrences of `blueprint` with your module name in lowercase
4. Search & Replace all occurrences of `BLUEPRINT` with your module name in uppercase
#### Creator Information
5. Search & Replace all occurrences of `[CREATOR-COMPANY]` with your Company's Name
6. Search & Replace all occurrences of `[CREATOR-URL]` with your Company's URL
7. Search & Replace all occurrences of `[CREATOR-FULLNAME]` with your Name
8. Search & Replace all occurrences of `[CREATOR-EMAIL]` with your Email
9. Search & Replace all occurrences of `[CREATED-DATE]` with the current date 
10. Search & Replace all occurrences of `[CREATED-YEAR]` with your Copyright 
11. Search & Replace all occurrences of `[EXTENSION-VERSION]` with the current version

#### Namespacing & File Renaming
12. Search & Replace all occurrences of `NXD` with your Company's ID (used for namespacing)
13. Rename mod_blueprint.xml to your module name (e.g. mod_example.xml)
14. Rename the Language File language/en-GB/en-GB.mod_blueprint.ini to your module name (e.g. en-GB.mod_example.ini)
15. Rename the Language File language/en-GB/en-GB.mod_blueprint.sys.ini to your module name (e.g. en-GB.mod_example.sys.ini)
16. Rename the Helper File src/Helper/BluePrintHelper.php to your module name (e.g. src/Helper/ExampleHelper.php)
17. Rename the Media Folder media/mod_blueprint to your module name (e.g. media/mod_example)

## Build your Module
After the setup has been done you are good to go and can modifiy the module to your needs.
Go ahead and do your thing!

## Deployment
### Deployment via Composer
>not yet available

### Manual Deployment
- Delete composer.json, composer.lock, the vendor and .git folder as they are not needed for the module
- Zip the module and install it via Joomla! Extension Manager
