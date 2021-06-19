# Shane Snediker, Ethan Wolcott, Trevor Troxel, Pragalva Dhungana and Pukar Mahat
# CS 472 Software Engineering
# Hewitt Research Foundation database rehaul project
# File last updated: 5-22-2021

# This file contains the Python script used to import the CSV files exported from
# WooCommerce when a customer orders tests

# The flow of this script is as follows:

#       1. Configure database connection
#       2. Extract CSV file contents and organize contents into a 2 dimensional array (an array of tuples)
#       3. Define the SQL query necessary to INSERT these new test_orders into the database
#       4. Send confirmation message to Hewitt's screen upon completion

import sys   # Needed for configuring the database connection
import pyodbc   # Access the MS SQL database
#import mysql.connector   # Connect to the MySQL database
from configparser import ConfigParser # Separate configuration settings into separate file
import csv   # Process csv files
from datetime import date, datetime, timedelta # Import functionality for accessing today's date

# Throw this script into a function so that the desktop app can call it
def add_online_orders():

    ############ BEGIN BY CONNECTING THIS SCRIPT TO HEWITT'S DATABASE ##########################

    config = ConfigParser()
    # This will determine if its the .exe or just the script
    if 'dist' in sys.path[0]: config.read('config.ini')
    else: config.read(sys.path[0] + '\\config.ini')
    # Transforms the config infor into a dictionary for the program to use
    config_dict = dict(config.items())

    # Connects to the database
    hewitt_db = pyodbc.connect(
    server = config_dict['general']['host'],
    database = config_dict['general']['database'],
    user = config_dict['general']['user'],
    password = config_dict['general']['pass'],
    port = config_dict['general']['port'],
    driver = config_dict['general']['driver'],
    Trusted_connection = config_dict['general']['Trusted_connection']
    )
    ##########################################################################################

    ########## CONFIGURE THE FILEPATH WHERE THE WOOCOMMERCE CSV FILE IS LOCATED ##############

    # The following is the official filepath provided by Hewitt that maps to the location 
    # on Hewitt's system where the WooCommerce CSV file will always be located:
    #   U:\Work\Testing\WooCommerce\WooCommerce_Order.csv

    # # temporary open statement to so that we could test functionality on our local machine
    # temp_woo = 'C:\\Users\\Snediker\\Documents\\Whitworth\\Last call\\Software Engineering\\woo_commerce.csv'
    # woo_order = open(temp_woo, 'rt')
    # read_this_file = csv.reader(woo_order)

    # Open CSV

    # Save the path in a variable
    woocommerce_csv_path = 'U:\Work\Testing\WooCommerce\WooCommerce_Order.csv'
    
    # Now that we know where the file is, let's open it!
    woocommerce_order = open(woocommerce_csv_path, 'rt')
    
    # Now that it's open, we can read and extract it's contents
    read_this_file = csv.reader(woocommerce_order)

    # Now that we're in, the power of extraction can take place.  We construct a 2-dimensional
    # array.  It will be an array holding each row of the csv file.  Each row is a individual
    # student test order and the data needs to be loaded into Hewitt's database
    test_order_holder = []
    for row in read_this_file:
        test_order_holder.append(row)
    ############################################################################################

    ########## CONVERT CSV DATA INTO DB FORMAT #################################################

    # Our one constant value is the amount of columns in this file.  It will ALWAYS contain
    # 7 columns
    NUM_COLUMNS = 7

    # The following is a breakdown of the columns provided in Hewitt's CSV WooCommerce files:

    #   Group ID    ID      Student First Name      Student Last Name       Grade       Date        Date Ordered        Group Qty
    # 
    #   -GROUP ID will be the 6 digit account_id of the group leader plus a dash followed
    #       by the quantity of exams in that group order.  Example: 123456-1
    #   -ID consists of the 6 digit parent/guardian account_id and the 2 digit student_id
    #       in the following format: 165165-2
    #   -Student First Name is self explanatory
    #   -Student Last Name is self explanatory
    #   -Grade of the student taking the exam (this value will be the dot that gets marked on their scantron)
    #   -Date : this field requires an important distinction.  This date field represents the 
    #           date that the customer is requesting test materials/curriculum.  If this field 
    #           is left blank, we have been instructed to assign this test order a print_on_date of
    #           the current date.  If this field is not blank, that means the customer is requesting
    #           a delayed shipping date.  Therefore, we have been instructed to assign these test orders
    #           a print_on_date of 18 days before the date provided in this field.
    #   -Date ordered is provided so that Hewitt can maintain an accurate record of when the test was ordered
    #   -Group qty is the amount of test orders for group orders.  This field will be blank for 
    #         orders that are not affiliated with a group

    # Therefore, each internal array will hold 7 indices and the index breakdown is as follows:

    #       [0] : Group ID
    #       [1] : ID
    #       [2] : Student First Name
    #       [3] : Student Last Name
    #       [4] : Grade
    #       [5] : Date
    #       [6] : Date ordered
    

    # NOTE: the first internal array can be ignored because it contains the row of column
    #       headers.  When we begin building database tuples, we need to skip over index 0.
    # 
    # We will need to use today's date in this process
    today = date.today().strftime("%Y-%m-%d") 

    # Our strategy here is to conduct the entirety of this data organization process within
    # 1 for loop.  In this way, with each iteration of the loop, we can access and distribute
    # the necessary attributes into a tuple that can later be uploaded into the test_results
    # table of the database
    # 
    # How many rows does the CSV file have?
    num_tuples = len(test_order_holder)

    # Declare an array to hold the resultant tuples that will then get imported into the DB
    tuple_holder = []

    ########### GET RID OF NULL VALUES ######################################################

    # Python hates null values (or what they term 'None types')
    # We begin interacting with the data by converting all nulls to empty strings, which
    # is something that Python can deal with
    # We need to use an array in order to rebuild the tuple
    no_null_attributes = []
    # For each individual tuple:
    for ind_tup in range(1, num_tuples):
        # check it for nulls and if found, convert to '':
        # However modifying an existing tuple is not permitted in Python, so we'll have to
        # do some extra work to create new tuples.  This is necessary because if this script
        # ever assigns an attribute that has a null value, it will crash the script
        # Track the attributes within this tuple that hold null values
        null_indices =[]
        for attribute in range(NUM_COLUMNS):
            # Does this index hold a null value?
            if test_order_holder[ind_tup][attribute] is None:
                # Then save this index number
                null_indices.append(attribute)
        # Instantiate an inner array to hold this tuple's attributes
        inner_tuple = []
        # For each index, if it is an index number that held a null value, append an empty
        # string into the new array, otherwise append the original value
        for index in range(NUM_COLUMNS):
            if index in null_indices:
                inner_tuple.append("")
            else:
                inner_tuple.append(test_order_holder[ind_tup][index])
        # Finally, add this inner array as a newly created null-less tuple into the new outer array    
        no_null_attributes.append(inner_tuple)
        
        # Now we have a Python array corresponding to the data tuple with null values replaced by empty strings
    
    ########### BEGIN THE LOOP THAT WILL COMPRISE THE DATA PARSING OF THE TUPLES ###############
    
    # Start the loop that will process each row of the CSV file and save the result into a tuple
    for row in range(num_tuples - 1): # Skip the 0th row because it's the column headers
        
        # Declare an array to hold this row's parsed and organized attributes
        this_tuple_data = []

        # It's important at this point to acknowledge the specific order that the attribute
        # holder array is going to hold the attributes in, because we will be loading these
        # attributes into very specific columns within the database

        #   index 0 :   group_id
        #   index 1 :   group_qty
        #   index 2 :   account_id
        #   index 3 :   student_id
        #   index 4 :   student_first_name
        #   index 5 :   student_last_name
        #   index 6 :   grade
        #   index 7 :   print_on_date
        #   index 8 :   date_ordered
        
        # Declare a couple Booleans that will help us process
        is_grouped = False  # Is student part of a group?
        delay_ship = False  # Is this order a delayed print order?

        # Let's begin by setting our flags

        # Is this student a part of a group?
        if no_null_attributes[row][0] != "":
            is_grouped = True
        # Does this test need to have a delayed shipping date?
        if no_null_attributes[row][5] != "":
            delay_ship = True

        # Now we can separate the first 2 indices into the 4 attributes that they hold 
        # (group_id, group_qty, account_id, and student_id)

        # If this student is a part of a group
        if is_grouped:
            group_separator = no_null_attributes[row][0].split('-')
            # Add the group id
            this_tuple_data.append(int(group_separator[0]))
            # Add the group test quantity
            this_tuple_data.append((group_separator[1]))
        # Not apart of a group, but let's still fill those indices with empty strings
        else:
            # Fill the group id column with a NULL value
            this_tuple_data.append("")
            # Fill the group quantity column with a NULL value
            this_tuple_data.append("")
        # account_id and student_id held in index 1
        student_separator = no_null_attributes[row][1].split('-')
        # Add the account_id
        this_tuple_data.append(student_separator[0])
        # Add the student_id
        this_tuple_data.append(student_separator[1])

        # Now that we've parsed those first 2 indices, the rest will be a cake walk

        # Add the student first name (index 2)
        this_tuple_data.append(no_null_attributes[row][2])
        # Add the student last name (index 3)
        this_tuple_data.append(no_null_attributes[row][3])
        # Add the student grade (index 4)
        this_tuple_data.append(no_null_attributes[row][4])

        # Let's set a print date

        # Set the format that will be compatible with SQL Date objects
        format = "%Y-%m-%d"
        # If it's a delayed ship, we do some math
        if delay_ship:
            # Let's convert the date within this CSV column to an actual date object
            date_object = datetime.strptime(no_null_attributes[row][5], format).date()
            # Per Hewitt's request, we subtract 18 days from the delayed ship date to
            # calculate the print_on_date
            print_on_date = date_object - timedelta(days=18)
            
        # It's not a delay ship, give it an immediate print_on_date 
        else:
            print_on_date = today
            print_on_date = datetime.strptime(print_on_date, format).date()
        # Load the print_on_date into the array
        this_tuple_data.append(print_on_date)

        # Convert the CSV column date ordered to a date object compatible with SQL
        date_ordered = datetime.strptime(no_null_attributes[row][6], format).date()
        # Add date ordered to the array
        this_tuple_data.append(date_ordered)

        # Lastly, we need to make sure that these test_orders get pre-loaded with the 
        # oustanding_order flag being set to 0!
        outstanding_flag = 0
        this_tuple_data.append(outstanding_flag)

        # We should now have each of our tuples built within an array
        ############################################################################################

        ########## CONVERT ARRAYS INTO TUPLES ######################################################
        #   index 0 :   group_id
        #   index 1 :   group_qty
        #   index 2 :   account_id
        #   index 3 :   student_id
        #   index 4 :   student_first_name
        #   index 5 :   student_last_name
        #   index 6 :   grade
        #   index 7 :   print_on_date
        #   index 8 :   date_ordered
        #   index 9 :   outstanding_order
        # The SQL syntax needed to import data into the database requires tuples:
        # We load this tuple putting the attributes in the same order as they show up in the DB:
        #                          0: account_id,       1: student_id,          2: print_on_date,  3:outstanding_order, 4: group_id,         5: group_qty,      6:date_ordered,      7: grade,        8: student_first_name 9: student_last_name
        tuple_holder.append((int(this_tuple_data[2]), int(this_tuple_data[3]), this_tuple_data[7], this_tuple_data[9], this_tuple_data[0], this_tuple_data[1], this_tuple_data[8], this_tuple_data[6], this_tuple_data[4], this_tuple_data[5]))

        # We now have an array holding all of the tuples of data that need to be entered into the DB
    #################################################################################################

    # Now we build the UPDATE query that we will use to update the outstanding_order attributes
    # NOTE: Here we use string formatting syntax (%s).  The %s's get populated with the
    #       corresponding tuple data provided in the executemany function call.  So, for
    #       example we've created an array of 3 value tuples (account_id, student_id, test_id)
    #       When we call the execute many function it will go through each tuple in the array
    #       and populate the WHERE clause parameters with the corresponding attribute data  
    # NOTE: The "my_cursor.execute('SELECT * FROM Hewitt_DB.print_labels;')" function call
    #       from early in this script accessed the VIEW 'print_labels'.  Database views are
    #       kind of like virtual copies of data and cannot be directly modified.  Therefore,
    #       when we are updating database tuples, we have to access the actual tables where the
    #       original data resides

    my_cursor = hewitt_db.cursor()   #buffered=True)
   
   #############################################################################################

   # THE FOLLOWING PATCH OF CODE WAS HERE BECAUSE I WAS RUNNING INTO AN ERROR IN WRITING THIS
   # SCRIPT BECAUSE THE CSV FILE THAT KRISTIN PROVIDED FOR ME HAD BRAND NEW DATA THAT WASN'T 
   # IN THE SNAPSHOT THAT WE WERE WORKING WITH AND SO WE WERE GETTING AN ERROR.  THAT SHOULDN'T
   # BE A PROBLEM FOR YOU GUYS SINCE YOU'LL BE WORKING WITH CURRENT, UPDATED DATA, BUT I'LL LEAVE
   # THIS WORK AROUND COMMENTED OUT HERE FOR REFERENCE PURPOSES

    # # We have to make sure that this student already exists in the database, otherwise SQL will cry
    # for student in range(len(tuple_holder)):
    #     check_exist = "SELECT * FROM student WHERE account_id =" + str(tuple_holder[student][0]) + " AND student_id =" + str(tuple_holder[student][1]) + ";" 
    #     my_cursor.execute(check_exist)
    #     this_student = my_cursor.fetchone()
    #     if this_student is None:
    #         params = (tuple_holder[student][0], tuple_holder[student][1], tuple_holder[student][8], tuple_holder[student][9], tuple_holder[student][7])
    #         new_student = "INSERT INTO Hewitt_DB.student (account_id, student_id, student_first_name, student_last_name, grade) VALUES (%s, %s, %s, %s, %s);"
    #         my_cursor.execute(new_student, params)


    # Define the SQL query that will update the date_printed attribute for these tests to today
    update_query = """INSERT INTO test_order (account_id, student_id, print_on_date, outstanding_order, group_id, group_qty, date_ordered, grade, student_first_name, student_last_name)
                      VALUES(?,?,?,?,?,?,?,?,?,?);"""
    # The executemany function will execute multiple UPDATE commands within 1 function call
    my_cursor.executemany(update_query, tuple_holder)
    # Spent a couple hours trying to figure out why I could update rows in the test_order
    # database in MySQL Workbench but not from this Python file and it turns out you 
    # HAVE TO COMMIT YOUR DATABASE UPDATES!!
    hewitt_db.commit()
    
    ###########################################################################################

# THIS FUNCTION CALL ONLY HERE SO WE COULD TEST FUNCTIONALITY OF THIS FILE ON IT'S OWN
# WITHIN THE CONTEXT OF THE WHOLE APP, THE PRIMARY DESKTOP FILE WILL CALL THIS FUNCTION
#add_online_orders()
