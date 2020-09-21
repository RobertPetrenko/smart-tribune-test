# Smart Tribune - Backend - Coding Test

## Setup

1. Clone this repository

 ```shell
 git clone git@github.com:RobertPetrenko/smart-tribune-test.git
 ```

2. Install dependencies

```shell
composer install
```

3. Create env file

Create a .env.local file in the root folder of the project and with these variables:

```dotenv
APP_ENV=dev
APP_SECRET=...
DATABASE_URL=mysql://user:password@host/questionanswer?serverVersion=...
```

4. Create the database

```shell
php bin/console doctrine:database:create
```

5. Create and execute the migration

```shell
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

6. Start the server

You can use Symfony web server for example or PHP built-in server.

## Usage

### Create a question with answers

```curl
POST /question
Content-Type: application/json
Accept: application/json
```

Content example:

```json
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
```

### Update the title of a question

```curl
PUT /question/{questionId}
Content-Type: application/json
Accept: application/json
```

Content example:

```json
{
  "title": "Updated title",
}
```
