import MySQLdb
def choose_id_reference():

	# Open database connection
	db = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

	# prepare a cursor object using cursor() method
	cursor = db.cursor()

	cursor.execute("SELECT id FROM ReferTo")
	id_deja_utilises= cursor.fetchall()
	list_id=[int(i[0]) for i in id_deja_utilises]
	if(list_id != []):
		proposition=max(list_id)+1
	else:
		proposition=1
	"""print("on propose "+str(proposition))
	print("les id deja utilises sont : "+" ".join([str(i) for i in list_id]))"""

	db.close()

	return proposition
