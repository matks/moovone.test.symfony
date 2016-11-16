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
    "count":"3"
    "data":[
        {"id":0,"name":"Harry Potter et la chambre des secrets"},
        {"id":0,"name":"Fast and Furious 8"},
        {"id":0,"name":"Taken 3"}        
    ]
}
```


### Lancer l'application

Nous vous avons pré-configuré un simple projet symfony pour vos développement.

astuce : 

- Tester votre API avec PostMan ou Rest API Tester de PhpStorm

Pour lancer le server nodeJS : 

```
php bin/console server:run
```

Votre application est accessible à l'adressse `http://localhost:8000`.

