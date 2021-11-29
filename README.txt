El código lo he subido a github y puede ser descargado mediante 
`git clone https://github.com/oscarfrobles/prueba_tks.git`

- El archivo .env.RENOMBRAR hay que dejarlo como .env con los datos de la conexión a mysql usada.

Para generar los usuarios de prueba con los distintos timezones de la prueba teclea desde la raiz 
del proyecto:
`php artisan db:seed UsersTableSeeder`

Para visualizar el proyecto, sin configurar un virtual host, se puede lanzar el servidor con:
`php artisan serve`

Los inspectores son: 
    -Admin               admin@fake.com 12345678            UTC
    -Óscar               oskijob@fake.com 12345678          Europe/Madrid
    -John Smith          john.smith@fake.gb 12345678        Europe/London
    -Vinicio del Pozo    vinicio.pozo@fake.com.mx 12345678  America/Mexico_City

- Ruta Swagger /api/documentation (No es necesario token)

- Si se accede medienate postman o similar el token para acceder a la api lleva un Atributo X-CSRF-TOKEN
 y el valor del token lo he hecho visible desde /token.

- Se puede acceder también a través de formulario y hacer las mismas operaciones.

- Por un lado la api para devolver json sería a través de la ruta /api/planificaciones y los 
formularios están en /planificaciones. 
 
En cuanto a las planificaciones he creado 3 estados, plasmado en bbdd con un enum
    -0 Sin asignar
    -1 Asignado (es decir ya ha sido cogido el trabajo por un inspector y le ha puesto una fecha)
    -2 Completado (ya no puede ser editado)

En los get he puesto un parámetro user_id para poder ver las diferencias que verían los usuarios con sus
distintos usos, aunque en BBDD guardo todas las fechas en UTC, es decir, el timezone mantengo UTC en bbdd para cualquiera de los inspectores y solamente cambio el UTC al 
propio de cada inspector para mostrarles los datos con sus respectivos usos.

Un inspector mexicano introduce una fecha de 2021-11-26 12:00, en BBDD se escribirá como el correspondiente
en UTC, aunque a él le seguirá saliendo la información con su uso horario.

En el CRUD, he dejado que un inspector pueda editar (la fecha) un trabajo previamente autoasignado 
mientras no esté finalizado.
Los trabajos sólo los pueden crear y borrar el admin, desde el CRUD.

- Para generar la documentación he usado swagger que puede ser generada mediante:
    `php artisan l5-swagger:generate`

- Para realizar la prueba he usado PHP/7.3 con Ubuntu 18.04
