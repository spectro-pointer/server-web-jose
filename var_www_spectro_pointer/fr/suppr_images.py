#!/usr/bin/python

import re
import os 
from datetime import datetime
import sys

def parseur_date(fileName):
	name=re.split("-|_|:|\.",fileName)
	date=datetime(year=int(name[1]), month=int(name[2]), day=int(name[3]), hour=int(name[4]), minute=int(name[5]), second=int(name[6]))
	return date

print("enter the date with the format year-month-day-hour-minute-second")

minRaw = re.split("-|_|:|\.",sys.argv[1])
minRaw=[int(x) for x in minRaw]
dateMin = datetime(year=minRaw[0], month=minRaw[1], day=minRaw[2], hour=minRaw[3], minute=minRaw[4], second=minRaw[5])

maxRaw = re.split("-|_|:|\.",sys.argv[2])
maxRaw=[int(x) for x in maxRaw]
dateMax = datetime(year=maxRaw[0], month=maxRaw[1], day=maxRaw[2], hour=maxRaw[3], minute=maxRaw[4], second=maxRaw[5])

dossier_capture=os.listdir('./images')
nom_capture=[x for x in dossier_capture if x.find('jpg')!=-1]

datetime_capture = [(x,parseur_date(x)) for x in nom_capture]
a_suppr=[x for (x,d) in datetime_capture if (d>dateMin and d<dateMax)]
for i in a_suppr:
	os.remove('./images/'+str(i))
