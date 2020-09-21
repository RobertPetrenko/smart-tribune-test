# smart-tribune-test
Smart Tribune - Backend - Coding Test

Instalation.

1. Clone or download repository 
https://github.com/RobertPetrenko/smart-tribune-test.git

2. Run composer install
$ composer install

3. Create .env.local in the root of the project
APP_ENV=dev
APP_SECRET=...
DATABASE_URL=mysql://user:pwd@server/questionanswer?serverVersion=...

4. Create database
$ php bin/console doctrine:database:create

5. Make migration
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate

6. To test the API use HTTP client

7. Here is an example of JSON 
{
  "title": "Answer title",
  "promoted": true,
  "status": "published",
  "answers": [
  	{
  		"channel": "bot",
  		"body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
  	}
  ]
}

8. To test POST use the route /question

9. To test PUT use the route /question/{id}