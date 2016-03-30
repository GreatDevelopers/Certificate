Certificate Generation System
=============================

INSTALLATION/SETUP
------------------

This application is a portable application used to Generate Certificate for single candidate providing his/her details along with image,  
As well as for Batch/Number of candidates by simply providing the CSV format file (containing details of every candidate) along with candidate images in a compressed (tar.gz or zip) folder.

Requirements(automatically installed during setup) 
------------
1. Apache web server
2. php interpreter
3. unoconv
4. python3-uno
	
Setup
-----
	cd ../path/to/certificate/
	sudo ./install.sh
	
Congratulations! You have successfully set it up.

Go to http://localhost/Certificate/CGS/

OR

http://localhost/~username/Certificate/CGS/(if Usermode is enabled in apache configuration)

If you got an error like Abort pclzip.lib.php : Missing zlib extensions

	$ cd /var/www/Certificate/library/zip/pclzip/

	$ vim pclzip.lib.php

Replace gzopen64 with gzopen

USER MANUAL
-----------

As the Name "Certificate Generation System" Implies this application is used to 
generate certificate in an automated manner in few steps: 

1. Select Design from the images shown on the first page.
   ( Put mouse pointer over the image to see larger view. )

2. Next Page will be page for entering Institute Details.
   
   Fill in the details of institution for which the certificate(s) is to be made.
   
   Place mouse pointer over Input box te see an example for that input.

3. Next page will show two options
   
   Manual Entry    -> Select it for Generating Certificate for Single candidate.
   
   Upload Csv File -> Select it for Generating certificate for more than 1 candidate by providing their details in Csv file.

 
    Manual Entry 
    ------------

      On Selecting Manual Entry Next page will open containing input boxes for candidate Details.
      
      Enter the details and select the image also.
  
      Live Image Selector
      -------------------
      Next you will be displayed your selected image and a selection box.
      
      Resize and move the selection box to desired position and size.
 
      Download
      --------
      Thats it your certificate is generated and can be downloaded in two formats
      
      -> odt ('O'penOffice 'D'ocument 'T'ext)
      
      -> pdf ('P'ortable 'D'ocument 'F'ormat)

      Also by clicking on "Generate Another Ceritificate" you can generate another certificate 
      
      with same design & institute details and different Candidate Details.

      And by clicking on "Goto First Page" you can again start from Design Selection Page.


    Upload csv file
    ---------------

      On selecting 'Upload csv File' Next page will open containing the conditions for the files
      
      to be uploaded for certificate generation.
      
      A sample file can be downloaded from the link provided in the 'Note' in the instructions on page.

      Sample file is a zip file named sample.zip containing the csv file and tar.gz file for images.
      
      Extract it and then sample certificates can be produced using 'sample.csv' and 'images.tar.gz' files.

      That's it your certificate file is produced for all the candidates provided in the csv data file.
      
      Download
      --------
      
      Produced Certificate file can be downloaded in two formats again.
      
      -> odt ('O'penOffice 'D'ocument 'T'ext)
      
      -> pdf ('P'ortable 'D'ocument 'F'ormat)
      
      And by clicking on "Goto First Page" you can again start from Design Selection Page.
