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
```php
php artisan tinker
$threads = factory('App\Thread', 50)->create();
$threads->each(function($thread){factory('App\Reply', 10)->create(['thread_id' => $thread->id]);});
```

## Aula 2

1. Criamos arquivo de teste
2. Atualizamos phpunit.xml setando sqlite
3. Criamos um modelo de autenticação (views)
    ```php
    php artisan make:auth
    ```
4. Criamos o acesso a lista de threads e a visualização de uma única. Criando também os testes.

## Aula 3

1. Podemos visualizar a lista de Replies de uma Thread
2. Criamos um teste de unidade para testar que cada resposta tem um autor
3. Fizemos a relação de autor com cada resposta