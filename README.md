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

```
## Endpoints
A API fronece os seguintes endpoints:

**POST USUARIO**
```markdown
POST /user/create - Registar um novo usuário na aplicação
```
```json
{
    "name": "Luiz",
    "identifier": "85027263074",
    "email": "luiz@email.com",
    "password": "123456",
    "user_type": "COMMON"
}
```
**POST TRANSFERENCIA**
```markdown
POST /tranfer/create - Registar uma nova transação entre utilizadores(user_type: COMMON ou MERCHANT)
```

```json
{
  "senderId": "018df6d7-3080-718b-a06a-08d880903075",
  "receiverId": "018ded7d-0282-70f5-9c49-297b47b865e1",
  "value": "10"
}
```

## Proposta de melhorias
-  Delegar a um serviço externo de fila de mensageria o envio das notificações