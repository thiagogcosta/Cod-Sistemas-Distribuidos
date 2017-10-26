"""
Lado do Server: Abre um TCP/IP numa port, espera por uma mensagem
de um cliente, e manda essa mensagem de volta como resposta. Esse
é uma simples ouve/responde conversação por cliente, mas percorre um loop
infinito para ouvir por mais clientes enquanto o script do server
estiver rodando. O cliente pode rodar em outra máquina ou no mesmo computador
se usar o 'localhost' como server
"""


from socket import *

#Criando o host
myHost = 'localhost'

#Utilizando o número da port
myPort = 50007

#Criando um objeto socket, as constantes referem-se a:
#Família do endereço (padrão é socket.AF_INET)
#Se é stream (socket.SOCK_STREAM, o padrão) ou datagram (socket.SOCK_DGRAM)
#E o protocolo (padrão é 0)
#ou seja:
#AF_INET == Protocolo de endereço de IP
#SOCK_STREAM == Protocolo de transferência TCP
#Combinação = Server TCP/IP

sockobj = socket(AF_INET, SOCK_STREAM)

#Vinculando o server com o número da port
sockobj.bind((myHost, myPort))

#O socket começa a esperar por clientes limitando a
#5 conexões por vez(exemplo)
sockobj.listen(5)

while True:
    #Aceita uma conexão qnd encontrada e devolve a
    #um novo socket conexão e o endereço do cliente
    #conectado
    conexão, endereço = sockobj.accept()
    print('Server conectado por', endereço)

    conexão.recv(4096)
    conexão.send(str('HTTP/1.0 200 OK\n').encode('ascii'))
    conexão.send(str('Content-Type: text/html\n').encode('ascii'))
    conexão.send(str('\n').encode('ascii'))
    conexão.send(str("""<html><head><title>Titulo da pagina</title><meta charset="utf-8"></head><body>Aqui vai o codigo HTML que fara seu site aparecer.</body></html>""").encode('ascii'))

    #Fecha a conexão criada depois de responder o cliente
    conexão.close()
sockobj.close()
