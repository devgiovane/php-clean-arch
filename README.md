<img src="./php.png" width="80" height="80" alt="logo">

# PHP Clean Architecture

### About

> Project that registers a user and sends an email with registration PDF, for clean arch and DDD studies.

### Concepts:

- Clean Architecture
- Domain Driven Designer 
- Single Responsibility Principle
- Data Transfer Object
- Adapter, Presenter 

### Commands

```bash
composer install # install composer dependencies
docker-compose up -d # start docker containers
```

```text
POST - /api/v1/registration/register
body {
    cpf: string
}
```

```text
POST - /api/v1/registration/email
body {
    cpf: string
}
```

### Create by
© [Giovane Santos](https://giovanesantossilva.github.io/)
