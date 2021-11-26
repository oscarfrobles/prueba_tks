Para generar unos usuarios de prueba con los distintos timezones de la prueba teclea:
'php artisan db:seed UsersTableSeeder'
Los inspectores son:
Admin               admin@fake.com 12345678
Óscar               oskijob@fake.com 12345678
John Smith          john.smith@fake.gb 12345678
Vinicio del Pozo    vinicio.pozo@fake.com.mx 12345678


En cuanto a las planificaciones he creado 3 estados, plasmado en bbdd con un enum
0 Sin asignar
1 Asignado (es decir ya ha sido cogido el trabajo por un inspector y le ha puesto una fecha)
2 Completado (ya no puede ser editado)

