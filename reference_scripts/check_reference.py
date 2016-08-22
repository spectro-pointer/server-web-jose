import MySQLdb
def check_reference(nameReference):

	# Open database connection
	db = MySQLdb.connect("localhost","root","xxxx","DataBase_Spectro_Pointer" )

	# prepare a cursor object using cursor() method
	cursor = db.cursor()

	cursor.execute("SELECT name FROM Reference")
	id_deja_utilises= cursor.fetchall()
	list_name=[str(i[0]) for i in id_deja_utilises]
	if(nameReference not in list_name):
		sql = "INSERT INTO Reference(name) VALUES ('%s')" % (nameReference)
		try:
		   # Execute the SQL command
		   cursor.execute(sql)
		   # Commit your changes in the database
		   db.commit()
		except:
		   # Rollback in case there is any error
		   db.rollback()
		   print "Unexpected error:", sys.exc_info()[0]
		   raise

	db.close()

