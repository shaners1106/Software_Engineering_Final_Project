from datetime import date
from plotnine import (  # Pull in everything from the plotnine library
    geom_text, ggplot, themes)
from plotnine.geoms import geom_point
from plotnine.mapping import aes
from plotnine.themes.elements import element_blank  # Import functionality for accessing today's date


def python_plotline():
    print("test")
    # Shane Snediker, Ethan Wolcott, Trevor Troxel, Pragalva Dhungana and Pukar Mahat
    # CS 472 Software Engineering
    # Hewitt Research Foundation database rehaul project
    # File last updated: 5-10-2021

    # After failing to create a print template with the Python Docx library
    # we moved on to use another Python library that provides enhanced flexibility
    # with organizing text and objects on a page.  This library is called plotnine.
    # plotnine is a Python application whose functionality is closely intertwined with
    # the R programming language.  R is a coding language used for statistical computing
    # and graphical data analysis.  It uses flexible data structures that provide
    # robust graphical functionality so that statisticians and data analysts can present
    # database information in unique ways.  plotnine utilizes R's use of ggplots to present
    # information on a page.  ggplots are open source data visualization tools, such 
    # as graphs and charts.  There are myriad choices of how to create ggplots and the
    # various ggplot objects that can be added to them.  plotnine allows the user to write
    # the code in Python while simultaneously accessing many of the benefits of the R programming
    # package.

    # Here, we've decided to use the plotnine ggplot package to generate a template that 
    # Hewitt will be able to print onto their scantron tests.  Our code here instantiates
    # a ggplot object and adds the various student information, grade dot and "office use
    # only" account squares.  We've very carefully, through trial and error, calculated the
    # locations of where to print all of the information on the template.  The plotnine
    # package employs a coordinate system that we manipulated to place ggplot objects in 
    # the appropriate places within the template.  The coordinate system uses as a reference
    # point the lower left corner of the page as (0,0).  The horizontal axis is the x axis and
    # the vertical axis is the y axis.  Moving right on the page signifies increasing in the 
    # x direction while moving up on the page signifies increasing in the y direction

    # The code ends with a save function call that sends a pdf copy of the template to the
    # path provided in the function argument.  Our vision is for the script that we create
    # to pull all pertinent student test information from the database, save it in a data
    # structure and then run this plotnine code in a loop that will generate a ggplot per
    # student and then save the plots on separate pages within 1 pdf file. This file can 
    # then be printed to scantrons from Hewitt's Ricoh printer.

    # NOTE: we built this program using Python's Jupyter Notebook application. Jupyter
    # Notebook is an interactive browser application that facilitates the combination of
    # coding, comments and graphical representations of data structure elements.  This 
    # allowed us to see the progress of our ggplot objects in real time as we were 
    # constructing them.  

    # Let's access today's date so that every time Hewitt runs this print script to generate printing
    # templates, the pdf that is rendered can be saved with the corresponding date on which it is generated
    # The date.today() function call captures today's date in YYYY-MM-DD format while the call to strftime
    # alters the format and saves it in a string.  The following is an example of the format that we have
    # decided to set up to be saved in the filename of each pdf print template : 05-10-2021
    today = date.today().strftime("%m-%d-%Y")

    # We begin by defining some const values that correspond to cartesian coordinates
    # that we will use to place ggplot objects at appropriate places on the print template

    ################### STUDENT INFO CONSTANT COORDINATE VALUES ################################
    # Constant vertical alignment coordinates for both the student info headers as 
    # well as the individual tuple info (both sets of info align vertically)
    GROUP_ID_V = 100
    STUDENT_ID_V = 97
    STUDENT_V = 94
    GRADE_V = 91
    DATE_PRINTED_V = 88
    PARENTS_V = 85

    # Constant horizontal alignment coordinates for individual tuple info
    GROUP_ID_H = 15
    STUDENT_ID_H = 13
    STUDENT_H = 19
    GRADE_H = 13
    DATE_PRINTED_H = 17.5
    PARENTS_H = 20.5

    ################# GRADE DOT CONST COORDINATE VALUES ##############################
    # Constant vertical alignment coordinates for grade level dots
    GRADE3 = 69.85 
    GRADE4 = 68
    GRADE5 = 66.25
    GRADE6 = 64.50
    GRADE7 = 62.70
    GRADE8 = 60.75
    # Constant horizontal alignment coordinate value (all grade dots are vertically aligned
    # within 1 horizontal column)
    GRADE_COLUMN = 22
    #########################################################################################

    ################ OFFICE USE ONLY CONSTANT COORDINATE VALUES #############################
    # Constant "office use only" plot configuration coordinates
    # The vertical (y) row coordinate values
    ROW0_V = 18.8
    ROW1_V = 17.1
    ROW2_V = 15.2
    ROW3_V = 13.5
    ROW4_V = 11.9
    ROW5_V = 10
    ROW6_V = 8.2
    ROW7_V = 6.4
    ROW8_V = 4.8
    ROW9_V = 3
    ROW10_V = 1.1
    ROW11_V = -.6
    ROW12_V = -2.4
    ROW13_V = -4.5
    # The horizontal (x) column coordinate values
    COLUMN0_H = .1
    COLUMN1_H = 2.8
    COLUMN2_H = 4.9
    COLUMN3_H = 7.4
    COLUMN4_H = 9.5
    COLUMN5_H = 12.2
    COLUMN6_H = 14.7
    COLUMN7_H = 17.3
    COLUMN8_H = 19.5
    COLUMN9_H = 22
    ##############################################################################

    ############### TEXT OBJECT VARIABLE DEFINITIONS #############################
    # Top Corner Student info header variables
    group_id_header = "Group ID:"
    student_id_header = "Student ID:"
    student_header = "Student:"
    grade_header = "Grade:"
    date_header = "Date Printed:"
    parents_header = "Parents:"

    # Top Corner Student info variables
    group_id = 12345
    student_id = "03"
    student_name = "Landon Johnson"   
    grade = 8
    date_printed = today
    parents = "James Richardson \n N. 151 Hewitt Ln. \n Madison, WI 99222"

    # Not Transferrable variable
    not_transferrable = "Not Transferrable to Any Other Parent or Student"
    ###############################################################################

    # Amount of tests to print for this print job
    num_tests = 1

    # Create a Python array to hold the test ggplots
    test_holder = []

    # Create a variable that can act as the label to vertically align grade dots
    this_student_grade = GRADE8

    # Iterate through each student test, creating a ggplot template for that student, and append
    # each ggplot into a Python array of ggplots
    for next_test in range(num_tests):

        # Instantiate the ggplot object and give it horizontal and vertical parameters
        # aes is a ggplots aesthetic function and is a very common attribute of ggplot objects
        scantron_template_plot = ggplot() + aes(xmin = 0, xmax = 100, ymin = 0, ymax = 100) 
        
        # Set the ggplot to be 10 X 13.6 inches long and hide all of the textual elements 
        # that typically get printed to the axes of the graphs (axis texts, tick marks and the legend)
        scantron_template_plot = scantron_template_plot + themes(figure_size=(10, 13.6), axis_text_x = element_blank(), axis_text_y = element_blank(), axis_ticks = element_blank(), legend_position = "none") 
        
        # We begin the construction of the print template by starting in the upper left hand corner and filling out
        # the personalized student information.  For the text elements of the print template, we use ggplot objects
        # called geom_text objects.  For each geom_text element, we pass in an x and y coordinate giving the element
        # a specified position, the label (which is the specific text to be displayed), the size, and any additional 
        # parameters needed, such as fontweight.
        
        # Add the 6 bold student info headers to the upper left hand corner of the template.  They will look like this:
        #   GROUP ID:
        #   STUDENT ID:
        #   STUDENT:
        #   GRADE:
        #   DATE PRINTED:
        #   PARENTS:
        scantron_template_plot = scantron_template_plot + geom_text(x = 0, y = GROUP_ID_V, label=group_id_header, 
        fontweight="bold", size = 8) + geom_text(x = 0, y = STUDENT_ID_V, label=student_id_header,               
        fontweight="bold", size = 8, nudge_x = -2) + geom_text(x = 0, y = STUDENT_V, label=student_header,     
        fontweight="bold", size = 8) + geom_text(x = 0, y = GRADE_V, label=grade_header,                     
        fontweight="bold", size = 8) + geom_text(x = 0, y = DATE_PRINTED_V, label=date_header, fontweight="bold",   
        size = 8) + geom_text(x = 0, y = PARENTS_V, label=parents_header, fontweight="bold",                   
        size = 8) 
        
        # Now we add the specific tuple data to correspond with the student headers.  Therefore, the vertical
        # coordinates of these text elements will match those of the corresponding header (i.e. this student's
        # group id will be printed at the identical vertical coordinate as the group id header so that they line up)
        scantron_template_plot = scantron_template_plot + geom_text(x = GROUP_ID_H, y = GROUP_ID_V, label=group_id,
        size=8) + geom_text(x = STUDENT_ID_H, y = STUDENT_ID_V, label=student_id, size=8) + geom_text(x = STUDENT_H, y = STUDENT_V, 
        label=student_name, size=8) + geom_text(x = GRADE_H, y = GRADE_V, label=grade, size=8) + geom_text(x = DATE_PRINTED_H, 
        y = DATE_PRINTED_V, label=date_printed, size=8) + geom_text(x = PARENTS_H, y = (PARENTS_V - 1), label=parents, size = 8)   
        
        # Add the not-transferrable text label to the template
        scantron_template_plot = scantron_template_plot + geom_text(x = 22, y = 76, label = not_transferrable, fontweight="bold", size = 8) 
        
        
        # We are ready to move on to the grade dot and "office use only" portion of the print template.  For the
        # grade dot and "office use only" boxes, we will use a ggplot object called geom_point.  There are a variety
        # of geom_point objects.
        
        # For the grade dot, we've decided to use the default shape (a black dot) and adjust its size.  Using
        # the default means not having to specify a shape in the function call.  We specify the size of the 
        # grade dot and provide it x and y coordinates.  Because the grade dots are organized in 1 vertically
        # aligned column, the horizontal positioning of the grade dots will be identical.  For this reason we
        # have chosen to hard code the x value into the function argument and use a variable for the y coordinate
        # because the horizontal placement of the grade dot will depend on the grade of the student.
        scantron_template_plot = scantron_template_plot + geom_point(x = GRADE_COLUMN, y = this_student_grade, size = 3.5) 
        
        # Now we are ready for the "office use only" section.  This is the trickiest section because the little
        # rectangles that we need to print to are so close in proximity to each other.  The geom_point shape that
        # we've chosen to use for this section is a black square.  Because it isn't the default shape of geom_point
        # objects, we have to specify this shape as an argument in the function call.  A geom_point square is specified
        # as shape "s." We instantiate 14 squares because that's how many rectangles need to be filled in the
        # "office use only" section of the scantron sheet
        scantron_template_plot = scantron_template_plot + geom_point(x = COLUMN0_H, y = ROW0_V, shape = "s",
        size = 3) + geom_point(x = COLUMN0_H, y = ROW1_V, shape = "s", size = 3) + geom_point(x = COLUMN0_H, y = ROW2_V, shape = "s",
        size = 3) + geom_point(x = COLUMN0_H, y = ROW3_V, shape = "s", size = 3) + geom_point(x = COLUMN0_H, y = ROW4_V, shape = "s", 
        size = 3) + geom_point(x = COLUMN1_H, y = ROW5_V, shape = "s", size = 3) + geom_point(x = COLUMN2_H, y = ROW6_V, shape = "s", 
        size = 3) + geom_point(x = COLUMN3_H, y = ROW7_V, shape = "s", size = 3) + geom_point(x = COLUMN4_H, y = ROW8_V, shape = "s", 
        size = 3) + geom_point(x = COLUMN5_H, y = ROW9_V, shape = "s", size = 3) + geom_point(x = COLUMN6_H, y = ROW10_V, shape = "s", 
        size = 3) + geom_point(x = COLUMN7_H, y = ROW11_V, shape = "s", size = 3) + geom_point(x = COLUMN8_H, y = ROW12_V, 
        shape = "s", size = 3) + geom_point(x = COLUMN9_H, y = ROW13_V, shape = "s", size = 3)   
        
        test_holder.append(scantron_template_plot)
        
        
    #test_holder

    # Build a variable to hold the full string containing the name of this pdf file
    name_file = "print-tests-" + today + ".pdf"
    # The following command saves each student test ggplot template onto its own page within 1 pdf file
    # args: test_holder = list of ggplots (student test templates), filename = string specifying what the
    #       program will name this pdf file, path = the specified path is where the pdf file will be saved, 
    #       transparent = "true" hides the default grid background so that only the ggplot objects that 
    #       we want to print to the scantrons will be displayed, dpi = dots per inch; dpi tells the 
    #       printer with what precision to print this job
    ggplot.save_as_pdf_pages(test_holder, filename = name_file, path=r"C:\\Users\\Snediker\\Desktop\\plotnine", transparent="true", dpi=600)

    # The following command saves an individual ggplot in the path provided while setting the background
    # so that only the ggplot objects that we assign will get printed onto the pdf output.
    # We've deprecated this function call from use because Hewitt regularly prints multiple tests
    # in 1 job and the above save function provides them the functionality of saving multiple ggplots
    # on separate pages within 1 pdf file.  We're leaving this code commented out here for future reference purposes.
    # NOTE: dpi is dots per inch and provides the printer with a guideline for what resolution to print this ggplot
    #test_holder.save(path=r"C:\Users\Snediker\Desktop\plotnine", transparent="true", dpi=600)
