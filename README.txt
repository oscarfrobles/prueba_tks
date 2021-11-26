Para generar unos usuarios de prueba con los distintos timezones de la prueba teclea:
'php artisan db:seed UsersTableSeeder'
Los inspectores son:
    -Admin               admin@fake.com 12345678
    -Óscar               oskijob@fake.com 12345678
    -John Smith          john.smith@fake.gb 12345678
    -Vinicio del Pozo    vinicio.pozo@fake.com.mx 12345678


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
Los trabajos sólo los pueden crear y borrar el admin.

