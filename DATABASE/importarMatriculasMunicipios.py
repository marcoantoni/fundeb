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

def inserirMatricula(id_municipio, id_segmento, quantidade, ano, tipo, educacao, id_estado):
	try:
		cursor = connection.cursor()
		sql = "INSERT INTO matriculas (id_municipio, id_segmento, quantidade, tipo, educacao, ano, id_estado) VALUES (%s, %s, %s, %s, %s, %s, %s)" 
		values = (id_municipio, id_segmento, quantidade, tipo, educacao, ano, id_estado)
		cursor.execute(sql, values)
		connection.commit()	
	except:	
		print("Erro" + values)

line_count = 0
with open('port_intermin_06_26122018_mat_coef_est_receita_RS-2-convertido.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    ano = 2018
    for row in csv_reader:
		uf=row[0]
		cidade = row[1];
		print(cidade + "/" + uf)
		
		#sql = ("SELECT municipios.* FROM municipios, estados WHERE municipios.nome like '" + cidade +"' AND municipios.id_estado = estados.id AND estados.uf = '"+uf+"'")
		cursor = connection.cursor()
		cursor.execute("SELECT municipios.* FROM municipios, estados WHERE municipios.nome = %s AND municipios.id_estado = estados.id AND estados.uf = %s", (cidade, uf))

		# old  - work
		#cursor = connection.cursor()
		#cursor.execute(sql)

		result = cursor.fetchone()
		id_municipio = result[0]

		# ESCOLAS PUBLICAS
		# tipo R ou U
		qtd_matriculas = row[2]
		inserirMatricula(id_municipio, 1, qtd_matriculas, ano, 'P', '', 0)


		qtd_matriculas = row[3]
		inserirMatricula(id_municipio, 2, qtd_matriculas, ano, 'P', '', 0)


		qtd_matriculas = row[4];
		inserirMatricula(id_municipio, 3, qtd_matriculas, ano, 'P', '', 0)

		qtd_matriculas = row[5] 
		inserirMatricula(id_municipio, 4, qtd_matriculas, ano, 'P', '', 0)

		# educacao P ou C
		# ensino fundamental
		qtd_matriculas = row[6]
		inserirMatricula(id_municipio, 5, qtd_matriculas, ano, 'P', 'U', 0)

		qtd_matriculas = row[7]
		inserirMatricula(id_municipio, 5, qtd_matriculas, ano, 'P', 'R', 0)


		qtd_matriculas = row[8]
		inserirMatricula(id_municipio, 6, qtd_matriculas, ano, 'P', 'U', 0)


		qtd_matriculas = row[9]
		inserirMatricula(id_municipio, 6, qtd_matriculas, ano, 'P', 'R', 0)

		qtd_matriculas = row[10]
		inserirMatricula(id_municipio, 7, qtd_matriculas, ano, 'P', '', 0)

		## ensino medico
		qtd_matriculas = row[11]
		inserirMatricula(id_municipio, 8, qtd_matriculas, ano, 'P', 'U', 0)
		
		qtd_matriculas = row[12]
		inserirMatricula(id_municipio, 8, qtd_matriculas, ano, 'P', 'R', 0)

		qtd_matriculas = row[13]
		inserirMatricula(id_municipio, 9, qtd_matriculas, ano, 'P', '', 0)
		
		qtd_matriculas = row[14]
		inserirMatricula(id_municipio, 10, qtd_matriculas, ano, 'P', '', 0)

		# EDUCACAO ESPECIAL
		qtd_matriculas = row[15]
		inserirMatricula(id_municipio, 14, qtd_matriculas, ano, 'P', '', 0)

		# AEE
		qtd_matriculas = row[16]
		inserirMatricula(id_municipio, 13, qtd_matriculas, ano, 'P', '', 0)

		# EJA 1
		qtd_matriculas = row[17]
		inserirMatricula(id_municipio, 11, qtd_matriculas, ano, 'P', '', 0)	

		# EJA 2
		qtd_matriculas = row[18]
		inserirMatricula(id_municipio, 12, qtd_matriculas, ano, 'P', '', 0)

		# INDIGENA
		qtd_matriculas = row[19]
		inserirMatricula(id_municipio, 15, qtd_matriculas, ano, 'P', '', 0)


		# ESCOLAS CONVENIADAS
		qtd_matriculas = row[20]
		inserirMatricula(id_municipio, 1, qtd_matriculas, ano, 'C', '', 0)


		qtd_matriculas = row[21]
		inserirMatricula(id_municipio, 2, qtd_matriculas, ano, 'C', '', 0)

		qtd_matriculas = row[22];
		inserirMatricula(id_municipio, 3, qtd_matriculas, ano, 'C', '', 0)

		qtd_matriculas = row[23]
		inserirMatricula(id_municipio, 4, qtd_matriculas, ano, 'C', '', 0)

		qtd_matriculas = row[24]
		inserirMatricula(id_municipio, 14, qtd_matriculas, ano, 'C', '', 0)

		estimativaReceita = row[31].replace(".", "").replace(",", ".")
		coeficiente = row[32].replace("R$", "")
		cursor = connection.cursor()
		sql = "INSERT INTO estimativaReceitas (estimativa, coeficiente, municipios_id, ano) VALUES (%s, %s, %s, %s)" 
		values = (estimativaReceita, coeficiente, id_municipio, ano)
		cursor.execute(sql, values)
		connection.commit()	
		



