# Whitworth CS472 Software Engineering Final Project

This repository contains all of the documentation for the my capstone software engineering course project at Whitworth University.  The project entailed helping a local Spokane nonprofit organization, Hewitt Research Foundation, transition their database from an outdated system to MySQL, update their website, as well as re-writing many scripts that Hewitt uses to conduct their day to day business operations.  

[Here is a link to Hewitt Research Foundation's website](https://hewittlearning.org/)

## Authors

This project was a group project for Dr. Pete Tucker's CS472 course.  The following individuals were on my team as we collaborated to complete this project:

* Trevor Troxel : ttroxel21@my.whitworth.edu
* Ethan Wolcott : ewolcott12@my.whitworth.edu
* Pragalva Dhungana : pdhungana21@my.whitworth.edu

## The Client

The Hewitt Research Foundation is a Spokane nonprofit organization that provides homeschooling educational materials, curriculum and testing for homeschooled students all over America and even internationally as well.  In an age of social and economic uncertainty, the demand for homeschooling materials is increasing as many new families transition their children's education away from the public sector.  Hewitt has been operating their business for many years on the Microsoft DOS database management system from the 1980's called Paradox.  Paradox is an antiquated system with very little remaining documentation and insufficients means for interfacing with it.  The only way that Hewitt was able to access their Paradox database was through a virtual machine running Microsoft Windows XP because that is the newest Windows operating system that still supports Paradox.  As such, Hewitt had a unique and distinct need for an upgrade to their DBMS.  

Unfortunately, integrated within the Paradox system were many scripts that allowed Hewitt to operate their business.  The scripts that were in place provided printing and file processing functionality.  The first script within the Paradox system was a CSV import script.  Hewitt ran this script when they had received online student test orders.  Their online customer relations manager WooCommerce would export a CSV file containing pertinent order information and this CSV import script would parse the CSV file and import the test order information into the Paradox database.  The second important script was a printing script.  After they had imported new test order information into the system, they would run the print script and it would check the database for any outstanding test order and pull specific student information and print the information onto extremely precise locations on scantron test forms using a default Ricoh office printer.  Then the script would change the default printer to a little Zebra label printer and print little labels with family or group information that would allow Hewitt to organize the tests into separate shipping packages.  The third script was a shipping CSV export script.  This script pulled all relevant shipping information of the outstanding test orders from the Paradox database and exported the information to a CSV file.  Hewitt could then open a software application called Ready Shipper that would open the CSV file and use the information to print USPS shipping labels that Hewitt could then place on the packages and proceed to send out in the mail.  The final important script was another CSV import script.  This script takes in a .txt file containing a string of characters corresponding to test results from graded student exams and parses the characters and imports the results into the Paradox database.  

Our team took their Paradox database and converted the data into an MS SQL database.  We then normalized the database using modern conventions.  This included adding auto incrementing primary keys, implementing foreign keys, changing table and attribute names and combining tables with one to one relationships together.  Hewitt's Paradox database consisted of 51 tables, no foreign keys and no auto incrementing primary keys.  We were able to condense the database down to 6 tables.  We then reproduced Hewitt's core script functionality.  Using Python, 3 of the 4 scripts mentioned above were integrated into a desktop application that Hewitt would be able to download onto their business machines so that they could conduct their day to day business operations.  The fourth script was incorporated into a PHP web application that we built for Hewitt.  We built a web application that Hewitt can use to access and modify their database information.  This allows Hewitt to interface with their database in a much more fluid, efficient manner. 

Our team worked in close connection with 3 primary points of contact from the Hewitt organization.  The following individuals comprise the team that we will be interfacing with throughout this project:

* Jack Lewis : jlewis@hewittlearning.org
* Kristin Lewis : kristinl@hewittlearning.org
* Jared Nelson : jaredn@hewitthomeschooling.com

## More information regarding the specific tasks involved in this project

   ### Task 1: Transition Hewitt from Paradox DB to MySQL

   PROBLEM STATEMENT
   
   Currently we use Paradox not only as a CRM, but also as the only way we print Scantrons for ourstudents, as well as the primary interface for our database. There are multiple tables that we access through Paradox, and multiple scripts with functions that need to be recreated once the database has transitioned. This DOS program is a simple relational database, is extremely unstable, and has multiple limitations. It is missing many modern elements such as foreign keys. There is also no guarantee that the existing tables are properly normalized. In the new system, we would need to account for the multiple types of queries (test scores, shipping information, customer history, registration status, etc.), We also need to account for how our database is updated and how it interfaces with SQL. In addition, there needs to be a way to print student information onto Scantron bubbles.

   Included in this task is enhancing Hewitt's current website and connecting the new MySQL database to the existing website.

  

## Explanation of directories

   * **_DB_enhance_** - this directory includes all code and documentation involved in the process of migrating Hewitt from Paradox Database Management System to MS SQL Server Database Management System as well as the desktop application that we built for Hewitt which integrates new versions of Hewitt scripts used for printing student exams and shipping labels as well as importing new test order information.
   * **_Website_enhance_** - this directory includes the code and documentation involved in the updates and editing that we performed on Hewitt's website as well as the code for the new PHP web interface that we built for Hewitt to allow them to interact with their database more freely without having to run a Windows XP virtual machine.