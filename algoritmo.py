from flask import Flask, request
from flask_cors import CORS
from math import sin, cos, sqrt, atan2, radians

R = 6373.0

app = Flask(__name__)
CORS(app)

def prim(w,n,s):
   v = []
   while len(v) != n:
      v.append(0)

   v[s] = 1
   E = []
   conexiones = {}
   aux = {}
   for i in range(0,n-1):
      minimo = 9
      agregar_vertice = 0
      e = []
      for j in range(0,n):
         if v[j] == 1:
            for k in range(0,n):
               if v[k] == 0 and w[j][k] < minimo:
                  agregar_vertice = k
                  e = [j,k]
                  
                  minimo = w[j][k]
      v[agregar_vertice] = 1
      E.append(e)
      conexiones[i] = { "estacion1": e[0], "estacion2": e[1]}
      
   #print(conexiones)
   print(E)
   return conexiones

@app.route("/", methods=['POST'])
def main():
      json = request.get_json(force=True)
      #sacar las distancias entre todos
      listaNodos = [int(nodo) for nodo in json]
      contador = 0
      contadorAux = 0
      w=[]
      while (len(listaNodos)) > contador:
         w.append([])
         while (len(listaNodos)) > contadorAux:
            if contadorAux != contador:
               lat1 = radians(json[str(contador)]['lat'])
               lon1 = radians(json[str(contador)]['lng'])
               lat2 = radians(json[str(contadorAux)]['lat'])
               lon2 = radians(json[str(contadorAux)]['lng'])
               dlon = lon2 - lon1
               dlat = lat2 - lat1
               a = sin(dlat / 2)**2 + cos(lat1) * cos(lat2) * sin(dlon / 2)**2
               c = 2 * atan2(sqrt(a), sqrt(1 - a))

               distance = R * c
               distanceAux = float("{:.2f}".format(distance))
               w[contador].insert(contadorAux, distanceAux)
            else:
               w[contador].insert(contadorAux, 9)
            contadorAux += 1
         contador += 1
         contadorAux = 0
      n = len(listaNodos)
      s = 0
      diccionario = {}
      diccionario["conexion"] = prim(w,n,s)
      diccionario["estacion"] = json
      #print(diccionario)
      return diccionario


if __name__ == '__main__':
   app.run(debug = True)