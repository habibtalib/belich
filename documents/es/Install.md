# Instalar Belich 

1. Crear migraciones 

~~~
php artisan migrate
~~~

2. Crear autentificación.

~~~
php artisan make:auth
~~~

3. Publicar componentes 

~~~
php artisan vendor:publish --provider="Daguilarm\Belich\ServiceProvider"
~~~

4. Limpiar vistas y cache 

~~~
php artisan view:clear && php artisan cache:clear
~~~

5. Actualizar composer

~~~
composer dump-autoload
~~~
