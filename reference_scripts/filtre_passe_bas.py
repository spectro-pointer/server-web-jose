def filtre_passe_bas(signal,limite):
	return [x if(x>limite) else limite for x in signal]
	
