import parseur_date as pdate

def parseur_spectre(fileName):
	wavelengths, intensities = [],[]
	print(fileName)
	date=pdate.parseur_date(fileName)
	print(date)	
	integration_time,number_scans,boxcar_smoothing=0,0,0
	with open(fileName, "r") as capture:
		i=0
		for line in capture:
			if i == 0:
				line=line.split()
				serial_num=line[0]
			elif i == 3:
				line=line.split()
				integration_time=line[2]
			elif i == 4:
				line=line.split()
				number_scans=line[3]
			elif i == 5:
				line=line.split()
				boxcar_smoothing=line[2]
			elif i > 6:			
				line=line.split()
				if(len(line)>1):
					wavelengths.append(float(line[0]))
					intensities.append(float(line[1]))
			i+=1
	return serial_num,date,int(integration_time),int(number_scans),int(boxcar_smoothing),wavelengths, intensities
