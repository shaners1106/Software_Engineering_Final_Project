import sys
from tkinter import (Button, Label, Tk, PhotoImage)
from print_labels import print_labels
from print_tests import print_tests
from export_shipping_csv import export_shipping_csv
from add_online_orders import add_online_orders

def DeskTopMenu():
    # this is for seeing if the window is being called here or being called from another file
    # I do this so that I can manage the image back ground
    DeskTopWindow = Tk()
    
    if 'dist' in sys.path[0]: Pic = 'nograd.png'
    else: Pic = sys.path[0] + '\\img\\nograd.png'
    
    DeskTopWindow.title('Desktop Window')
    # variables to help center the window
    w, h = 700, 700
    ws, hs = DeskTopWindow.winfo_screenwidth(), DeskTopWindow.winfo_screenheight()
    x, y = (ws/2) - (w/2), (hs/2) - (h/2)
    DeskTopWindow.geometry('%dx%d+%d+%d' % (w, h, x, y))
    DeskTopWindow['background']='#532F64'    #Change the bg color if the window is resized. I'm guessing we'll revisit this.
        
    Photo = PhotoImage(file = Pic)
    Label(DeskTopWindow, image = Photo).place(x = 0, y = 0)    # Place the background photo

    Label(DeskTopWindow,text='Welcome to your printing and data import/export center!',font = ('helvetica', 15, 'bold'), border=0, background= "#3d3c3e").place(x = 110, y = 55)
    Button(DeskTopWindow,text='Add WooCommerce Test Orders',command=add_online_orders)
    Button(DeskTopWindow,text='Print Tests', command= print_tests)
    Button(DeskTopWindow,text='Print Order Labels',command= print_labels)
    Button(DeskTopWindow,text='Export Shipping Label CSV', command=export_shipping_csv)

    i=70
    for c in DeskTopWindow.children:
        if 'button' in c:
            DeskTopWindow.children[c]['font'] = ('helvetica', 15, 'bold')
            DeskTopWindow.children[c]['foreground'] = '#EAEAEA'
            DeskTopWindow.children[c]['activebackground'] = '#532F64'
            DeskTopWindow.children[c]['bg'] = '#394747'
            DeskTopWindow.children[c]['border'] = 0
            DeskTopWindow.children[c].place(x = 110, y = 55+i)
            i+=50
    DeskTopWindow.mainloop()

# temp so that I can work on making the sub-menu work
if __name__ == '__main__':
    DeskTopMenu()
