# MoovOne test Symfony

L'ojectif de ce test est de réaliser une micro API.
Cette api devra retourner une liste de films via une liste de films.
- Vous devez, installer le bundle [FosRestBundle](http://symfony.com/doc/current/bundles/FOSRestBundle/index.html) et le configurer.
- Vous devez créer l'entité `movies`
- Créer la route qui retournera la liste des films au format JSON.

Voici le résultat voulu : 

`/api/v1/movies`

```
{
    "total":"30"
    "count":"3"
    "data":[
        {"id":0,"name":"Harry Potter et la chambre des secrets"},
        {"id":0,"name":"Fast and Furious 8"},
        {"id":0,"name":"Taken 3"}  
        [...]
    ]
}
```



### bonus : 

- il serait apprécié que vous ajoutiez les film via une fixture et que votre controller soit convert par un lot de test unitaires/fonctionnels
- il serait apprécié que la liste des films soit ordonable via le param "order" enum(name) et "dir" enum(asc|desc)
- il serait apprécié que la liste des films soit paginable avec un bundle comme PagerFanta 

### astuce : 

- Tester votre API avec PostMan ou Rest API Tester de PhpStorm

- Symfony contient un serveur de dev 

```
$ php bin/console server:run
```

Votre application est accessible à l'adressse `http://localhost:8000`.



