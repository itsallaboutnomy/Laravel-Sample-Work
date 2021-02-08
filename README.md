###Teknasyon PHP Challenge
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
