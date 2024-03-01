# Challange BACKEND PHP
![PHP](https://www.php.net/images/logos/new-php-logo.png)
![Hyperf Framework](https://hyperf.wiki/3.1/logo.png)
[![Licence]()](./LICENSE)

Este projeto é uma API Rest construída com **PHP, Hyperf Framework, PostgreSQL as the database.** 
### Pré-requisitos

* Docker
* Docker compose


### Instalação

Passo a passo para você rodar este projeto localmente:

* clone na sua máquina utilizando o git
* siga os comandos a baixo para subir a aplicação
```
$ cp .env.example .env
$ docker compose up -d
$ docker exec challenge composer install

Após isso a aplicação está disponível em [http://localhost:9501](http://localhost:9501)
