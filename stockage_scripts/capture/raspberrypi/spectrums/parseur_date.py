import re

def parseur_date(fileName):
	name=re.split("-|_|:|\.",fileName)
	date=name[2]+"-"+name[1]+"-"+name[0]+" "+name[3]+":"+name[4]+":"+name[5]
	return date
