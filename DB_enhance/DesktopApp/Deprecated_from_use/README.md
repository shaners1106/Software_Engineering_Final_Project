# Deprecated Desktop Application Files

This directory contains the first and second attempts we made at getting Hewitt printing onto scantron sheets.  While these attempts fell short, the Python libraries explored and the documentation is worth preserving, so we decided to separate it into its own directory.

## Files

### python_plotnine.py

This file contains Python code that was used within the Python Plotnine library to construct ggplots that were converted into pdf files that acted as templates for printing to Hewitt's scantron tests.  Plotnine is a "Grammar of Graphics" library that utilizes key functionality of the R programming language and its ability to graphically represent data.  Unfortunately, we had trouble getting the printer to consistently print to the cartesian coordinates that we designated for the printable objects.  So we've deprecated this file from use, but will leave it here for future use.

### python_docx.py

This file contains the Python Docx code we used in trying to create a print template.  We've deprecated this file from use because it did not allow us to create an accurate print template, however we are leaving the file here for future reference. The Python docx library allows you to generate a word document using Python programming.