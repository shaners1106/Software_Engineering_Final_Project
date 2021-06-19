import csv  # Process csv files
import os
import sys  # Needed for configuring the database connection
from configparser import ConfigParser  # Separate configuration settings into separate file
from datetime import date  # Import functionality for accessing today's date
from distutils.core import setup
from tkinter import Button, Label, PhotoImage, Tk
import mysql.connector  # Connect to the database
import win32con  # Access logical pixel calculations
import win32print  # Printer functions
import win32ui  # Library for creating print documents
import py2exe

############################################################################################################################
# these are functions that are called from different files
from print_labels import print_labels
from print_tests import print_tests
from export_shipping_csv import export_shipping_csv
from add_online_orders import add_online_orders

Mydata_files = []
for files in os.listdir(sys.path[0]):
    f1 = sys.path[0] + "\\" + files
    if os.path.isfile(f1): # skip directories
        if f1.endswith('.ini'):
            f2 = '', [f1]
            if f2 not in Mydata_files:
                Mydata_files.append(f2)
    elif os.path.isdir(f1): # checking within folders for certain images
        if 'dist' not in f1:
            for files in os.listdir(f1):
                if files.endswith(".png"):
                    f2 = '', [f1+ "\\"+ files]
                    if f2 not in Mydata_files:
                        Mydata_files.append(f2)

setup(
    console=["Desktopapp.py"],
    data_files=Mydata_files
    )
