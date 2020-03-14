# Bossabox Desafio Backend Vuttr

Desafio feito para a Bossabox utilizando as ferramentas: Laravel, Laradock e Mysql

### Laradock

O Ambiente é montado utlizando o laradock
[Laradock](https://laradock.io/)

### Baixando o Projeto

```
    git clone git@github.com:huandersonmachado/bossabox_backend_challenge.git
```

### Subindo a Aplicação

Após baixar o projeto o laradock é inclúido como submodulo, para configuração da porta da aplicação e banco de dados acesse a pasta laradock/ e copie o arquivo **env-example** para .env e mude as seguintes configurações;

```
MYSQL_DATABASE=bossabox
MYSQL_USER=bossabox
MYSQL_PASSWORD=bossabox_challenge
MYSQL_PORT=3306
MYSQL_ROOT_PASSWORD=root

NGINX_HOST_HTTP_PORT=3000
```

Após configurar basta iniciar os containers ainda dentro da pasta laradock/

```
    docker-compose up -d nginx mysql
```

### Utilizando o PHP nos containers

Para utilizar os comandos listados abaixo basta entrar no container workspace criado por padrão pelo laradock

```
    docker-compose exec --user=laradock workspace bash
```

### Criar o arquivo .env Laravel

Dentro do container Copie o arquivo .env.example para .env logo em seguinda execute o artisan para criar a chave da aplicação, lembre-se de configurar as chaves com os valores respectivos configurados no .env do laradock

```
    php artisan key:genarate
```

### Instalar as dependências

Para Instalar as dependências dos projeto basta rodar o composer

```
    composer install
```

### Executar os Testes

```
    php artisan test
```
