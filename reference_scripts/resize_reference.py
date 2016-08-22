import parseur_spectre_resize as psr
import sys

if len(sys.argv) != 4:
	print("Vous devez entrer 3 parametres : le nom du fichier avec le bon format, le nom du fichier avec trop d'abscisse et le nom du fichier dans lequel se trouvera la solution")
else:
	wavelengths, intensities = psr.parseur_spectre_resize(sys.argv[1], sys.argv[2])
	f = open(sys.argv[3], 'w')
	sortie = ""
	for i in range(len(wavelengths)):
		sortie += str(wavelengths[i]) + " " + str(intensities[i]) + "\n"
	f.write(sortie)	
	f.close()
	
