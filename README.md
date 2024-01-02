# Biblioteca
Criação e gerenciamento básico de Livros, Autores e Assuntos dentro de uma biblioteca.

## Requisitos
- Docker Compose 1.29.2
- Docker 24.0.2

## Tecnologias utilizadas no projeto
- Laravel 10
- PHP 8.3
- MySQL 8.0
- Nginx

## Passos para rodar o projeto

Caso não tenha instalado o docker e docker-compose no computador, a instalação pode ser feita seguindo o passo a passo nos links https://docs.docker.com/get-docker/ e https://docs.docker.com/compose/install/ seguindo os passos do seu sistema operacional.

Com o docker instalado, clonar este repositório na sua pasta de preferência executando no Terminal ou CMD o seguinte comando:

```console
git clone git@github.com:Edumatsu/bookstore-backend.git
```

Acessar o projeto:
```console
cd bookstore-backend
```

Copiar o .env.example para o .env do projeto:
```console
cp .env.example .env
```

É possível modificar o .env para trocar o banco de dados para um de sua preferência:
```console
DB_CONNECTION=mysql // trocar de banco de dados
DB_HOST=mysql // trocar o host (este host aponta para um container dentro do docker)
```

Subir o PHP, Nginx e MySQL executando o comando:
```console
docker-compose up -d
```

Para rodar os testes, acessar o container do php dentro do Docker:
```console
docker exec -it spassu-php /bin/bash
```

Estando dentro do container do php dentro do Docker, executar o seguinte comando:
```console
php artisan test
```