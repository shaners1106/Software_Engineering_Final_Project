# Shane Snediker, Ethan Wolcott, Trevor Troxel, Pragalva Dhungana and Pukar Mahat
# CS 472 Software Engineering
# Hewitt Research Foundation database rehaul project
# File last updated: 5-22-2021

# This file contains the Python script for exporting test order shipping information
# to a CSV file.  The following is the breakdown of the attributes that will be extracted
# from the database VIEW called "print_ship_labels":
# 
#   [0] : customer1_first_name
#   [1] : customer1_last_name
#   [2] : address1
#   [3] : city1
#   [4] : state1
#   [5] : zipcode1
#   [6] : plus4_1
#   [7] : ship_first_name1
#   [8] : ship_last_name1
#   [9] : ship_company
#   [10] : ship_address
#   [11] : ship_city
#   [12] : ship_state
#   [13] : ship_zipcode
#   [14] : ship_plus4
#   [15] : email1
#   [16] : phone1
#   [17] : account_id
#   [18] : student_id
#   [19] : test_id

# And the following is a list of the column headers of the CSV file that we will output:

# SHIPPING FIRST NAME    SHIPPING LAST NAME    SHIPPING ADDRESS     CITY    STATE     ZIPCODE     SHIPPING PLUS 4     SHIPPING COMPANY      EMAIL     PHONE     ACCOUNT ID     STUDENT ID      TEST ID

# NOTE: the last 3 columns will not be used in shipping labels, they are extracted to help
#       this script uniquely identify tuples so that the outstanding_order attribute of each
#       one can be modified from a 1 to 2 signifying that the labels have been printed and 
#       tests sent.  Account_id, student_id and test_id help us track these tuples.

# Therefore the flow of this script is:

#       1. Connect to database and extract the print_ship_labels VIEW
#       2. For each tuple, determine if there is a unique shipping address
#       3. Generate tuples containing the data corresponding to the CSV column headers listed above
#       4. Instantiate and export a CSV file containing this information
#       5. Provoke Hewitt to confirm that they successfully printed all labels
#       6. Update the outstanding_order attribute for each of these label tuples to a value of 2

import sys   # Needed for configuring the database connection
import pyodbc # Connect to MS SQL
#import mysql.connector    # Connect to the MySQL database
from configparser import ConfigParser # Separate configuration settings into separate file
import csv   # Process csv files

# Throw this script into a function so that the desktop app can utilize it
def export_shipping_csv():

    ########### FORMAT THE FILE NAME AND THE PATH WHERE WE WILL EXPORT THE CSV ##################

    # TEMP FILE PATH SO WE COULD TEST ON OUR OWN MACHINE
    ###Hewitt_csv_export_path = 'C:\\Users\\Snediker\\Documents\\Whitworth\\Last call\\Software Engineering\\ready_shipper.csv'

    # Format the file path here and save in a variable
    
    # Precise file path to Hewitt's Ready Shipper directory: "U:\System\ReadyShipper original\CSV\LabelsImport.csv"
    Hewitt_csv_export_path = "U:\System\ReadyShipper original\CSV\LabelsImport.csv"
    ###############################################################################################

    #################### MAKE A DATABASE CONNECTION ##########################################
    
    config = ConfigParser()
    # This will determine if its the .exe or just the script
    if 'dist' in sys.path[0]: config.read('config.ini')
    else: config.read(sys.path[0] + '\\config.ini')
    # Transforms the config infor into a dictionary for the program to use
    config_dict = dict(config.items())

    # Connects to the database
    hewitt_db = pyodbc.connect(
    host = config_dict['general']['host'],
    database = config_dict['general']['database'],
    user = config_dict['general']['user'],
    password = config_dict['general']['pass'],
    port = config_dict['general']['port'],
    driver = config_dict['general']['driver'],
    Trusted_connection = config_dict['general']['Trusted_connection']
    )
    ##########################################################################################
    
    ####### CAPTURE ALL OF THE STUDENT INFO FOR THE TESTS THAT NEED TO BE PRINTED ############

    # The cursor function is returns a control structure that enables the 
    # execution of queries against the DB
    my_cursor = hewitt_db.cursor()
    # Pull in all current tests that still need to be printed
    # NOTE: the print_tests VIEW from the Hewitt DB always contains tests that need 
    #       to be printed, so selecting everything from this VIEW is what we want
    my_cursor.execute('SELECT * FROM print_ship_labels;')
    # Save the tuple information in a variable that we can iterate over.  The fetchall()
    # function returns a tuple of tuples (the internal tuples consisting of individual
    # test order attributes)
    current_ship_labels = my_cursor.fetchall()

    # How many shipping labels will we be printing today?
    num_labels = len(current_ship_labels)
    # How many columns does each label tuple have?
    num_attributes = len(current_ship_labels[0])
    
    ########### CONVERT NULL VALUES TO EMPTY STRINGS ###################################

    # Python hates null values (or what they term 'None types')
    # We begin interacting with the data by converting all nulls to empty strings, which
    # is something that Python can deal with
    # We need to use an array in order to rebuild the tuple
    no_null_attributes = []
    # For each individual tuple:
    for ind_tup in range(num_labels):
        # check it for nulls and if found, convert to '':
        # However modifying an existing tuple is not permitted in Python, so we'll have to
        # do some extra work to create new tuples.  This is necessary because if this script
        # ever assigns an attribute that has a null value, it will crash the script
        # Track the attributes within this tuple that hold null values
        null_indices =[]
        for attribute in range(num_attributes):
            # Does this index hold a null value?
            if current_ship_labels[ind_tup][attribute] is None:
                # Then save this index number
                null_indices.append(attribute)
        # Instantiate an inner array to hold this tuple's attributes
        inner_tuple = []
        # For each index, if it is an index number that held a null value, append an empty
        # string into the new array, otherwise append the original value
        for index in range(num_attributes):
            if index in null_indices:
                inner_tuple.append("")
            else:
                inner_tuple.append(current_ship_labels[ind_tup][index])
        # Finally, add this inner array as a newly created null-less tuple into the new outer array    
        no_null_attributes.append(inner_tuple)
        
        # Now we have a Python array corresponding to the data tuple with null values replaced by empty strings
    ###############################################################################################
    # Instantiate an array to hold each row of the the csv file
    shipping_csv_row_holder = []
    
############ BEGIN LOOP TO PRINT LABELS ####################################################
    # Each loop processes 1 shipping label tuple and places all of it's required data within a tuple
    for label in range(num_labels):
        
        ######### DETERMINE IF THIS SHIPPING LABEL HAS A UNIQUE SHIPPING ADDRESS ###########

        # If the ship_first_name1 attribute is not null, then we need to use the shipping names
        use_ship_name = False
        if no_null_attributes[label][6] != "":
            use_ship_name = True
        
        # If the ship_address attribute is not null, then we need to use the shipping info
        use_ship_info = False
        if no_null_attributes[label][8] != "":
            use_ship_info = True
        ####################################################################################

        ######## DETERMINE IF THE STATE ATTRIBUTE IS NULL (FOR OLD PARADOX TUPLES) #########

        city = ""
        state = ""
        # If it's a newer order (one entered into the system after May of 2021) it will
        # have separate city and state attributes.  However, every tuple entered into the
        # Paradox system has a combined city_state attribute.  We need to separate those
        # files for Ready Shipper
        # If the state attribute isn't null, then we already know the city and state for this label:
        if no_null_attributes[label][4] != "":
            city = no_null_attributes[label][3]
            state = no_null_attributes[label][4]
        # However, for all the old orders, parse out the state from the city into separate columns
        else:
            city_state_holder = no_null_attributes[label][3].split(' ')
            # The state will always be the last index of this new array
            state = city_state_holder[len(city_state_holder) - 1]
            # Now build the city by combining each of the earlier indices up to but not including the last index
            for index in range(len(city_state_holder) - 1):
                # Remember to leave a space in between words of a city
                city += ' ' + city_state_holder[index]
            
        ####################################################################################

        ######## COMBINE ZIPCODE AND PLUS 4 FOR THOSE TUPLES THAT HAVE A PLUS 4 ###########

        # Check whether or not we're using separate shipping info and then determine if this
        # tuple has a plus 4 that needs to be added to the zipcode
        # Does this tuple have a separate shipping address?
        if(use_ship_info):
            zipcode = str(no_null_attributes[label][13])
            if(no_null_attributes[label][14] != ""):
                zipcode += "-" + str(no_null_attributes[label][14])
        # There isn't separate shipping address for this tuple, use standard
        else:
            zipcode = str(no_null_attributes[label][5])
            if(no_null_attributes[label][6] != ""):
                zipcode += "-" + str(no_null_attributes[label][6])
       ###################################################################################

        ################ BUILD CSV TUPLES ##################################################

        # Now that we've determined whether or not this label has a unique address, we can
        # load the pertinent data into a tuple that will later be exported to a CSV file
        # If this label has a unique address
        if (use_ship_info):

            # Is there also a separate shipping name associated with this order?
            if(use_ship_name):
                #               ship_first_name               ship_last_name                  ship_address       ship_city ship_state ship_zipcode      ship_company                    email                           phone                         account_id                      student_id                      test_id
                csv_tuple =(no_null_attributes[label][7], no_null_attributes[label][8], no_null_attributes[label][10], city, state, zipcode, no_null_attributes[label][9], no_null_attributes[label][15], no_null_attributes[label][16], no_null_attributes[label][17], no_null_attributes[label][18], no_null_attributes[label][19])
            # There isn't a separate shipping name, so use customer1 first and last name
            else:
                # This version is the same as the one above, except it uses the standard mailing_list customer name because the shipping name is null
                #                ship_first_name                ship_last_name                ship_address        ship_city ship_state ship_zipcode      ship_company                   email                        phone                            account_id                      student_id                      test_id
                csv_tuple = (no_null_attributes[label][0], no_null_attributes[label][1], no_null_attributes[label][10], city, state, zipcode, no_null_attributes[label][9], no_null_attributes[label][15], no_null_attributes[label][16], no_null_attributes[label][17], no_null_attributes[label][18], no_null_attributes[label][19])
        # There is not unique shipping information, so use the standard address from the mailing list
        else:
            # Use standard mailing info since there is no unique shipping address
            #                     ship_first_name           ship_last_name                  ship_address    ship_city ship_state ship_zipcode      ship_company                    email                             phone                    account_id                      student_id                  test_id
            csv_tuple = (no_null_attributes[label][0], no_null_attributes[label][1], no_null_attributes[label][2], city, state, zipcode, no_null_attributes[label][9], no_null_attributes[label][15], no_null_attributes[label][16], no_null_attributes[label][17], no_null_attributes[label][18], no_null_attributes[label][19])
        
        # Add this tuple to the array
        shipping_csv_row_holder.append(csv_tuple)

    # The following code creates a CSV file with 1 header row of column headers followed directly
    # by a row for each shipping label that needs to be printed
    
    with open(Hewitt_csv_export_path, 'w', newline='') as out:
        # Create a csv file writer object that we can use to create our CSV file
        file_writer = csv.writer(out)
        # Use the file writer object to generate the header row of the CSV file
        file_writer.writerow(['SHIPPING FIRST NAME', 'SHIPPING LAST NAME', 'SHIPPING ADDRESS', 'CITY', 'STATE', 'ZIPCODE', 'SHIPPING COMPANY', 'EMAIL', 'PHONE', 'ACCOUNT ID', 'STUDENT ID', 'TEST ID'])
        # Iterate through each shipping label, writing the corresponding attributes into each column
        for row in shipping_csv_row_holder:
            file_writer.writerow(row)
    ################################################################################################

    ##### UPDATE OUTSTANDING_ORDER COLUMN OF TEST_ORDER TABLE FOR THESE SHIPPING LABELS ##########
        
    # Now that Hewitt has confirmed that they've printed all of the labels that they
    # need, we can update the outstanding_order value for each of these tuples from
    # a 1 to a 0.  NOTE: within the test_order table an outstanding_order value of 0 
    # corresponds to all tests that haven't been printed, a value of 1 corresponds to
    # all test_orders that have been printed but not shipped yet, a value of 2 corresponds
    # to all test_orders that have been shipped but not yet returned, a value of 3
    # corresponds to all test_orders that have been returned, and a value of 4 means that
    # the customer/student didin't return the test_order in time (there's a 90 day deadline).
    #  
    # First we create a Python array to hold the data we will need to make sure we only
    # change the outstanding_order attribute for the tests that we just printed
    # Our SQL test to make sure that we're only updating the specific test tuples of
    # the test orders that we just printed consists of querying the test_order table
    # and updating the outstanding_order attribute to 2 for all tuples with matching
    # account_id's, student_id's and test_id's as the ones from this test order print job
    update_data = []
    for iter in range(num_labels):
        # account_id - index 17, student_id - index 18, and test_id - index 19
        update_data.append((no_null_attributes[iter][17], no_null_attributes[iter][18], no_null_attributes[iter][19]))

    # Now we build the UPDATE query that we will use to update the outstanding_order attributes
    # NOTE: Here we use string formatting syntax (?).  The ?s's get populated with the
    #       corresponding tuple data provided in the executemany function call.  So, for
    #       example we've created an array of 3 value tuples (account_id, student_id, test_id)
    #       When we call the execute many function it will go through each tuple in the array
    #       and populate the WHERE clause parameters with the corresponding attribute data  
    # NOTE: The "my_cursor.execute('SELECT * FROM Hewitt_DB.print_labels;')" function call
    #       from early in this script accessed the VIEW 'print_labels'.  Database views are
    #       kind of like virtual copies of data and cannot be directly modified.  Therefore,
    #       when we are updating database tuples, we have to access the actual tables where the
    #       original data resides
    
    # Define the SQL query that will update the date_printed attribute for these tests to today
    update_query = """UPDATE test_order 
                      SET outstanding_order = 2 
                      WHERE account_id = ? AND student_id = ? AND test_id = ?;"""
    # The executemany function will execute multiple UPDATE commands within 1 function call
    my_cursor.executemany(update_query, update_data)
    # Spent a couple hours trying to figure out why I could update rows in the test_order
    # database in MySQL Workbench but not from this Python file and it turns out you 
    # HAVE TO COMMIT YOUR DATABASE UPDATES!!
    hewitt_db.commit()
    ###########################################################################################

    ######### SEND DESKTOP APPLICATION CONFIRMATION OF DATA UPDATE ############################

    # Send confirmation of data update
    print("The test_order outstanding_order attribute has now been updated to a 2")

    #################################################################################################

# THIS FUNCTION CALL ONLY HERE FOR TESTING PURPOSES
#export_shipping_csv()

