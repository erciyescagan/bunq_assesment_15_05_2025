
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
# bunq_assesment_15_05_2025
