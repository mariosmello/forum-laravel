# Forum Laravel

## Aula 1

Criamos o model, migration e controller para Thread e Reply.
Para criar um model com migration e controller
```php
php artisan make:model Thread -mr
```
Ajustamos as migrations conforme necessidade. 
Criamos um factory do Thread para popular o conteúdo.

Para rodar o factory
```
php artisan tinker
$threads = factory('App\Thread', 50)->create();
$threads->each(function($thread){factory('App\Reply', 10)->create(['thread_id' => $thread->id]);});
```
