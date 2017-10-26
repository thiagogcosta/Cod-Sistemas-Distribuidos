import xmlrpc.client

s = xmlrpc.client.ServerProxy('http://localhost:8000')
print(s.pow(2,3))  # Retorna 2**3 = 8
print(s.add(2,3))  # Retorna 5
print(s.mul(5,2))  # Retorna 5*2 = 10

# Print list of available methods
#print(s.system.listMethods())
