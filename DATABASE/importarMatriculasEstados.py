import csv
import math
import mysql.connector
from mysql.connector import Error

connection = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="root-p",
  database="fundeb"
)

def inserirMatricula(id_segmento, quantidade, ano, tipo, educacao, id_estado):
	try:
		cursor = connection.cursor()
		sql = "INSERT INTO matriculas (id_segmento, quantidade, tipo, educacao, ano, id_estado) VALUES (%s, %s, %s, %s, %s, %s)" 
		values = (id_segmento, quantidade, tipo, educacao, ano, id_estado)
		cursor.execute(sql, values)
		connection.commit()	
	except:	
		print("Erro", values)

line_count = 0
with open('matriculasEstados2018.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    ano = 2018
    for row in csv_reader:
		uf=row[0]
		cursor = connection.cursor()
		cursor.execute("SELECT estados.* FROM estados WHERE estados.uf = %s", (uf, ))

		result = cursor.fetchone()
		id_estado = result[0]
		print("Estado ", uf)
		print("Estado ", id_estado)


		# ESCOLAS PUBLICAS
		# tipo R ou U
		qtd_matriculas = row[2].replace(",", ".")
		inserirMatricula(1, qtd_matriculas, ano, 'P', '', id_estado)


		qtd_matriculas = row[3].replace(",", ".")
		inserirMatricula(2, qtd_matriculas, ano, 'P', '', id_estado)


		qtd_matriculas = row[4].replace(",", ".")
		inserirMatricula(3, qtd_matriculas, ano, 'P', '', id_estado)

		qtd_matriculas = row[5].replace(",", ".")
		inserirMatricula(4, qtd_matriculas, ano, 'P', '', id_estado)

		# educacao P ou C
		# ensino fundamental
		qtd_matriculas = row[6].replace(",", ".")
		inserirMatricula(5, qtd_matriculas, ano, 'P', 'U', id_estado)

		qtd_matriculas = row[7].replace(",", ".")
		inserirMatricula(5, qtd_matriculas, ano, 'P', 'R', id_estado)


		qtd_matriculas = row[8].replace(",", ".")
		inserirMatricula(6, qtd_matriculas, ano, 'P', 'U', id_estado)


		qtd_matriculas = row[9].replace(",", ".")
		inserirMatricula(6, qtd_matriculas, ano, 'P', 'R', id_estado)

		qtd_matriculas = row[10].replace(",", ".")
		inserirMatricula(7, qtd_matriculas, ano, 'P', '', id_estado)

		## ensino medico
		qtd_matriculas = row[11].replace(",", ".")
		inserirMatricula(8, qtd_matriculas, ano, 'P', 'U', id_estado)
		
		qtd_matriculas = row[12].replace(",", ".")
		inserirMatricula(8, qtd_matriculas, ano, 'P', 'R', id_estado)

		qtd_matriculas = row[13].replace(",", ".")
		inserirMatricula(9, qtd_matriculas, ano, 'P', '', id_estado)
		
		qtd_matriculas = row[14].replace(",", ".")
		inserirMatricula(10, qtd_matriculas, ano, 'P', '', id_estado)

		# EDUCACAO ESPECIAL
		qtd_matriculas = row[15].replace(",", ".")
		inserirMatricula(14, qtd_matriculas, ano, 'P', '', id_estado)

		# AEE
		qtd_matriculas = row[16].replace(",", ".")
		inserirMatricula(13, qtd_matriculas, ano, 'P', '', id_estado)

		# EJA 1
		qtd_matriculas = row[17].replace(",", ".")
		inserirMatricula(11, qtd_matriculas, ano, 'P', '', id_estado)	

		# EJA 2
		qtd_matriculas = row[18].replace(",", ".")
		inserirMatricula(12, qtd_matriculas, ano, 'P', '', id_estado)

		# INDIGENA
		qtd_matriculas = row[19].replace(",", ".")
		inserirMatricula(15, qtd_matriculas, ano, 'P', '', id_estado)


		# ESCOLAS CONVENIADAS
		qtd_matriculas = row[20].replace(",", ".")
		inserirMatricula(1, qtd_matriculas, ano, 'C', '', id_estado)


		qtd_matriculas = row[21].replace(",", ".")
		inserirMatricula(2, qtd_matriculas, ano, 'C', '', id_estado)

		qtd_matriculas = row[22].replace(",", ".")
		inserirMatricula(3, qtd_matriculas, ano, 'C', '', id_estado)

		qtd_matriculas = row[23].replace(",", ".")
		inserirMatricula(4, qtd_matriculas, ano, 'C', '', id_estado)

		qtd_matriculas = row[24].replace(",", ".")
		inserirMatricula(14, qtd_matriculas, ano, 'C', '', id_estado)

		#estimativaReceita = row[31].replace(".", "").replace(",", ".")
		#coeficiente = row[32].replace("R$", "")
		#cursor = connection.cursor()
		#sql = "INSERT INTO estimativaReceitas (estimativa, coeficiente, municipios_id, ano) VALUES (%s, %s, %s, %s)" 
		#values = (estimativaReceita, coeficiente, id_municipio, ano)
		#cursor.execute(sql, values)
		#connection.commit()	
		



