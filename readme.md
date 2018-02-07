# MailCare

This is an open source disposable email address service that was built and maintained at mailcare.io.

## Installation

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone git@gitlab.com:mailcare/mailcare.git
cd mailcare && composer install && npm install
php artisan mailcare:install
npm run dev
```
