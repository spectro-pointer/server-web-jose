import parseur_spectre_reference as psr
""" this script is not optimize, the complexity is really bad... but it's not important, because we don't often need to use it"""

def parseur_spectre_resize(name_good_size, name_bad_size):
	# wl = wavelength, it = intensity. Spectre_a has the right format. We want to parse spectre_b
	wl_spectre_a, it_spectre_a = psr.parseur_spectre(name_good_size)
	wl_spectre_b, it_spectre_b = psr.parseur_spectre(name_bad_size)
	# we initialize our final results
	wl_new_spectre, it_new_spectre = wl_spectre_a, len(wl_spectre_a)*[0]

	index=0
	numberOfValue=0
	for i in range(len(wl_spectre_b)):
		if(wl_spectre_b[i] < wl_spectre_a[index]):
			it_new_spectre[index]+=it_spectre_b[i]
			numberOfValue+=1
		else:
			it_new_spectre[index]=it_new_spectre[index]/numberOfValue
			numberOfValue=0
			index+=1
			if(index<len(wl_spectre_a)):
				it_new_spectre[index]+=it_spectre_b[i]
				numberOfValue+=1
			else:
				break
	return wl_new_spectre, it_new_spectre

