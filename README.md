# kraken-api

Checkout branch master or develop

Modify .env.local DATABASE_URL

Execute these commands:

  composer install
  
  symfony console doctrine:database:create
  
  symfony console doctrine:schema:create
  
  symfony console app:init-power
  
  symfony server:start
