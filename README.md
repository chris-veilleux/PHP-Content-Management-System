# Content Management System in PHP
This project was created as an Assignment for COMP1006 - Intro to Web Programming.
It is a content management system for a ficticious gym, "GreatLife Fitness", using PHP and Bootstrap 5.

[Click here to view the live site.](https://lamp.computerstudi.es/~Christopher1167804/comp1006/phpcms/index.php)

## Public Site
The public side of the site, accessible to any visitors who are not logged in, displays the list of pages in the header dynamically:
The pages available to anonymous users are stored as records in a MySQL database, and when the header file loads, it queries the database to dynamically update the navbar.
When an anonymous user navigates to a page, the application queries the database again to retrieve the content of the requested page.
## Administrator Site
Anonymous visitors have the ability to register or login as an administrator.
Upon registration, inputs are all validated, checking for a username and password, password strength, unique username, and matching passwords,
before hashing the password and adding the user to the table of administrators in the database.
On login, inputs are again validated, and the application verifies that the credentials exist in the database.

Once logged in, administrators have the ability to edit or delete existing administrators,
as well as create new pages, update the title or content of existing pages, and delete pages.
