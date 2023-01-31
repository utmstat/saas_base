#!/usr/bin/env bash

./yii deploy/pre-processing
git reset --hard HEAD
git checkout master
git pull
chmod 777 yii
chmod -R 777 web/images
./yii migrate --interactive=0
./yii minify
rm -rf runtime/*
COMPOSER_ALLOW_SUPERUSER=1 composer install -vvv
#sudo ps aux | grep webhooks-raw-data-buffer/process | awk '{print $2}' | xargs kill -9
chmod -R 777 web/images
./yii deploy/post-processing