Dossiers de la RPI serveur :
============================

Il y a differents dossiers :
Le dossier var_www_spectro_pointer est un dossier qui se situe a l'endroit suivant sur la RPI serveur :
/var/www/spectro_pointer. 
Les trois autres dossiers doivent se situer dans /home/pi/<nom du dossier>.

# Description des dossiers :
Le dossier spectro_pointer contient une interface web pour communiquer avec la base de donnees. 
Le dossier captures_rsync est le dossier dans lequel seront recuperees les donnees des differents spectro-pointers, avant d'etre traitees puis envoyees si necessaires au serveur.
Le dossier stockage_scripts contient de nombreux scripts qui ont ete utilises. Certains d'entre eux ne sont que des sauvegardes qui ne sont plus a utiliser, tandis que d'autres sont utiles pour manipuler les spectres.
Le dossier reference_scripts permet de traiter et d'envoyer a la base de donnees les differentes references calculees.

# Remarques :
Dans chacun de ces dossiers, le mdp de la base de donnees a ete fixe a xxxx. Pour changer tous les mots de passe, utiliser la commande find pour trouver la chaine xxxx et la remplacer par le mdp desire.
De nombreux parseurs sont utilises. Si le format des fichiers, ou les conventions de nommage changent, il faudra reecrire tous ces parseurs.


