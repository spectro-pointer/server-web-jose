from pylab import *
import sys
import MySQLdb
import numpy as np
import filtre_savgolay as fsg

wavelengths=[]
intensities=[]
wavelengths2=[]
intensities2=[]

db = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

cursor.execute("SELECT wavelength, intensity FROM Spectrum_Capture WHERE id="+str(sys.argv[1]))
row = cursor.fetchone()

while row is not None:
	
	wavelengths.append(row[0])
	intensities.append(row[1])
	row = cursor.fetchone()

cursor2 = db.cursor()

cursor2.execute("SELECT wavelength, intensity FROM Spectrum_Reference WHERE id="+str(sys.argv[2]))
row2 = cursor2.fetchone()
while row2 is not None:
	intensities2.append(row2[1])
	row2 = cursor2.fetchone()

a=fsg.savitzky_golay(intensities, 30, 2)
v=fsg.savitzky_golay(intensities2, 30, 2)

a = (a - mean(a)) / (std(a) * len(a))
v = (v - mean(v)) /  std(v)

cross_correlation=np.correlate(a, v, 'full')
print(round(max(cross_correlation)*100,2))
db.close()
