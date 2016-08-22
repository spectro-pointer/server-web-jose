from pylab import *
import sys

wavelengths=[]
intensities=[]
with open(sys.argv[1], "r") as capture:
	i=0
	for line in capture:	
		line=line.split()
		if(len(line)>1):
			wavelengths.append(float(line[0]))
			intensities.append(float(line[1]))
		i+=1
wavelengths2=[]
intensities2=[]
with open(sys.argv[2], "r") as capture2:
	i=0
	for line in capture2:	
		line=line.split()
		if(len(line)>1):
			wavelengths2.append(float(line[0]))
			intensities2.append(float(line[1]))
		i+=1

a=intensities
v=intensities2

a = (a - mean(a)) / (std(a) * len(a))
v = (v - mean(v)) /  std(v)

cross_correlation=np.correlate(a, v)
print(str(round(max(cross_correlation)*100,2))+"% de correspondance")
