
def parseur_spectre(fileName):
	wavelengths, intensities = [],[]
	with open(fileName, "r") as capture:
		i=0
		for line in capture:
			if i > 4:			
				line=line.split()
				if(len(line)>1):
					wavelengths.append(float(line[0]))
					intensities.append(float(line[1]))
			i+=1
	return wavelengths, intensities
