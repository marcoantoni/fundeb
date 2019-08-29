import csv
import mysql.connector
from mysql.connector import Error

# Converte numeros inteiros para decimal transformando os dois ultimos digitos em decimal.
# Nos arquivos usados, os numeros nao apresentam separador decimal.

def convert(numero):
	tmp = str(numero)
	penultimo = len(tmp) - 2
	num = tmp[:penultimo] + '.' + tmp[penultimo:]
	return float(num)

connection = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="root-p",
  database="fundeb"
)

line_count = 0
with open('DADOS_CONSOLIDADOS_2018.CSV') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    for row in csv_reader:
		AN_EXERCICIO = row[0]
		CO_MUNICIPIO_IBGE = row[5]
		NU_PERIODO = row[2]
		print(row[8])
		
		if row[8] != "":
			VL_RECEITA_PREVISAO_ATUALIZADA =  convert(row[8])
		else:
			VL_RECEITA_PREVISAO_ATUALIZADA = 0
		
		if row[9] != "":
			VL_RECEITA_REALIZADA = convert(row[9])
		else:
			VL_RECEITA_REALIZADA = 0

		if row[10] != "":
			VL_RECEITA_ORCADA = convert(row[10])
		else:
			VL_RECEITA_ORCADA = 0

		if row[12] != "":
			VL_DESPESA_EMPENHADA = convert(row[12])
		else:
			VL_DESPESA_EMPENHADA = 0
	
		if row[14] != "":
			VL_DESPESA_PAGA = convert(row[14])
		else:
			VL_DESPESA_PAGA = 0
	
		if row[16] != "":
			VL_DESPESA_LIQUIDADA_EDUCACAO = convert(row[16])
		else:
			VL_DESPESA_LIQUIDADA_EDUCACAO
		line_count += 1

		try:
			cursor = connection.cursor()
			mySql_insert_query = """INSERT INTO despesas (NU_PERIODO, AN_EXERCICIO, CO_MUNICIPIO_IBGE, VL_RECEITA_PREVISAO_ATUALIZADA, VL_RECEITA_REALIZADA, VL_RECEITA_ORCADA, VL_DESPESA_EMPENHADA, VL_DESPESA_PAGA, VL_DESPESA_LIQUIDADA_EDUCACAO) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s) """
			recordTuple = (NU_PERIODO, AN_EXERCICIO, CO_MUNICIPIO_IBGE, VL_RECEITA_PREVISAO_ATUALIZADA, VL_RECEITA_REALIZADA, VL_RECEITA_ORCADA, VL_DESPESA_EMPENHADA, VL_DESPESA_PAGA, VL_DESPESA_LIQUIDADA_EDUCACAO)
			cursor.execute(mySql_insert_query, recordTuple)
			connection.commit()

		except mysql.connector.Error as error:
			print("Failed to insert into MySQL table {}".format(error))
			print("Erro na linha: ", line_count)