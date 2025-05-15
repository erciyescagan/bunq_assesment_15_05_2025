# Bunq Assessment Project

## 📖 Proje Hakkında

Bu proje, bir kullanıcı-grup-mesaj yönetim sistemi geliştirmek için oluşturulmuştur. Kullanıcılar gruplara katılabilir, gruplar içinde mesaj gönderebilir ve mesajları görüntüleyebilir. Proje, **PHP** ve **PDO** kullanılarak geliştirilmiş olup, temiz kod prensiplerine uygun bir yapı sunar.

---

## 🚀 Özellikler

- Kullanıcıların gruplara katılması ve gruplardan ayrılması.
- Gruplar içinde mesaj gönderme ve görüntüleme.
- RESTful API standartlarına uygun bir yapı.
- Dinamik sorgu oluşturma ve ilişkisel veritabanı yönetimi.
- Hata yönetimi ve veri doğrulama.

---

## 🛠️ Teknolojiler

- **PHP 8.1+**
- **PDO** (PHP Data Objects)
- **SQLite** (veya başka bir veritabanı)
- **Composer** (bağımlılık yönetimi)

---

## 📂 Proje Yapısı

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
