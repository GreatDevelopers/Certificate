Certificate Generation System
=============================

INSTALLATION/SETUP
------------------

This application is a portable application used to Generate Certificate for single candidate providing his/her details along with image,  
As well as for Batch/Number of candidates by simply providing the CSV format file (containing details of every candidate) along with candidate images in a compressed (tar.gz or zip) folder.

Requirements 
------------
1. Apache web server
	$ sudo apt-get install apache2 (if not installed)

2. php interpreter
	$ sudo apt-get install php5 (if not installed)

2. Place the downloaded odtphp.zip from github in /var/www and extract using
	$ unzip odtphp.zip 
   OR
   It can be cloned by using following command in terminal:
	$ git clone https://github.com/Sukhtaaj/odtphp.git

In case Git is not installed then Install git using below command:
	$ sudo apt-get install git

3. Change the permission of odtphp folder and its sub-directories to drwxrwxrwx
	$ sudo chmod -R 777 /var/www/odtphp

4. Download the odt2pdf.tar.gz from "http://202.164.53.122/~sukhdeep/odt2pdf.tar.gz"
   Place it in /var/www/odtphp/ and and then
	$ cd /var/www/odtphp	
	$ tar -zxvf odt2pdf.tar.gz
	$ chmod -R 777 odt2pdf/

Congratulations! You have successfully set it up.
Goto 
http://localhost/odtphp/CGS
OR
http://localhost/~username/odtphp/CGS (if Usermode is enabled in apache configuration)


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

 3/(i) 
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

  3/(ii)
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
