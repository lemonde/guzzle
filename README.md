Guzzle, PHP HTTP client and webservice framework
================================================

Version forkée de [Guzzle](https://github.com/guzzle/guzzle) pour faire cohabiter deux versions différentes de Guzzle.

Cette version se base sur la version 3.8.1 de Guzzle et peut être utilisée en ajoutant le namespace `Lmd` en préfixe des namespace de Guzzle. Par exemple :

```php
$client = new \Lmd\Guzzle\Http\Client();
```

**ATTENTION**

Il faut absolument que la branche indiquée comme celle par défaut sur github contienne le nom modifié du package dans le composer.json car composer se sert de la branche par défaut pour lire les informations de base du package (peu importe la release demandée).

Pour utiliser la version modifiée, il faut indiquer la version `v3.8.1-lmd` dans la liste require de composer.
