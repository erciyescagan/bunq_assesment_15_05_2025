# Bunq Chat Application Assessment
## bunq_assesment_15_05_2025

This project was developed as part of the bunq application process. It allows users to join groups and send messages within those groups.

---

## Tech Stack

- **PHP 8.4.6+**
- **PDO** 
- **SQLite** 
- **Composer**

---

## Structure

```plaintext
src/
├── core/
│   ├── classes/
|   |     └──connections/
|   |         └──SQLite.php    
│   │   ├── Connection.php
│   │   ├── Controller.php
│   │   ├── Migrate.php
│   │   ├── Repository.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   └── Service.php
│   └── interfaces/
│       ├── ConnectionInterface.php
│       ├── ControllerInterface.php
│       ├── RepositoryInterface.php
│       ├── RequestInterface.php
│       ├── ResponseInterface.php
│       └── ServiceInterface.php
├── database/
|    ├── migrations
|    |   ├── 001_create_users_table.php
|    |   ├── 002_create_groups_table.php
|    |   ├── 003_create_group_user_table.php
|    |   └── 004_create_message_table.php
|    └── migrate.php
├── http/
│   ├── controllers/
│   │   ├── GroupController.php
│   │   ├── MessageController.php
│   │   ├── UserController.php
│   │   └── UserGroupController.php
│   ├── requests/
│   └── responses/
├── public/
|   ├──routes/
|   |   ├── api.php
|   |   ├── group_routes.php
|   |   ├── group_user_routes.php
|   |   ├── message_routes.php
|   |   └── user_routes.php    
│   ├── .htaccess
│   └── database.sqlite
├── repositories/
│   ├── GroupRepository.php
│   ├── MessageRepository.php
│   ├── UserGroupRepository.php
│   └── UserRepository.php
├── services/
|   ├── GroupService.php
|   ├── MessageService.php
|   ├── UserGroupService.php
|   └── UserService.php
├── vendor/
├── .env.example
├── composer.json
└── Readme.md
```

## Installation

### Clone repository
```
git clone https://github.com/erciyescagan/bunq_assesment_15_05_2025.git
```
### Install composer

```
composer install 
```

### Copy .env.example in .env

```
mv .env.example .env
```

### Migrate database


```
php src/database/migrate.php
```
### Run server

```
php -S localhost:8000 -t src/public
```

## API Documentation

### Group Routes

```
curl -X POST http://localhost/api/v1/groups \
-H "Content-Type: application/json" \
-d '{
    "name": "New Group"
}'
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": {
        "id": 9,
        "name": "test",
        "created_at": "2025-05-15 18:00:44"
    }
}
```

```
curl -X GET http://localhost/api/v1/groups
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "name": "group",
            "created_at": "2025-05-15 17:36:48"
        }
    ]
}
```

```
curl -X GET http://localhost/api/v1/groups/{id}

```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": {
        "id": 1,
        "name": "group",
        "created_at": "2025-05-15 17:36:48"
    }
}
```

```
curl -X DELETE http://localhost/api/v1/groups/{id}
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": {
        "message": "Data id : 1 has been deleted"
    }
}
```

```
curl -X GET http://localhost/api/v1/groups/{groupId}/users
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        {
            "group_id": 2,
            "group_name": "group",
            "created_at": "2025-05-15 17:46:23",
            "user_id": 1,
            "username": "erciyescagan"
        }
    ]
}
```

### Group Authentication Routes

```
curl -X POST http://localhost/api/v1/groups/{groupId}/users \
-H "Content-Type: application/json" \
-d '{
    "user_id": 123
}'
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        true
    ]
}
```

```
curl -X DELETE http://localhost/api/v1/groups/{groupId}/users/{userId}
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        true
    ]
}
```

### Message Routes

```
curl -X POST http://localhost/api/v1/messages \
-H "Content-Type: application/json" \
-d '{
    "user_id": 123,
    "group_id": 1,
    "content": "Hello, this is a test message!"
}'
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": {
        "id": 1,
        "content": "Hello, this is a test message!",
        "user_id": 123,
        "group_id": 1,
        "created_at": "2025-05-15 18:27:08"
    }
}

```
curl -X GET http://localhost/api/v1/messages/group/{groupId}
```
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        [
            {
                "id": 3,
                "content": "Hello, this is a test message!",
                "user_id": 1,
                "group_id": 2,
                "created_at": "2025-05-15 18:29:38",
                "name": "group"
            }
        ]
    ]
}
```

```
curl -X GET http://localhost/api/v1/messages/user/{userId}
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        [
            {
                "id": 2,
                "content": "Hello, this is a test message!",
                "user_id": 1,
                "group_id": 1,
                "created_at": "2025-05-15 18:28:41",
                "username": "erciyescagan"
            },
            {
                "id": 3,
                "content": "Hello, this is a test message!",
                "user_id": 1,
                "group_id": 2,
                "created_at": "2025-05-15 18:29:38",
                "username": "erciyescagan"
            }
        ]
    ]
}
```

```
curl -X GET http://localhost/api/v1/messages/user/{userId}/group/{groupId}
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        [
            {
                "id": 3,
                "content": "Hello, this is a test message!",
                "user_id": 1,
                "group_id": 2,
                "created_at": "2025-05-15 18:29:38",
                "group_name": "group",
                "username": "erciyescagan"
            }
        ]
    ]
}
```

```
curl -X GET http://localhost/api/v1/messages
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "content": "Hello, this is a test message!",
            "user_id": 123,
            "group_id": 1,
            "created_at": "2025-05-15 18:27:08"
        },
        {
            "id": 2,
            "content": "Hello, this is a test message!",
            "user_id": 1,
            "group_id": 1,
            "created_at": "2025-05-15 18:28:41"
        },
        {
            "id": 3,
            "content": "Hello, this is a test message!",
            "user_id": 1,
            "group_id": 2,
            "created_at": "2025-05-15 18:29:38"
        }
    ]
}
```

```
curl -X DELETE http://localhost/api/v1/messages/{id}
```
```
{
    "status": {
        "success": true,
        "code": 200
    },
    "data": {
        "message": "Data id : 2 has been deleted"
    }
}
```


---
