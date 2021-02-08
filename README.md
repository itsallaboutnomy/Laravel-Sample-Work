# Teknasyon PHP Challenge
---
#####Technical Specifications
- PHP Version 7.4
- MySQL Version 5.7
- Laravel Framework Version 8
---
##Instructions
- Config host
- Checkout master branch
- Setup DB (DB schema is in Schema directory on root)
- Make following changes in .evn file

```
DB_DATABASE=<db_name>
APP_URL=<host_url>
OS_APPLE=iOS;
OS_APPLE=GOOGLE;

APPLE_VERIFY_URL=<host_url>/api/mock/ios
GOOGLE_VERIFY_URL=<host_url>/api/mock/google

APPLE_VERIFY_SUBS_URL=<host_url>/api/mock/verify-subs-ios
GOOGLE_VERIFY_SUBS_URL=<host_url>/api/mock/verify-subs-google

THIRD_PARTY_ENDPOINT=<host_url>/api/mock/third-party-endpoint

MAX_RATE_LIMIT=1000

MAX_RATE_LIMIT_ERROR_CODE=429
```
#####Alternatively you can copy .env.example contents into .env file

---

##Routes
- Following is the routing list:

- <a href="https://ibb.co/3s6XHSb"><img src="https://i.ibb.co/9vKXjy0/Screenshot-2021-02-08-at-6-15-05-PM.png" alt="Screenshot-2021-02-08-at-6-15-05-PM" border="0"></a>
- **apps** group contains purchase and subscription APIs routes.
- **devices** group contains register API route.
- **mock** group contains iOS, GOOGLE, and third-party endpoints mocking APIs routes.
- **report** group contains report API route.

---

##Testing
**Inserting test data in db tables.**
- After steping up host, setting up db, and import db schema run following command:
```php artisan db:seed
```
- It will insert 20, 40, and 40 records into `applications`, `devices`, and `subscriptions` table respectively.
- Alternatively can  run the following commands:
```php artisan tinker
    \App\Models\Application::factory()->count(20)->create()
    \App\Models\Device::factory()->count(20)->create()
	\App\Models\Subscription::factory()->count(20)->create()
```
**Count value for Subscription and Device should be same**


---

# Teknasyon PHP Challenge
---
#####Technical Specifications
- PHP Version 7.4
- MySQL Version 5.7
- Laravel Framework Version 8
---
##Instructions
- Config host
- Checkout master branch
- Setup DB (DB schema is in Schema directory on root)
- Make following changes in .evn file

```
DB_DATABASE=<db_name>
APP_URL=<host_url>
OS_APPLE=iOS;
OS_APPLE=GOOGLE;

APPLE_VERIFY_URL=<host_url>/api/mock/ios
GOOGLE_VERIFY_URL=<host_url>/api/mock/google

APPLE_VERIFY_SUBS_URL=<host_url>/api/mock/verify-subs-ios
GOOGLE_VERIFY_SUBS_URL=<host_url>/api/mock/verify-subs-google

THIRD_PARTY_ENDPOINT=<host_url>/api/mock/third-party-endpoint

MAX_RATE_LIMIT=1000

MAX_RATE_LIMIT_ERROR_CODE=429
```
#####Alternatively you can copy .env.example contents into .env file

---

##Routes
- Following is the routing list:

- <a href="https://ibb.co/3s6XHSb"><img src="https://i.ibb.co/9vKXjy0/Screenshot-2021-02-08-at-6-15-05-PM.png" alt="Screenshot-2021-02-08-at-6-15-05-PM" border="0"></a>
- **apps** group contains purchase and subscription APIs routes.
- **devices** group contains register API route.
- **mock** group contains iOS, GOOGLE, and third-party endpoints mocking APIs routes.
- **report** group contains report API route.

---

##Testing
**Inserting test data in db tables.**
- After steping up host, setting up db, and import db schema run following command:

```php
 php artisan db:seed
```
- It will insert 20, 40, and 40 records into `applications`, `devices`, and `subscriptions` table respectively.
- Alternatively can  run the following commands:

```php
php artisan tinker
\App\Models\Application::factory()->count(20)->create()
\App\Models\Device::factory()->count(20)->create()
\App\Models\Subscription::factory()->count(20)->create()
```
**Count value for Subscription and Device should be same**

---

#Worker
---

- For subscription verification following artisan command can be added to cron or server-side triggers.
```php
php artisan verify:subscription
```
#Reporting
---
- Reporting API will return data in json format.
