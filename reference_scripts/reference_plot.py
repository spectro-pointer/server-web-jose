from pylab import *
import sys
import filtre_passe_bas as fpb
import filtre_savgolay as fs

subplot(2,1,1)
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
n = len(wavelengths)
X = wavelengths
Y = fs.savitzky_golay(np.asarray(fpb.filtre_passe_bas(intensities,1350)),13,3)
plot (X, Y, color='blue', alpha=1.00)
xlim(300,1000)
if(len(sys.argv) > 2):
	subplot(2,1,2)
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
	n = len(wavelengths2)
	X2 = wavelengths2
	Y2 = fs.savitzky_golay(np.asarray(fpb.filtre_passe_bas(intensities2,1350)),13,3)
	plot (X2, Y2, color='blue', alpha=1.00)
	xlim(300,1000)

a=intensities
v=intensities

a = (a - mean(a)) / (std(a) * len(a))
v = (v - mean(v)) /  std(v)

cross_correlation=np.correlate(a, v)
print(str(round(max(cross_correlation)*100,2))+"% de correspondance")

show()
