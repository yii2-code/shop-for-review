### запуск
```bash
cp .env.dist .env

docker-compose up -d
docker-compose exec php php ./composer.phar global require "fxp/composer-asset-plugin:^1.2.0"
docker-compose exec php php ./composer.phar config --global github-oauth.github.com 'enter your github token'
docker-compose exec php php ./composer.phar update
```

Добавить

/etc/hosts
```
172.73.251.2 shop.app
172.73.251.2 cp.shop.app
172.73.251.2 static.shop.app
172.73.251.2 api.shop.app
``` 


### миграция
```bash
docker-compose exec php ./yii migrate/up
```

### создание админа
```bash
docker-compose exec php php ./composer.phar admin
```

### тесты
```bash
docker-compose exec php ./yii_test migrate/up
docker-compose exec php ./vendor/bin/codecept run
```

### фикстуры
```bash
docker-compose exec php ./yii fixture/load Brand
docker-compose exec php ./yii fixture/load Category
docker-compose exec php ./yii fixture/generate product --count=10
docker-compose exec php ./yii fixture/load Image # может занять несколько минут
```

### папка shop бизнес модель