from SOAPpy import SOAPProxy
client = SOAPProxy('http://localhost:8088/SOAP_sabatine/soap.php', 'http://jemiaymen.com')
client.add(200,150)
client.sub(300,150)
client.div(10,2)
client.mult(2,3)
