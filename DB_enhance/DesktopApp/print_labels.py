# Shane Snediker, Ethan Wolcott, Trevor Troxel, Pragalva Dhungana and Pukar Mahat
# CS 472 Software Engineering
# Hewitt Research Foundation database rehaul project
# File last updated: 5-22-2021
# This file contains the Python script for Hewitt's small label printing. 

# The following links were very helpful in the construction of this script:
# win32print library documentation
# http://timgolden.me.uk/pywin32-docs/win32print.html
# update default printer:
# https://codereview.stackexchange.com/questions/193488/changing-the-default-printer-in-windows
# Python and printers:
# https://www.blog.pythonlibrary.org/2010/02/14/python-windows-and-printers/

# The flow of this script is as follows:

#       1. Configure database connection
#       2. Extract all testing information for the tuples in the database who's outstanding_order
#          attribute from the test_order table is a 0 (signifying that they need a new test)
#       3. Use Python's Windows library win32ui to instantiate a print document 
#       4. Use a loop to configure each individual student test with specific scantron info
#       5. Provoke Hewitt's Ricoh to print the scantrons
#       6. Solicit confirmation that the tests printed accurately
#       7. Update the date_printed attribute in the test_order table for these tuples


# Names of Hewitt's printers:
#   Ricoh scantron printer: 'Ricoh Aficio MP C6000 PCL5c'
#   Zebra little label printer: '\\\\192.168.1.14\\ZDesigner LP 2844-Z'
#   Zebra shipping label printer: '\\\\192.168.1.14\\ZDesigner LP 2844'


# We have to build each of the 4 primary Hewitt scripts (printing onto scantrons,
# printing onto little labels, WooCommerce CSV import and CSV export) as functions
# so that we can call the functions within the desktop application


import sys               # Needed for configuring the database connection
import pyodbc            # Connect to MS SQL database
#import mysql.connector  # Connect to MySQL database
from configparser import ConfigParser # Separate configuration settings into separate file
import win32print        # Printer functions
import win32ui           # Library for creating print documents
import win32con          # Access logical pixel calculations

# This function is comprised of the full label printing script
def print_labels():
        ########### SAVE NAMES OF HEWITT PRINTERS IN VARIABLES ###############################

        # Save the names of the printers 
        Ricoh_printer = 'Ricoh Aficio MP C6000 PCL5c'
        Zebra_labeler = '\\\\192.168.1.14\\ZDesigner LP 2844-Z'

        ######################################################################################
        
        ############### CHANGE TO ZEBRA LABEL PRINTER #################################

        default_printer = win32print.GetDefaultPrinter()
        if default_printer != Zebra_labeler:
            win32print.SetDefaultPrinter(Zebra_labeler)
        ###############################################################################
        
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

        ######### CAPTURE ALL OF THE STUDENT INFO FOR THE LABELS THAT NEED TO BE PRINTED ##########

        # The cursor function is returns a control structure that enables the 
        # execution of queries against the DB
        my_cursor = hewitt_db.cursor()
        # Pull in all current tests that still need to be printed
        # NOTE: the print_tests VIEW from the Hewitt DB always contains tests that need 
        #       to be printed, so selecting everything from this VIEW is what we want
        my_cursor.execute('SELECT * FROM print_labels;')
        # Save the tuple information in a variable that we can iterate over.  The fetchall()
        # function returns a tuple of tuples (the internal tuples consisting of individual
        # test order attributes)
        current_labels = my_cursor.fetchall()

        # How many labels will we be printing on this job?
        num_labels = len(current_labels)
        # And how many attributes does each label tuple hold?
        num_attributes = len(current_labels[0])

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
                if current_labels[ind_tup][attribute] is None:
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
                    inner_tuple.append(current_labels[ind_tup][index])
            # Finally, add this inner array as a newly created null-less tuple into the new outer array    
            no_null_attributes.append(inner_tuple)
            
            # Now we have a Python array corresponding to the data tuple with null values replaced by empty strings
        ###############################################################################################

        #   NOTE: The win32ui TextOut function by which we send textual elements to the page only
        #   accepts string values within the function call.  Therefore, even the attributes
        #   that are ints must be stored as string values

        # Now that we know how many labels to print, let's review the tuple info. The indices
        # of each tuple are as follows:
        #   [0] : group_id      NOTE: this attribute is only needed for helping make sure the labels
        #                             get printed in an intuitive order; it won't be printed to the labels
        #   [1] : account_id    NOTE: this is an int data type and will need to be converted to a string in order to print to the win32ui document
        #   [2] : student_id   NOTE: this is only here because we use it in the query at the end of
        #                             this script that changes the outstanding_order value to a 1 value
        #   [3] : test_id      NOTE: Same as student_id (only here for updating DB data)
        #   [4] : customer1_first_name
        #   [5] : customer1_last_name
        #   [6] : address1
        #   [7] : city1
        #   [8] : state1 
        #   [9] : zipcode1
        #   [10] : ship_first_name1
        #   [11] : ship_last_name1
        #   [12] : ship_address
        #   [13] : ship_city
        #   [14] : ship_state
        #   [15] : ship_zipcode
                
        ###########################################################################################

        # The following is a win32print function that allows you to access a list of 
        # the printers on your system.  I've commented it out because it won't be 
        # necessary to include in the final version of this script, but I did use it
        # to identify the official name of the Hewitt printers.  This function call
        # returns a tuple of tuples, where the individual tuples represent a specific
        # printer on the system running the call. The documentation on win32print is
        # very sparse, so I'm still not exactly sure what the integer argument specifies,
        # however, I do know that it represents a level of detail desired in the function
        # return.  The tuples returned from this function have 4 values (in this order):
        # flag, description, name, comment.  I found that level 2 provided the most
        # comprehensive information.  I've left this code here for reference purposes. The
        # little documentation I found was found at the following url:
        # http://timgolden.me.uk/pywin32-docs/win32print.html
        #     printers = win32print.EnumPrinters(2)
        #     print(printers)

        ########### DEFINE FUNCTIONS ##########################################################

        # This function uses a mathematical calculation to convert the desired standard
        # font size to the scale of the way that win32ui prints to the page.
        # args: dc : the win32ui object that the font will be used on
        #       PointSize : the desired standard font size
        # We found this function at the following URL:
        # https://stackoverflow.com/questions/48549555/how-to-set-font-type-and-size-for-printing-using-windows-gdi
        def getfontsize(dc, PointSize):
            inch_y = dc.GetDeviceCaps(win32con.LOGPIXELSY)
            return int(-(PointSize * inch_y) / 72)
        ###############################################################################
        
        ############ BEGIN LOOP TO PRINT LABELS #######################################
        for label in range(num_labels):

            ######### DETERMINE IF THIS TUPLE HAS A UNIQUE SHIPPING NAME AND ADDRESS ###########

            # If the ship_first_name1 attribute is not null, then we need to use the shipping names
            use_ship_name = False
            if no_null_attributes[label][10] != "":
                use_ship_name = True
            
            # If the ship_address attribute is not null, then we need to use the shipping info
            use_ship_info = False
            if no_null_attributes[label][12] != "":
                use_ship_info = True
            ####################################################################################

            ########### VARIABLE DECLARATIONS ####################################################

            # NOTE: the win32ui TextOut function can only send string data types to the page
            # This tuple's account_id is held in index 1 of the data structure holding label info
            account_id = str(no_null_attributes[label][1])
            # Build this label's parent name line
            # NOTE: if there's a unique shipping name, we'll use that
            if use_ship_name:
                parent_name = no_null_attributes[label][10] + ' ' + no_null_attributes[label][11]
            # If there isn't a specified shipping name, we use customer/guardian 1's name
            else:
                parent_name = no_null_attributes[label][4] + ' ' + no_null_attributes[label][5]
            # Build this labels address info
            # NOTE: if there's a unique shipping address, we'll use that
            if use_ship_info:
                street_address = no_null_attributes[label][12]
                city_state = no_null_attributes[label][13] + ' ' + no_null_attributes[label][14] + ', ' + no_null_attributes[label][15]
            # If there isn't a specified shipping address, we use customer/guardian's
            else:
                street_address = no_null_attributes[label][6]
                city_state = no_null_attributes[label][7] + ' ' + no_null_attributes[label][8] + ', ' + no_null_attributes[label][9]
            #######################################################################################
            
            ################ BEGIN PRINT DOCUMENT HERE ####################################
            # Instantiate a win32ui object that we can use to generate printable objects
            dc = win32ui.CreateDC()
            # Connect the win32ui object to the printer
            dc.CreatePrinterDC()
            # Begin a new document and initialize the page
            dc.StartDoc('Print Labels Document')
            dc.StartPage()

            # Now we define the necessary fonts that will be used within the template

            ################ DEFINE FONTS #################################################

            # Make the text size 11
            fontsize = getfontsize(dc, 12)
            # Create a bold font for the student info headers (left column of the student info section) as well as the non-transferrable statement
            fontdata_headers = { 'name':'Arial', 'height':fontsize, 'italic':False, 'weight':win32con.FW_BOLD}
            # Create a win32ui bold font object and save it in a variable that we can utilize throughout this document
            bold_font = win32ui.CreateFont(fontdata_headers)
            # Give this document the font characteristics that we just defined
            dc.SelectObject(bold_font)

            ############### PLACE TEXT ELEMENTS WITHIN DOCUMENT ###########################

            # Per Hewitt's request, we left align the little label content (keep it at 0 in the x direction)
            # Place account id in the upper left corner of the label
            dc.TextOut(0, 20, account_id)
            # Leave a space in between account id and the rest of the information
            # Next piece of information is the parent name
            dc.TextOut(0, 120, parent_name)
            # Place the street address
            dc.TextOut(0, 170, street_address)
            # Finally place the city, state and zipcode
            dc.TextOut(0, 220, city_state)

            ############### PRINT LABELS ##################################################
            
            dc.EndPage()

            ############### END DOCUMENT ##################################################

            dc.EndDoc()
            ###############################################################################

        ########## CONFIRM THAT THE PRINT JOB WAS ACCURATE AND COMPLETE ###################

        need_reprints = False
        # Python's user input function returns a string, so we need to make sure to use a string
        last_account_id_printed = '0'

        print("Did the print job finish fully and accurately?")
        print(" 1.    YES\n \
2.    NO, there was a printer error.  We've adjusted the printer and are ready to re-run the script\n \
3.    NO, we ran out of paper during the print job")
        temp = input("Enter one of the numbers: ")
        if temp == '2':
            print_labels()
        if temp == '3':
            temp2 = input("Enter the account ID of the last label to print: ")
            need_reprints = True
            last_account_id_printed = temp2 
         
        ############### PROVIDE HEWITT OPPORTUNITY TO REPRINT LABELS ############################

        if(need_reprints):

            ############ FIND RESTART INDEX ###############################################
            # Start a loop to find which tuple Hewitt's print job ended on (they will have just entered
            # the account_id into the desktop application)
            restart_index = 0
            for iter in range(num_labels):
                # Cast the account_id value retrieved from the database (int) to a string
                # so that this comparison will be of the same data type
                if(str(no_null_attributes[iter][1]) == last_account_id_printed):
                    # We don't need to reprint the label corresponding to this account_id,
                    # so go to the next one
                    restart_index = iter + 1
                    # Break out of the for loop
                    break
            ###############################################################################

            ############ BEGIN LOOP TO REPRINT LABELS #######################################
            
            # Start the printing again, however, begin 1 index past the last label that printed
            for label in range(restart_index, num_labels):
                
                ######### DETERMINE IF THIS TUPLE HAS A UNIQUE SHIPPING NAME AND ADDRESS ###########

                # If the ship_first_name1 attribute is not null, then we need to use the shipping names
                use_ship_name = False
                if no_null_attributes[restart_index][10] != "":
                    use_ship_name = True
                
                # If the ship_address attribute is not null, then we need to use the shipping info
                use_ship_info = False
                if no_null_attributes[restart_index][12] != "":
                    use_ship_info = True
                ####################################################################################

                ########### VARIABLE DECLARATIONS ####################################################

                # This tuple's account_id is held in index 1 of the data structure holding label info
                account_id = str(no_null_attributes[restart_index][1])
                # Build this label's parent name line
                # NOTE: if there's a unique shipping name, we'll use that
                if use_ship_name:
                    parent_name = no_null_attributes[restart_index][10] + ' ' + no_null_attributes[restart_index][11]
                # If there isn't a specified shipping name, we use customer/guardian 1's name
                else:
                    parent_name = no_null_attributes[restart_index][4] + ' ' + no_null_attributes[restart_index][5]
                # Build this labels address info
                # NOTE: if there's a unique shipping address, we'll use that
                if use_ship_info:
                    street_address = no_null_attributes[restart_index][12]
                    city_state = no_null_attributes[restart_index][13] + ' ' + no_null_attributes[restart_index][14] + ', ' + no_null_attributes[restart_index][15]
                # If there isn't a specified shipping address, we use customer/guardian's
                else:
                    street_address = current_labels[restart_index][6]
                    city_state = no_null_attributes[restart_index][7] + ' ' + no_null_attributes[restart_index][8] + ', ' + no_null_attributes[restart_index][9]
                #######################################################################################

                ################ BEGIN PRINT DOCUMENT HERE ####################################
                # Instantiate a win32ui object that we can use to generate printable objects
                dc = win32ui.CreateDC()
                # Connect the win32ui object to the printer
                dc.CreatePrinterDC()
                # Begin a new document and initialize the page
                dc.StartDoc('Print Labels Document')
                dc.StartPage()

                # Now we define the necessary fonts that will be used within the template

                ################ DEFINE FONTS #################################################

                # Make the text size 11
                fontsize = getfontsize(dc, 12)
                # Create a bold font for the student info headers (left column of the student info section) as well as the non-transferrable statement
                fontdata_headers = { 'name':'Arial', 'height':fontsize, 'italic':False, 'weight':win32con.FW_BOLD}
                # Create a win32ui bold font object and save it in a variable that we can utilize throughout this document
                bold_font = win32ui.CreateFont(fontdata_headers)
                # Give this document the font characteristics that we just defined
                dc.SelectObject(bold_font)

                ############### PLACE TEXT ELEMENTS WITHIN DOCUMENT ###########################

                # Place account id in the upper left corner of the label
                dc.TextOut(0, 20, account_id)
                # Next piece of information is the parent name
                dc.TextOut(0, 100, parent_name)
                # Place the street address
                dc.TextOut(0, 150, street_address)
                # Finally place the city, state and zipcode
                dc.TextOut(0, 200, city_state)

                ############### PRINT LABELS ##################################################
                
                dc.EndPage()

                ############### END DOCUMENT ##################################################

                dc.EndDoc()
        #########################################################################################
        
        ############### GIVE DEFAULT PRINTER CONTROL BACK TO RICOH ##############################

        win32print.SetDefaultPrinter(Ricoh_printer)
        #########################################################################################

        #### UPDATE OUTSTANDING_ORDER COLUMN OF TEST_ORDER TABLE FOR THESE TEST ORDERS ##########
        
        # Now that Hewitt has confirmed that they've printed all of the labels that they
        # need, we can update the outstanding_order value for each of these tuples from
        # a 0 to 1.  NOTE: within the test_order table an outstanding_order value of 0 
        # corresponds to all tests that haven't been printed, a value of 1 corresponds to
        # all test_orders that have been printed and shipped but not yet returned. 
        # First we create a Python array to hold the data we will need to make sure we only
        # change the outstanding_order attribute for the tests that we just printed
        # Our SQL test to make sure that we're only updating the specific test tuples of
        # the test orders that we just printed consists of querying the test_order table
        # and updating the outstanding_order attribute to 1 for all tuples with matching
        # account_id's, student_id's and test_id's as the ones from this test order print job
        update_data =[]
        for iter in range(num_labels):
            update_data.append((no_null_attributes[iter][1], no_null_attributes[iter][2], no_null_attributes[iter][3]))

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
        update_query = """UPDATE test_order 
                   SET outstanding_order = 1 
                   WHERE account_id = ? AND student_id = ? AND test_id = ?;"""
        # The executemany function will execute multiple UPDATE commands within 1 function call
        my_cursor.executemany(update_query, update_data)
        # Spent a couple hours trying to figure out why I could update rows in the test_order
        # database in MySQL Workbench but not from this Python file and it turns out you 
        # HAVE TO COMMIT YOUR DATABASE UPDATES!!
        hewitt_db.commit()
        ###########################################################################################

        ######### SEND DESKTOP APPLICATION CONFIRMATION OF DATA UPDATE ############################

        print("Printing is complete and the test_order outstanding_order attribute has been changed to a 1")

        ###########################################################################################

# if __name__ == '__main__':
#print_labels()