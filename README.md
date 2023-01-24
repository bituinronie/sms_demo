# SPCF SMS

## Setup Project
Make a copy of `.env` using the file `env.example` and then add your MySQL database credentials to establish a connection.

```
DB_CONNECTION=mysql
DB_HOST=<database host>
DB_PORT=<database port>
DB_DATABASE=<database name>
DB_USERNAME=<database username>
DB_PASSWORD=<database password>
```


After setting up the `.env` run the following commands:
```bash
# Install package dependencies 
$ composer install
$ npm i

# Generate the APP_KEY and JWT_SECRET
$ php artisan key:generate
$ php artisan jwt:secret

# Clear all composer's cache directories, Update Autoloader and Remove the cached bootstrap files
$ composer clear
$ composer dump-autoload
$ php artisan optimize:clear

# Create the symbolic links configured for the application
$ php artisan storage:link

# Drop all tables and re-run all migrations with seeders
$ php artisan migrate:fresh --seed

# Start the server
$ npm run watch
$ php artisan serve
```

## Understanding the repository
|Branch        		                       |Description                                                                                       |
|:----------------------------------------:|:------------------------------------------------------------------------------------------------:|
|`_Production`                             |The default branch; This branch will receive pull request and used for deployment of the system.  |
|`_Azure`                                  |This branch is used for azure deployment                                                          |
|`_Staging`                                |This branch will used for staging and for testing of the system.                                  |
|`hotfix-production`                       |This branch will used to fix bugs and changes in production released.                             |
|`hotfix-azure`                            |This branch will used to fix bugs and changes in azure released.                                  |
|`develop`                                 |This branch will have the latest changes.                                                         |


## Commits 
To be able for us to easily track our repository progress please use appropriate emojis at the start of description/message and issue-number at the end to determine type of commit.

| Illustration              | Code                          | Description                                   |
|:-------------------------:|:-----------------------------:|:---------------------------------------------:|
|:100:                      |`:100:`                        |Functions, routes, migrations etc.             |
|:wrench:                   |`:wrench:`                     |Add Some Code, Improve Code Struture or Format |
|:bug:                      |`:bug:`                        |Bug Fixed                                      |
|:bookmark_tabs:            |`:bookmark_tabs:`              |Add or Edit Comments in your code              |
|:coffee:                   |`:coffee:`                     |Initial or Non-important changes               |
|:construction:             |`:construction:`               |Work in Progress                               |
|:wastebasket:              |`:wastebasket:`                |Remove Code and Files                          |
|:notebook:                 |`:notebook:`                   |Documentation and ReadMe                       |
|:pencil2:                  |`:pencil2:`                    |Fix Typos, Rename Files, Routes etc            |
|:recycle:                  |`:recycle:`                    |Refactor Code                                  |
|:twisted_rightwards_arrows:|`:twisted_rightwards_arrows:`  |Merge Branches                                 |
|:rewind:                   |`:rewind:`                     |Revert Changes                                 |
|:iphone:                   |`:iphone:`                     |Work on Responsive Design                      |
|:pushpin:                  |`:pushpin:`                    |Hotfix                                         |
|:hash:                     |`#100`                         |Issue number                                   |
|(version-tag)              |`(v1.2.3-alpha)`               |Hotfix commits Version Tag                     |


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

The VueJs is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
