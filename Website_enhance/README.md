Hewitt Website Ammendments
==================================

## Overview
* Allow the website to communicate with the WordPress database and a separate Client/Test database simultaneously.
* Whenever a new client registers through the website, that information will be automatically stored in the Client/Test database and eliminate the need for excessive manual database entry
* Implement search capabilities for employees and clients to recall commonly required information from either database.

## Phase 1: Complete
* Created a staging environment by copying the website and the WP database. Assign them to a subdomain.
* Cleared any small formatting issues that are immediately noticeable, such as the Lorem Ipsum on the Single Product page. This info was not accessible through Elementor, but was only visible in the HTML code buried within the SingleProduct.PHP under the Woostify theme's contents directory.
* Gained Network Admin access to change the themes.
* Developed a Child Theme for Woostify and loaded the content. This will allow us to manipulate the functions.php file to create custom queries and interact with the database without losing the base content of Woostify or losing any functionality with future Woostify updates.
* Activated the child in both the parent site and the WhitDev site, so now there is a fully-functional and live copy of the original site that we may make aesthetic changes to as well as a file that we may add custom php scripts to without interrupting core functionality.
* This activation created a conflict with the site's header, and the logo image was lost. The header was manually reset and tested.
* Global variables were set for the Client/Test database so that a second instance of WPDB could be created and communicated with.
* Custom PHP code was created in the child theme's functions.php file to allow data from an Elementor form to be posted to a table in the Client/Test database(currently hosted in AWS). This was tested and confirmed.
#### All of this means...
* An environment has been created wherein features can be written, implemented, and tested without interrupting the live site that customers will use.
* Data from the website can now be sent to and retrieved from a custom database, hosted separate from the website, allowing for custom queries, increased automation for the client, and increased accessibility for client and customers.  

## Phase 2: Generate new web application
* Developed an environment where Hewitt could access account and modify database information with ease.
* Created a feature where Hewitt can choose a student and download his/her test results to a pdf file.
* Created a script that takes in a text file and parses the information into the corresponding student's tuple within the test_results table within the database.