#WikiDeadlines

To Run the project you should have Docker and docker-compose installed on your server.
7. Run `./dc.sh exec app npm run dev`



To install the project you should have Docker and docker-compose installed on your server.

## How to start a development server?

1. Configure .env files. Every folder (including root folder) has `.env.example` file.
2. Run `./dc.sh build`
3. Run `./dc.sh up -d`
4. Run `./dc.sh exec app php composer.phar install`
5. Run `./dc.sh exec app php artisan migrate --seed` to run migrations and load initital data to DB
6. Run `./dc.sh exec app npm install`
7. Run `./dc.sh exec app npm run dev`


## How to start a production server?

1. Configure .env files. Every folder (including root folder) has `.env.example` file.
2. Run `./dc.sh build`
3. Run `./dc.sh up -d`
4. Run `./dc.sh exec app /bin/bash -c "service supervisor stop && service supervisor start && supervisorctl start laravel-worker:*"`

If you need, you can generate a key:
```
./dc.sh exec app php artisan key:generate
```

If you need, you can load initial data:
```
./dc.sh exec app php artisan migrate --seed
```

## How to update a production server?

1. Run `./dc.sh build`
2. Run `./dc.sh up -d`

## How to set up Stripe?
1. Put credentials into  `STRIPE_KEY`, `STRIPE_SECRET` and `STRIPE_WEBHOOK_SECRET` environment variables
2. Run `./dc.sh exec app php artisan payment:initialize`.
It will create a "per search" product and two subscription plans (monthly and yearly) with default prices
3. Configure webhooks in the [Webhooks' dashboard](https://dashboard.stripe.com/webhooks).
Webhook endpoint: `https://your.domain/stripe/webhook`.
Webhook events:
`customer.subscription.updated`
`customer.subscription.deleted`
`customer.subscription.created`
`customer.updated`
`customer.deleted` 

If you need to remove initialized payment data:
```
./dc.sh exec app php artisan payment:remove
```
**DISCLAIMER:** the command `payment:remove` will delete data only from the website's database. You will need to initialize them back in order to get Wikideadlines work properly

## Database backup
Currently, Wikideadlines application supports daily database backups to **Google Drive**. It uses **pg_dump** under **app** docker service.

To enable database backup set:
```
DATABASE_BACKUP_ENABLED=true
```

Then you need to set up **Google Drive** API credentials:

```
DB_GOOGLE_DRIVE_CLIENT_ID=
DB_GOOGLE_DRIVE_CLIENT_SECRET=
DB_GOOGLE_DRIVE_REFRESH_TOKEN=
DB_GOOGLE_DRIVE_FOLDER_ID=
```

OAuth 2.0 **client id** (`DB_GOOGLE_DRIVE_CLIENT_ID`) and **client secret**(`DB_GOOGLE_DRIVE_CLIENT_SECRET`) values can be get here: https://console.cloud.google.com/apis/credentials

Once you have **client id** and **secret id** you can get a **refresh token** (`DB_GOOGLE_DRIVE_REFRESH_TOKEN`) here (**Scope**: /auth/drive.file): https://developers.google.com/oauthplayground/ 

`DB_GOOGLE_DRIVE_FOLDER_ID` is used to set a folder id to which you would like to upload backups. Using browser, navigate to a desired folder and copy its id from URL.
For example for URL https://drive.google.com/drive/folders/1quSzx2_5nLNfNe5eTlNZOpOjQZZSMVj1 ID is 1quSzx2_5nLNfNe5eTlNZOpOjQZZSMVj1
