#!/bin/bash

cp ./dossier_sync/* ./
rm ./dossier_sync/*

cp ./dossier_sync_img/* ./
rm ./dossier_sync_img/*

liste=$(ls | grep -E ".*txt.*")

for source in $liste
do
	python captureToDB.py $source
	cp $source ./archives/$source
	rm $source
done

sudo python rename_image.py

cp ./*.jpg /var/www/spectro_pointer/images
rm *.jpg

