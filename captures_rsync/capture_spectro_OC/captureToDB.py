#!/usr/bin/python
import parseur_spectre as ps
import choose_id_capture as cic
import sys
import attribute_image as at
wavelengths,intensities=[],[]
serial_num,capture_date,integration_time,number_scans,boxcar_smoothing,wavelengths, intensities=ps.parseur_spectre(sys.argv[1])
list_images=at.rename_attribute_img_spectrum()

new_id=cic.choose_id_capture()

import MySQLdb

# Open database connection
db = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

for i in range(len(wavelengths)):
	sql = "INSERT INTO Spectrum_Capture(id, \
		   wavelength, intensity) \
		   VALUES ('%d', '%f', '%f')" % \
		   (new_id, wavelengths[i],intensities[i])
	try:
	   # Execute the SQL command
	   cursor.execute(sql)
	   # Commit your changes in the database
	   db.commit()
	except:
	   # Rollback in case there is any error
	   db.rollback()

# disconnect from server
db.close()

db2 = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

# prepare a cursor object using cursor() method
cursor = db2.cursor()

#print(list_images)
#print(capture_date)
path_img="'"+str(list_images[capture_date])+"'"
print(path_img)

sql = "INSERT INTO Capture(id_spectre, \
	   integration_time, number_scans, boxcar_smoothing, image, serial_num, capture_date) \
	   VALUES ('%d', '%d', '%d', '%d', %s, '%s', '%s')" % \
 (new_id,integration_time,number_scans, boxcar_smoothing,path_img,serial_num,capture_date)
try:
   # Execute the SQL command
   cursor.execute(sql)
   # Commit your changes in the database
   db2.commit()
except:
   # Rollback in case there is any error
   db2.rollback()
   print "Unexpected error:", sys.exc_info()[0]
   raise
# disconnect from server
db2.close()
