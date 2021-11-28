Para generar unos usuarios de prueba con los distintos timezones de la prueba teclea:
'php artisan db:seed UsersTableSeeder'
Los inspectores son:
    -Admin               admin@fake.com 12345678
    -Óscar               oskijob@fake.com 12345678
    -John Smith          john.smith@fake.gb 12345678
    -Vinicio del Pozo    vinicio.pozo@fake.com.mx 12345678


- El token para acceder desde postman a la api lleva un Atributo X-CSRF-TOKEN y el valor del token 
lo he hecho visible desde /token.

- Se puede acceder también a través de formulario y hacer las mismas operaciones.

- Por un lado la api para devolver json sería a través de la ruta /api/planificaciones y los 
formularios están en /planificaciones. 


- El archivo .env.RENOMBRAR hay que dejarlo como .env con los datos de la conexión a mysql usada.

 
En cuanto a las planificaciones he creado 3 estados, plasmado en bbdd con un enum
    -0 Sin asignar
    -1 Asignado (es decir ya ha sido cogido el trabajo por un inspector y le ha puesto una fecha)
    -2 Completado (ya no puede ser editado)


El timezone mantengo UTC en bbdd para cualquiera de los inspectores y solamente cambio el UTC para 
mostrarles los datos con sus respectivos usos.

Es decir, un inspector mexicano introduce una fecha de 2021-11-26 12:00, en BBDD se escribirá como 
el correspondiente en UTC, aunque a él le seguirá saliendo la información con su uso horario.

En el CRUD, he dejado que un inspector pueda editar (la fecha) un trabajo previamente autoasignado 
mientras no esté finalizado.
Los trabajos sólo los pueden crear y borrar el admin, desde el CRUD.

