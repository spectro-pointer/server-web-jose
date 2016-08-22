#!/bin/bash
liste=$(ls | grep -E ".*txt.*")

for source in $liste
do
	python captureToDB.py $source
	cp $source ../archives_spectrums/$source
	rm $source
done

