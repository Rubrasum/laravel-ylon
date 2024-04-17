# Laravel Ylon

tiny laravel site with form

## Installation instructions

- Clone the repo
- Update the env file with APP_BC and DB logins (Or just use mine).
- Start the sail instance from inside the repo's directory. You might not have sail in your PATH so you can use `./vendor/bin/sail up -d` from the directory as well.
    - `sail up -d`
    - `./vendor/bin/sail up -d`
    - OR `docker-compose up -d`. They're pretty similar but I have mostly used sail up and down.
- Use `sail root-shell` to enter the container (or just prepend the next few commands with "sail".)
    - `sail root-shell`
    - `composer install `
    - `php artisan key:generate`
    - `npm install`
    - `php artisan:migrate --seed` // Add --seed will seed the admin. This will cause an error if you import the sql dump I provided because the user row for admin will be duplicate.
    - `npm run dev`



You should now be able to login at `localhost/login`

- Username: josephbetbeze@gmail.com
- password: password

After running npm dev you should be able to see hot module replacement when you edit the views.



If you used my backup sql dump, you should see 2 users. If you only seeded, you should see a warning message.



## Lets build a Laravel App from Scratch (Notes)

Needs form with First, Last, Email and SSN

- Entry fields need to be in a single line that spans the width of the web browser
- and responsive

Admin

- URL for admin, login, registration

admin page people should be sortable by each field

- display all people

- sortable table.
- enable/disable people + validation prompt.



Git

- Make main and dev branch



Dev Environment

- Ubuntu 22.04 docker container using docker Compose configured as a typical LAMP stack.
- Basic Laravel instance
- mysql container
- container should run code locally from the repo so it can be edited in real time.



## Starting

Install Laravel for Repo start

​	`curl -s https://laravel.build/laravel-ylon | bash`



Setup the Repo

```
git init
git add .
git commit -m 'hi first commit'
# Make sure you have github CLI installed for next part)
# if not... on first setup....
gh auth login
#follow instructions to login with ssh or https
# push repo to gh
gh repo create laravel-ylon --public --source=.

```

Added phpmyadmin to the docker-compose

#### Install breeze

```
php artisan breeze:install
 
# and then do these generic startup steps
php artisan migrate
npm install
npm run dev
```

#### Updating User table with necessary columns

active (enabled) and admin toggles

**Created this alteration file**

`sail artisan make:migration alter_users_add_admin_and_active_columns_to_users_table --table=users`

**Migrations changed a lot from this, but this was the starting point. **

```
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin')->default(false);
            $table->boolean('enabled')->default(false); // has no effect on admin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin');
            $table->dropColumn('enabled');
        });
    }
};
```

### Tailwind NPM & Vite

Tailwind and Vite seem to act up sometime with this setup. The main problem is hmr doesn't work by default (at least in Windows WSL with Sail setup.) You need to add this line to vite config

```
,
hmr: {
    host: 'localhost',
},
```

as well as make sure all the files are correctly selected in tailwind config files. By default there should be no problems with the config files.

```
remember to update APP_KEY, DB and APP_BC values
```



## How would I make this better if I had more time - In Order

1. Update the Docker compose file to not rely on sail.
2. Captcha on the form.
3. Create a separate "submissions" table in db and reset Users table to original.
4. A full site layout.
5. Option to add other admin logins.
6. Analytics on the form.
7. Add a bit more session logic to prevent duplicate entries.
8. Allow the option to peak the decrypted SSN numbers.
9. Update user auth to Jetstream and build custom.
10. Modern frontend framework design, reactive components and SPA admin.



## (END NOTES
