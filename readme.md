
estructura a lo symfony pero sin copiar framework
prestar atencion a la estructura, es lo mejor del proyecto

uso un index en web para evitar ataques

incluyo un bootstrap para diferencia la carga de la app normal y para test

uso patron front controller para determinar el enroutado y quien se hace cargo de las peticiones. Podría usar un router pero creo que es demasiado

front controller captura la salida del controlador invocado y lo inyecta en el layout para facilitar el testeo unitario de cada controlador y permitir
que se puedan llamar a las rutas siendo estas las primeras ejecutadas

uso phpunit para los tests con base de datos sqlite inmemory

vistas en dos niveles, layout y templates
