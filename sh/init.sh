#!/usr/bin/env bash

mkdir web/images/resized
chmod -R 777 web/assets
chmod -R 777 web/images
chmod -R 777 runtime
cd vendor
ln -s bower-asset bower
cd ..
php init.php
./yii deploy/check