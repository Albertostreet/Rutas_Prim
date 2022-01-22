def prim(w,n,s):
   v = []
   while len(v) != n:
      v.append(0)

   v[s] = 1
   E = []
   
   for i in range(0,n-1):
      minimo = 9
      agregar_vertice = 0
      e = []
      for j in range(0,n):
         if v[j] == 1:
            for k in range(0,n):
               if v[k] == 0 and w[j][k] < minimo:
                  agregar_vertice = k
                  e = [j+1,k+1]
                  minimo = w[j][k]
      v[agregar_vertice] = 1
      E.append(e)           
   return E

n = 6
s=0
w = [
    [9,4,2,9,3,9],
    [4,9,9,5,9,9],
    [2,9,9,1,6,3],
    [9,5,1,9,9,6],
    [3,9,6,9,9,2],
    [9,9,3,6,2,9],
]
print(w[0][2])
#print(prim(w,n,s))