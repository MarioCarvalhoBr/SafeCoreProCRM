# SafeCorePro CRM 🏥

O **SafeCorePro CRM** é uma plataforma robusta de gestão clínica (SaaS) desenvolvida em Laravel. O sistema oferece gestão de pacientes, prontuários eletrônicos, agendamentos, portal de autoatendimento para pacientes e um módulo financeiro completo com geração de recibos em PDF.

## 🚀 Guia de Instalação Rápida (Cold Start)

Siga estes passos para configurar o ambiente do zero após clonar o repositório ou resetar a base de dados.

### 1. Requisitos do Sistema
* PHP 8.2 ou superior
* MySQL 8.0+
* Composer
* Node.js & NPM

### 2. Configuração do Banco de Dados
Crie a base de dados manualmente no seu servidor MySQL (ex: via phpMyAdmin ou Terminal):

```sql
CREATE DATABASE safecorepro_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

```

### 3. Configuração do Ambiente (.env)

1. Copie o arquivo de exemplo:
```bash
cp .env.example .env

```


2. Abra o `.env` e configure as credenciais do banco:
```env
APP_NAME="SafeCorePro CRM"
APP_URL=http://localhost/SafeCoreProCRM/SafeCoreProCRM/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=safecorepro_crm
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

```



### 4. Instalação de Dependências e Chave

```bash
# Instalar dependências do PHP
composer install

# Instalar dependências de Front-end
npm install && npm run build

# Gerar chave da aplicação
php artisan key:generate

```

### 5. Migrações e Permissões (RBAC)

Execute as migrações para criar as tabelas e os cargos iniciais (Roles):

```bash
php artisan migrate

```

### 6. Migrações e População (Escolha uma Opção)

Para acessar o sistema pela primeira vez, utilize o comando interativo (Tinker) para criar o usuário e atribuir a Role de Admin:

#### Opção A: Via Seeder (Recomendado/Automático)
Executa as tabelas e já cria as Roles e o Admin inicial automaticamente.
```bash
php artisan migrate --seed --seeder=RolesAndPermissionsSeeder
```
*   **Login:** `admin@safecoreprocrm.com`
*   **Senha:** `senha123`

#### Opção B: Via Tinker (Manual)
Se preferir criar um admin com dados personalizados via terminal:
```bash
php artisan migrate
php artisan tinker
```
Dentro do Tinker:
```php
$user = App\Models\User::create(['name'=>'Admin','email'=>'seu@email.com','password'=>Hash::make('sua_senha')]);
$roles = ['Admin', 'Doctor', 'Receptionist', 'Patient'];
foreach($roles as $r) { Spatie\Permission\Models\Role::create(['name'=>$r]); }
$user->assignRole('Admin');
```

####  Opção C: Modo de DESENVOLVIMENTO (CUIDADO): Popular o banco com dados de teste (Faker): 
```bash
    php artisan migrate:fresh --seed --seeder=RolesAndPermissionsSeeder
    php artisan db:seed --class=FakeDataSeeder
```


### 7. Comandos Úteis
* **Limpar Cache de Permissões:** `php artisan permission:cache-reset`
* **Limpar Views:** `php artisan view:clear`

### 8. Acesso ao Projeto

O projeto está configurado para rodar em:
`http://localhost/SafeCoreProCRM/SafeCoreProCRM/public`

---

## 🛠 Funcionalidades Implementadas

* **Multitenancy de Usuários:** Separação rígida entre Admin, Médicos, Recepcionistas e Pacientes.
* **Portal do Paciente:** Agendamento self-service e histórico de consultas.
* **Módulo Financeiro:** Gestão de pagamentos e emissão de recibos em PDF.
* **Prontuário Digital:** Upload de exames e registro de histórico médico.
* **Interface Moderna:** Sidebar dinâmica (Drawer), Dark Mode e suporte Multi-idioma (i18n).

## 📄 Licença

Distribuído sob a licença **MIT**. Veja `LICENSE` para mais informações.

## ✉️ Contato

**Mário Carvalho** - [mariodearaujocarvalho@gmail.com](mailto:mariodearaujocarvalho@gmail.com)
