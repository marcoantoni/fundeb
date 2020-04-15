import csv
import math
import mysql.connector
from mysql.connector import Error

connection = mysql.connector.connect(
  host="localhost",
  user="debian-sys-maint",
  passwd="HwearQMC4nkPeYmP",
  database="fundeb"
)

def inserirValorAluno(id_estado, id_segmento, valor, ano, tipo, educacao):
	try:
		cursor = connection.cursor()
		sql = "INSERT INTO VLestimadoAluno (id_estado, id_segmento, valor, ano, educacao, tipo) VALUES (%s, %s, %s, %s, %s, %s)" 
		values = (id_estado, id_segmento, valor, ano, educacao, tipo )
		cursor.execute(sql, values)
		connection.commit()	
	except:	
		print("Erro", values)

line_count = 0
with open('estimativaPorAluno/2018.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    ano = 2018
    for row in csv_reader:
		uf=row[0]
		
		cursor = connection.cursor()
		cursor.execute("SELECT * FROM estados WHERE estados.uf = %s", (uf, ) )

		# old  - work
		#cursor = connection.cursor()
		#cursor.execute(sql)

		result = cursor.fetchone()
		id_estado = result[0]
		print(uf , "/ id" , id_estado)

		# ESCOLAS PUBLICAS
		# tipo R ou U
		valor = row[1]
		inserirValorAluno(id_estado, 1, valor, ano, 'P', '')


		valor = row[2]
		inserirValorAluno(id_estado, 3, valor, ano, 'P', '')


		valor = row[3];
		inserirValorAluno(id_estado, 2, valor, ano, 'P', '')

		valor = row[4] 
		inserirValorAluno(id_estado, 4, valor, ano, 'P', '')

		# educacao P ou C
		# ensino fundamental
		valor = row[5]
		inserirValorAluno(id_estado, 5, valor, ano, 'P', 'U')

		valor = row[6]
		inserirValorAluno(id_estado, 5, valor, ano, 'P', 'R')


		valor = row[7]
		inserirValorAluno(id_estado, 6, valor, ano, 'P', 'U')


		valor = row[8]
		inserirValorAluno(id_estado, 6, valor, ano, 'P', 'R')

		valor = row[9]
		inserirValorAluno(id_estado, 7, valor, ano, 'P', '')

		## ensino medico
		valor = row[10]
		inserirValorAluno(id_estado, 8, valor, ano, 'P', 'U')
		
		valor = row[11]
		inserirValorAluno(id_estado, 8, valor, ano, 'P', 'R')

		valor = row[12]
		inserirValorAluno(id_estado, 9, valor, ano, 'P', '')
		
		valor = row[13]
		inserirValorAluno(id_estado, 10, valor, ano, 'P', '')

		# AEE
		valor = row[14]
		inserirValorAluno(id_estado, 14, valor, ano, 'P', '')

		# EDUCACAO ESPECIAL
		valor = row[15]
		inserirValorAluno(id_estado, 13, valor, ano, 'P', '')

		# INDIGENA
		valor = row[16]
		inserirValorAluno(id_estado, 15, valor, ano, 'P', '')

		# EJA 1
		valor = row[17]
		inserirValorAluno(id_estado, 11, valor, ano, 'P', '')	

		# EJA 2
		valor = row[18]
		inserirValorAluno(id_estado, 12, valor, ano, 'P', '')

		

		# ESCOLAS CONVENIADAS
		valor = row[19]
		inserirValorAluno(id_estado, 1, valor, ano, 'C', '')


		valor = row[20]
		inserirValorAluno(id_estado, 2, valor, ano, 'C', '')

		valor = row[21];
		inserirValorAluno(id_estado, 3, valor, ano, 'C', '')

		valor = row[22]
		inserirValorAluno(id_estado, 4, valor, ano, 'C', '')

		valor = row[23]
		inserirValorAluno(id_estado, 14, valor, ano, 'C', '')
