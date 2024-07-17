
# admin_system

This project is a user project management system built with Laravel API and Vue.js (with Vuex). It allows for the management of users and projects with role-based permissions. Admins can perform CRUD operations on users and projects, and receive notifications via email and Laravel Echo Pusher when project status changes.

## Screenshots
**Login**
![Screenshot 1](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/signin.png)
**dashboard**
![Screenshot 2](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/dashboard.png)
**Projects**
![Screenshot 3](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/projects.png)
**Search**
![Screenshot 4](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/search.png)
**Add Project**
![Screenshot 5](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/addproject.png)
**Users**
![Screenshot 6](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/usersliste.png)
**Push Notifications**
![Screenshot 6](https://github.com/Rokaya-mk/admin_system/blob/main/administration-system-frontend/public/img/notifications.png)
## Features

- **Roles Managment**: Two user roles; Admin and User
- **Role-based permissions managed through seeder.**
- **Admin can create, read, update, and delete users and projects.**
- **Email notifications**:  using queue and Mailtrap server and real-time notifications 
- **real-time notifications** :using Laravel Echo Pusher for assigned users when a project is added or updated.
- **Admin dashboard**: using Chart.js graph for displaying task statuses.
-**Unit and integration tests** : test project insertion and displaying data.
- **Secure Authentication**: Utilizes Laravel's passport authentication system for secure user login and management.
- **API documentation**: with Postman.

## Installation Steps

### Prerequisites

- PHP >= 7.4
- Composer
- Node.js and npm
- MySQL or any other supported database
- Redis (for queues)
- Mailtrap account (for email testing)


## Technologies Used

- **Frontend**: Vue.js, Vuex, Bootstrap
- **Backend**: Laravel
- **Database**: MySQL

## Installation

1. Clone the repository:

```bash
git https://github.com/Rokaya-mk/admin_system.git
```

2. Navigate to the project directory:

```bash
cd admin_system
```

3. Install dependencies for both frontend and backend:

```bash
# Frontend
cd administration-system-frontend
npm install

# Backend
cd administration-system-backend
composer install
```

4. Configure the backend environment:

   - Copy the `.env.example` file to `.env`.
   - Update the database connection details in `.env`.
   - Generate a new application key:

   ```bash
   php artisan key:generate
   ```

5. Migrate and seed the database:

```bash
php artisan migrate --seed
```

6. Set up Mailtrap in the .env file:

```bash
   env
   Copier le code
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=null
```

7.Set up Pusher in the .env file:
```bash
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_cluster
```
8.Serve the application:
```bash
# Frontend
npm run serve

# Backend
php artisan serve
php artisan queue:work
```

7. Access the application in your browser:

```
http://localhost:8080
```
9.API Documentation :
https://documenter.getpostman.com/view/14550205/2sA3kSm2pS
