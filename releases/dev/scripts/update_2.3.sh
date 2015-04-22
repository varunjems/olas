#!/bin/bash

SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"

cd $DIR
cd ..

# Install Composer
if [ ! -x composer.phar ]; then
  php -r "readfile('https://getcomposer.org/installer');" | php
else
  ./composer.phar self-update
fi

# Install vendors
./composer.phar install

# Migrate the database
./symfony doctrine:migrate
