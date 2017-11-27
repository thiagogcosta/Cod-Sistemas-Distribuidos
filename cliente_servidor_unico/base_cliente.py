"""
Lado do Cliente: Usa sockets para mandar data para o server, e imprime
a resposta do server p/ cada linha na mensagem. Podemos colocar o host
como sendo localhost para indicar que o server está na mesma máquina.
Para rodar através da internet é preciso colocar o server em outra máquina e pasar
p/ o nome do host o endereço de IP ou o nome do domínio.
"""


from socket import *

#Configurações de conexão do server
#O nome do server pode ser o endereço de
#IP ou o domínio (ola.python.net)

#ipconfig -> Windows
#ifconfig -> Linux
serverHost = 'localhost'
serverPort = 50007

#Msg a ser mandada codificada em bytes
msg = [b'Ola mundo da internet!']

#Criamos o socket e o conectamos ao server
sockobj = socket(AF_INET, SOCK_STREAM)
sockobj.connect((serverHost, serverPort))

#Mandamos a msg linha por linha
for linha in msg:
    sockobj.send(linha)

    #Depois de mandas 1 linha esperamos uma resposta do server
    data = sockobj.recv(1024)
    print('Cliente recebeu:', data)


#Fechamos a conexão
sockobj.close()

