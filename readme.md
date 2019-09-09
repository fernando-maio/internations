#Application Steps:
<br>
<br>
Run composer;
<br>
Give permissions in storage and bootstrap/cache;
<br>
Run migrations;
<br>
Run DB Seeds;
<br>
User Default: maio.fernando@gmail.com
<br>
Password: Inter@2019
<br>
<br>
#.env DB Config:
<br>
DB_CONNECTION=mysql
<br>
DB_HOST=127.0.0.1
<br>
DB_PORT=3306
<br>
DB_DATABASE=internations
<br>
DB_USERNAME=internations
<br>
DB_PASSWORD=Inter@2019
<br>
Test Database: sqlite
<br>
<br>
#Observations:
<br>
On this project, I'd used: PHP 7.3, MySQL, Laravel 6.0, Blade with Bootstrap 4 for layout and Laravel Validations.
<br>
I's created 3 user profiles, Master, Admin and User. Master and Admin can create, update or remove groups or users.
<br>
An admin user can't remove other admin. They can insert, edit or remove user with profile as "user", and groups.
<br>
A group can't be removed if they have users associated.
<br>
Masters users have full access to remove all other users.
<br>
The user created by the seeder is the only one with master privileges. This user can be removed by other user.
<br>
<br>
Time of development approx: 8 hours in total.
<br>
<br>
<br>
#Thank you for the opportunity!