import sys
wavelengths=[]
intensities=[]
with open(sys.argv[1], "r") as reference:
	i=0
	for line in reference:	
		line=line.replace(',','.')
		line=line.split()
		if(i>5):
			if(len(line)>1):
				wavelengths.append(float(line[0]))
				intensities.append(float(line[1]))
		i+=1

f = open(sys.argv[2], 'w')
sortie = ""
for i in range(len(wavelengths)):
	sortie += str(wavelengths[i]) + " " + str(intensities[i]) + "\n"
f.write(sortie)	
f.close()


	

