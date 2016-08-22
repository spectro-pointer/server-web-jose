"""
	Ce script est a placer dans le meme dossier que les spectres (capture_spectro_OC)
	On a une liste de toutes les dates des captures, et une liste de toutes les dates des images.
	On trie ces deux listes.
	On fait une troisieme liste qui comprend des tuples (date image, date capture).
	A partir de cette troisieme liste, on modifiera le nom de chacune des images.

	format image :BUSCA_centered_S05587_29-06-2016_08:49:55.jpg  BUSCA_centered_S05587_29-06-2016_09:03:00.jpg
"""

import os 
import re
import parseur_date as pd

num_serial="S05587"

def rename_attribute_img_spectrum():

	dossier_capture=os.listdir('.')
	nom_capture=[x for x in dossier_capture if x.find('txt')!=-1]
	dossier_image=os.listdir('.')
	nom_image_raw=[x for x in dossier_image if x.find('jpg')!=-1]
	pattern="BUSCA_centered_"+num_serial+"_"
	nom_image=[(x.replace(pattern,''),x) for x in nom_image_raw]

	nom_capture=[pd.parseur_date(i) for i in nom_capture]
	nom_image=[(pd.parseur_date(i[0]),i[1]) for i in nom_image]

	reformattage=[(i[1],num_serial+"_"+i[0].replace(" ","_")+".jpg",i[0]) for i in nom_image] # contient [ancien_nom, nouveau_nom, date]
	#print(reformattage)
	#print(nom_capture)

	reformattage.sort()
	nom_capture.sort()

	resultat={}
	i=0
	while( i<len(nom_capture)):
		if(nom_capture[i]<reformattage[0][2]):
			resultat[nom_capture[i]]='NULL'
			i+=1
			print("pb, nom_capture < aux dates")
		else:
			break
	for j in range(len(reformattage)):
		if j < len(reformattage) -1:
			while(i<len(nom_capture)):
				if(nom_capture[i]<reformattage[j+1][2] ):
					resultat[nom_capture[i]]= num_serial+"_"+reformattage[j][2].replace(" ","_")+".jpg"
					i+=1
				else:					
					break

		else:
			while(i<len(nom_capture)):
				resultat[nom_capture[i]]=num_serial+"_"+reformattage[j][2].replace(" ","_")+".jpg"
				i+=1
	#print(resultat)
	return resultat
"""
for i in reformattage:
	os.rename(i[0],"/var/www/spectro_pointer/images/"+i[1])

"""
	
