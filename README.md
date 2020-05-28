# Taskboard

## Wampserver Setup
Install Wampserver as described here: https://blog.templatetoaster.com/how-to-install-wamp/

## Starting the server
![image](https://user-images.githubusercontent.com/7762113/80248242-36189680-8678-11ea-9097-b559f53c5596.png)

## Project deployment on Wampserver
The project cannot be run directly in the browser because it is a PHP project and PHP files need to be compiled on the server-side. This means that the project has to be deployed (copied) on Wampserver.

In order to deploy the project on Wampserver you need to do the following:
- Copy the root application folder (taskboard) with all the associated files under www folder of Wampserver.
- www folder can be found in the wamp64 installation folder
    - C:\wamp64\www\taskboard
- The Wampserver can be restared, but its not always neccessary.
- Open a web browser and go to http://localhost/taskboard. This will run the project, compile PHP and open the front-end side of it in the browser.

## Connecting to MySQL database
The project will automatically connect to Wampserver MySQL server, if it is running. This is done by calling function initializeDatabase() from db_connection.php, which is called from index.php. So the initializeDatabase() function will be called automatically when the main page is loaded.

initializeDatabase() will check each time the page is loaded if a database with name 'taskboard' exists in MySQL server. If it does not exist it will initialize it and it will create all the necessary tables, which at first will be of course empy.
If the database already exists, it will not be created again or overwritten.

Daca se fac modificari in functia initializeDatabase(), atunci baza de date 'taskboard' trebuie stearsa folosind interfata web phpMyAdmin din Wampserver. La prima accesare a site-ului baza de date se va crea din nou cu toate tabelele aferente, iar modificarile se vor putea urmari in phpMyAdmin.
