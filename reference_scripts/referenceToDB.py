#!/usr/bin/python
import parseur_spectre_reference as psr
import choose_id_reference as cir
import check_reference as cr
import sys
import MySQLdb
import string

wavelengths,intensities=[],[]
wavelengths, intensities=psr.parseur_spectre(sys.argv[1])

nameReference=sys.argv[2]
nameReference=string.lower(nameReference)
cr.check_reference(nameReference)

new_id=cir.choose_id_reference()

# Open database connection
db = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

for i in range(len(wavelengths)):
	sql = "INSERT INTO Spectrum_Reference(id, \
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
	   print "Unexpected error:", sys.exc_info()[0]
   	   raise

# disconnect from server
db.close()

db2 = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

# prepare a cursor object using cursor() method
cursor = db2.cursor()

sql = "INSERT INTO ReferTo(name, id, image) \
	   VALUES ('%s', '%d', NULL)" % (nameReference, new_id)
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
