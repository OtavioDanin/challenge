# Challange BACKEND PHP

Este projeto é uma API Rest construída com **PHP, Hyperf Framework, PostgreSQL como o Banco de Dados.** 
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


## No que o desafio consiste

Desafio propoe em criar um mini sistema de transfêrencias montária entre dois usuários.

## Requisitos definidos

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema.

* Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

- Lojistas só recebem transferências, não enviam dinheiro para ninguém.

* Validar se o usuário tem saldo antes da transferência.

- Validar o serviço autorizador externo.

* Em casso de erro tudo deve ser revertido, ou seja, o dinheiro voltar para a conta de origem.

- Ao finalizar trânferencia o lojista ou usuário deve receber uma notificação.

## Modelagem de dados

```markdown
# Tabela: users

| Coluna      | Tipo          | Constraint
|-------------|---------------|-------------
| id          | UUID          | PK
| name        | VARCHAR       |
| identity_document  | VARCHAR       | UNIQUE
| email       | VARCHAR       | UNIQUE
| password    | VARCHAR       |
| user_type   | VARCHAR       |

# Tabela: wallets

| Coluna      | Tipo          | Constraint
|-------------|---------------|----------
| id          | UUID          | PK      
| user_id     | UUID          | FK (users.id)  
| balance     | DOUBLE        |

# Tabela: transfers

| Coluna         | Tipo          | Constraint
|----------------|---------------|----------
| id             | UUID          | PK      
| wallet_id      | UUID          | FK (wallets.id)
| type           | UUID          | 
| value          | integer       | 

# Tabela: transactions

| Coluna      | Tipo          | Constraint
|-------------|---------------|----------
| id          | UUID          | PK      
| sender      | UUID          | FK (transfers.id)
| receiver    | UUID          | FK (transfers.id)

## API Endpoints
The API provides the following endpoints:

**GET USERS**
```markdown
GET /users - Retrieve a list of all users.
```
```json
[
    {
        "id": 1,
        "firstName": "Pedro",
        "lastName": "Silva",
        "document": "123456787",
        "email": "pedro@example.com",
        "password": "senha",
        "balance": 20.00,
        "userType": "MERCHANT"
    },
    {
        "id": 4,
        "firstName": "Luckas",
        "lastName": "Silva",
        "document": "123456783",
        "email": "luckas@example.com",
        "password": "senha",
        "balance": 0.00,
        "userType": "COMMON"
    }
]
```

**POST USERS**
```markdown
POST /users - Register a new user into the App
```
```json
{
    "firstName": "Lucas",
    "lastName": "Silva",
    "password": "senha",
    "document": "123456783",
    "email": "lucas@example.com",
    "userType": "COMMON",
    "balance": 10
}
```

