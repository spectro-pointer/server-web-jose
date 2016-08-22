import MySQLdb
def choose_id_capture():

	# Open database connection
	db = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

	# prepare a cursor object using cursor() method
	cursor = db.cursor()

	cursor.execute("SELECT id_spectre FROM Capture")
	id_deja_utilises= cursor.fetchall()
	list_id=[int(i[0]) for i in id_deja_utilises]
	proposition=max(list_id)+1

	db.close()

	return proposition
