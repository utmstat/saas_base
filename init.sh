#!/usr/bin/env bash

#sudo composer update -vvv

echo "<?php \n\n return [];" > config/db.local.php
echo "<?php \n\n return [];" > config/params.local.php

./yii migrate

mkdir web/images/resized
chmod -R 777 web/assets
chmod -R 777 web/images
chmod -R 777 runtime
cd vendor
ln -s bower-asset bower
cd ..
./yii monitoring