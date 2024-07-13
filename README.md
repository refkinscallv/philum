<p align="center" style="margin: 20px auto">
  <img src="https://philum.callvgroup.net/images/philum_logo.png" height="150">
</p>

# Philum - PHP Framework MVC

Traditional PHP Framework with MVC Architecture, Routing and Query Builder

## Key Features

- MVC architecture
- Routing capabilities
- MySQL query builder for database operations
- Common utility functions
- Encrypted cookie support
- Cryptographic security encryption
- Request handling and sanitization for POST, GET, REQUEST, and SERVER variables

To set up your PHP Framework MVC with Composer and start building your web application, follow these detailed steps:

## Installation

### Composer Install

```bash
composer create-project refkinscallv/philum project-root
cd project-root
```

### Clone

First, clone the repository or download the source code to your local machine.

```bash
git clone https://github.com/refkinscallv/philum.git
cd philum
```

### Composer Platform Configuration For PHP Version

In the `composer.json` file, adjust the PHP platform config according to the PHP version you are using.

```json
{
    "config": {
        "platform": {
            "php": "7.4"
        }
    }
}

```

### Build Project

Build the project foundation. Installing dependencies, generating configuration files and generating the initial structure

```bash
php cli/build
```

### Environment Configuration

Edit the `.env` file with your preferred text editor:

```plaintext
# ENVIRONMENT
#--------------------------------------------------------------------

ENVIRONMENT             = "development" # Set to 'development' or 'production'

# APP
#--------------------------------------------------------------------

APP_NAME                = "Philum"  # The name of your application
BASE_URL                = "http://localhost/"   # The base URL of your application

# DATABASE
#--------------------------------------------------------------------

DB_STATUS               = 0 # Database activation status
DB_HOST                 = "localhost"   # Database host
DB_USER                 = "root"    # Database username
DB_PASS                 = ""    # Database password
DB_NAME                 = ""    # Database name
DB_DRIVER               = "MySQLi"    # Database driver
DB_PORT                 = 0    # Database port

# ENCRYPTION
#--------------------------------------------------------------------
# CRYPT_SECRET_KEY        = Secret key used for encryption
# CRYPT_FILE              = File path to store encrypted data
# CRYPT_LIMIT_LINE        = Maximum number of lines to encrypt in 
#                           general.txt and cookie.txt
# CRYPT_CIPHER_ALGO       = Encryption algorithm (AES-256-CBC)
# CRYPT_STORAGE_METHOD    = Storage method ('local' or 'database')
#
# NOTE : When CRYPT_STORAGE_METHOD is set to 'database', encrypted 
# data will be stored according to the format specified 
# in systems/Security/crypto.sql.
#--------------------------------------------------------------------

CRYPT_SECRET_KEY        = "PhilumSecretKey#9283749987"
CRYPT_FILE              = "/storage/crypto/general.txt"
CRYPT_LIMIT_LINE        = 500000    # Maximum number of lines to encrypt in general.txt and cookie.txt
CRYPT_CIPHER_ALGO       = "AES-256-CBC"
CRYPT_STORAGE_METHOD    = "local"

# COOKIE
#--------------------------------------------------------------------
# COOKIE_NAME             = Name of the cookie
# COOKIE_EXPIRE           = Cookie expiration time (hours)
# COOKIE_FILE             = File path to store cookie data
#
# NOTE : If CRYPT_STORAGE_METHOD is set to 'database', encrypted 
# data will be stored in the database as per the format specified 
# in systems/Security/crypto.sql.
#--------------------------------------------------------------------

COOKIE_NAME             = "philum_cookie"
COOKIE_EXPIRE           = 48
COOKIE_FILE             = "/storage/crypto/cookie.txt"
```