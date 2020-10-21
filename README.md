# salesfloor robotscript test

## Installation
-  Requirement installation environment: PHP 7, composer
-  do ```composer install ```
- to run the application, do ``` php robots.php input1.txt``` and wait for print result

- To run unit testing, do ``` php tests.php 10 ``` feel free to pass any number as parameter, its the number of
 commands generated for a random number of blocks between 2 and 25
## Spec:
- `onto` -> immediate above or just ontop of
- `over` -> anywhere above 
### Commands:
 - move a onto b
 - move a over b
 - pile a onto b
 - pile a over b
  
### Example
#### Input
  - 10
  - move 9 onto 1
  - move 8 over 1
  - move 7 over 1
  - move 6 over 1
  - pile 8 over 6
  - pile 8 over 5
  - move 2 over 1
  - move 4 over 9
  - quit
  
#### Output
   ```
    1 : 1 9 2 4 
    2 : 
    3 : 3
    4 : 
    5 : 5 8 7 6
    6 : 
    7 :
    8 :
    9 :  
   10 :
   ```
