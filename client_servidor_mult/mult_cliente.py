from socket import *
import threading

class Cliente(threading.Thread):
	#Classe que gera os clientes
	def __init__(self, c, server, port, *mensagem):
		#Número de identificação do cliente
		self.c = c

		#Servidor a ser conectado
		self.server = server

		#Número da porta
		self.port = port

		#Mensagens a serem inseridas
		self.msgs = mensagem

		threading.Thread.__init__(self)
		
	def run(self):
		#Criamos o socket e o conectamos ao servidor
		sockobj = socket(AF_INET, SOCK_STREAM)
		sockobj.connect((self.server, self.port))

		#Enviamos a msg linha por linha
		for linha in self.msgs:
			sockobj.send(linha)

			#Depois de mandar uma linha esperamos uma resposta do servidor
			data = sockobj.recv(1024)
			print('Cliente', self.c, 'recebeu', data)

			#Fechando conexão
			sockobj.close()



#Configuraçoes de conexão do server
#O nome do server pode ser o endereço de IP ou o domínio (ola.python.net)

serverHost = 'localhost'
serverPort = 50007

#Mensagem a ser mandada codificada em bytes
mensagem = [b'Ola mundo da internet!!!']

#Nós spawnamos os clientes
for c in range(20):
	Cliente(c, serverHost, serverPort, *mensagem).start()

print("Geramos todos os Clientes")