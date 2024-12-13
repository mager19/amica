echo "Checking dependencies"
which -s nvm
if [[ $? != 0 ]] ; then
  echo "Installing nvm"
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash

  if [[ $? != 0 ]] ; then
    echo "NVM did not install correctly, exiting the program.";
    exit;
  fi
fi
echo "✅ nvm"

which -s node
if [[ $? != 0 ]] ; then
  echo "Installing node"
  nvm install node
fi

if ! node -v | cut -d'v' -f2 | awk -F. '{if ($1 < 16 || ($1 == 16 && $2 < 14) || ($1 == 16 && $2 == 14 && $3 < 0)) exit 1}'; then
  echo "wrong version"
  nvm install 16.14.0
fi
echo "✅ node"

which -s brew
if [[ $? != 0 ]] ; then
    echo "Installing homebrew"
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
fi
echo "✅ brew"

which -s php
if [[ $? != 0 ]] ; then
  echo "Installing php"
  brew install php
fi
echo "✅ php"

which -s composer
if [[ $? != 0 ]] ; then
  echo "Installing composer"
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
  php composer-setup.php
  php -r "unlink('composer-setup.php');"
  sudo mv composer.phar /usr/local/bin/composer
fi
echo "✅ composer"

which -s yarn
if [[ $? != 0 ]] ; then
  echo "Installing yarn"
  brew install yarn
fi
echo "✅ yarn"

which -s trellis
if [[ $? != 0 ]] ; then
  echo "Installing trellis"
  brew install roots/tap/trellis-cli
fi
echo "✅ trellis"

which -s mysql
if [[ $? != 0 ]] ; then
  echo "Installing mysql"
  brew install mysql
  brew services start mysql
fi
echo "✅ mysql"

which -s python3
if [[ $? != 0 ]] ; then
  echo "Installing python"
  brew install python
fi
echo "✅ python"

which -s ansible
if [[ $? != 0 ]] ; then
  echo "Installing ansible"
  brew install ansible
fi
echo "✅ ansible"

if [[ $(uname -p) == 'arm' ]]; then
  echo "Checking M1 Chip Mac requirements"
  which -s valet
  if [[ $? != 0 ]] ; then
    echo "Installing valet"
    composer global require laravel/valet
    valet install
    php -r "copy('https://raw.githubusercontent.com/danielroe/trellis-valet-driver/master/TrellisValetDriver.php', 'TrellisValetDriver.php');"
    sudo mv TrellisValetDriver.php ~/.config/valet/Drivers
  fi
  echo "✅ valet"
else
  echo "Checking Pre-M1 Chip Mac requirements"
  which -s vagrant
  if [[ $? != 0 ]] ; then
    echo "Installing vagrant"
    brew install --cask vagrant
  fi
  echo "✅ vagrant"

  which -s virtualbox
  if [[ $? != 0 ]] ; then
    echo "Installing virtualbox"
    brew install --cask virtualbox
  fi
  echo "✅ virtualbox"
fi


echo "what is the primary domain? (e.g. swellinc.co)"
read domain
if [ "$domain" == '' ]
then
  echo "\nYou left domain blank, are you sure? \nLeave blank again for module library default, or e.g. swellinc.co"
  read domain

  if [ "$domain" == '' ]
  then
    domain="swell_library.org"
  fi
fi
domain_test=$(echo $domain | grep -Eo '^([^.]+)').test

echo "\nwhat is the name of the campaign? (e.g. Swell Inc.)"
read campaign
if [ "$campaign" == '' ]
then
  echo "\nYou left campaign blank, are you sure? \nLeave blank again for module library default, or e.g. Swell Inc."
  read campaign

  if [ "$campaign" == '' ]
  then
    campaign="Swell Module Library"
  fi
fi

echo "\nwhat should the theme directory be named?\n(No dashes! e.g. swell_library)"
read theme
if [ "$theme" == '' ]
then
  echo "\nYou left theme blank, are you sure? \nLeave blank again for module library default, or e.g. swell"
  read theme

  if [ "$theme" == '' ]
  then
    theme="swell_library"
  fi
fi

echo Creating $domain folder
cd .. && cp -r module-library $domain && cd $domain

root=$(pwd)
echo Working directory is: $root

echo "install trellis for $domain"
trellis new --name $domain --host $domain --force .

echo "Setup the environment file"
cp $root/site/.env.example $root/site/.env
sed -i "" "s/database_name/$theme/g" $root/site/.env
sed -i "" "s/database_user/root/g" $root/site/.env
sed -i "" "s/database_password//g" $root/site/.env
sed -i "" "s/example.com/$domain_test/g" $root/site/.env
sed -i "" "s/example.com/$domain_test/g" $root/site/.env
echo "\n\nWPMDB_LICENCE='af515690-a104-41e1-ae08-1b0454e24739'" >> $root/site/.env
echo "\nACF_PRO_KEY='b3JkZXJfaWQ9NTA5ODh8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE1LTAyLTI3IDIzOjI5OjU1'" >> $root/site/.env

trellis vault decrypt production && trellis vault decrypt staging
echo "\n      WPMDB_LICENCE: 'af515690-a104-41e1-ae08-1b0454e24739'" >> $root/trellis/group_vars/staging/vault.yml;
echo "\n      acf_pro_key: 'b3JkZXJfaWQ9NTA5ODh8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE1LTAyLTI3IDIzOjI5OjU1'" >> $root/trellis/group_vars/staging/vault.yml;
echo "\n      WPMDB_LICENCE: 'af515690-a104-41e1-ae08-1b0454e24739'" >> $root/trellis/group_vars/production/vault.yml
echo "\n      acf_pro_key: 'b3JkZXJfaWQ9NTA5ODh8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE1LTAyLTI3IDIzOjI5OjU1'" >> $root/trellis/group_vars/production/vault.yml
trellis vault encrypt production && trellis vault encrypt staging

echo "Setting local site to support https"
sed -i "" "s/\s\s\s\sssl:\n\s\s\s\s\s\senabled: false/\s\s\s\sssl:\n\s\s\s\s\s\senabled: true/g" $root/trellis/group_vars/development/wordpress_sites.yml

# change directory and create new sage theme
echo "cd to 'site/'"
cd $root/site

echo add ACF Package to composer
sed -i '' "/\"repositories\": \[/r $root/_starter/stubs/composer_package.txt" $root/site/composer.json
sed -i '' "/\"scripts\": {/r $root/_starter/stubs/composer_scripts.txt" $root/site/composer.json

composer update

echo "installing Kinsta MU Plugins"
composer require kinsta/kinsta-mu-plugins

echo "installing advanced custom fields pro"
composer require advanced-custom-fields/advanced-custom-fields-pro:6.2.7
composer config --no-plugins allow-plugins.ffraenz/private-composer-installer true

echo 'installing ACF Gravity Forms'
composer require wpackagist-plugin/acf-gravityforms-add-on

echo 'installing ACF Dropzone'
composer require wpackagist-plugin/acf-dropzone

echo "installing favicon generator"
composer require wpackagist-plugin/favicon-by-realfavicongenerator

echo "installing redirection"
composer require wpackagist-plugin/redirection

echo "installing SEO Framework"
composer require wpackagist-plugin/autodescription

echo "installing svg support"
composer require wpackagist-plugin/svg-support

echo "installing wp-migrate"
echo "WP Migrate API username:" && read wpmigrateu
echo "WP Migrate API password:" && read wpmigratepw
if [ "$wpmigrateu" == '' ]
then
  echo "\nYou left the API field blank, skipping migrate pro installation"
else
  rsync -aI $root/_starter/auth.json $root/site
  sed -i "" "s/web\/app\/mu-plugins\/\*\//web\/app\/mu-plugins\/**\/*/g" $root/site/.gitignore
  sed -i "" "s/{COMPOSER_API_USERNAME}/$wpmigrateu/g" $root/site/auth.json
  sed -i "" "s/{COMPOSER_API_PASSWORD}/$wpmigratepw/g" $root/site/auth.json

  composer require deliciousbrains-plugin/wp-migrate-db-pro
fi

echo "cd to themes directory"
cd $root/site/web/app/themes

# create new sage theme
composer create-project roots/sage $theme 10.6.0

echo "cd to $theme"
cd $root/site/web/app/themes/$theme

echo "Import template files"
rsync -aI $root/_starter/app $root/site/web/app/themes/$theme
rsync -aI $root/_starter/resources $root/site/web/app/themes/$theme
rsync -aI $root/_starter/index.php $root/site/web/app/themes/$theme
rsync -aI $root/_starter/tailwind.config.cjs $root/site/web/app/themes/$theme
rsync -aI $root/_starter/bud.config.js $root/site/web/app/themes/$theme
rsync -aI $root/_starter/package.json $root/site/web/app/themes/$theme
rsync -aI $root/_starter/module_library.php $root/site/web/app/mu-plugins/$theme.php
rsync -aI $root/_starter/uploads $root/site/web/app
rm $root/site/web/app/themes/$theme/tailwind.config.js
find ./resources/styles -name '*.css' -delete

echo "installing theme composer libraries"
composer require roots/acorn
composer require cjstroud/classnames-php
composer require log1x/acf-composer
composer require log1x/sage-directives
composer require log1x/sage-svg

composer install

echo "installing theme yarn libraries"
yarn
yarn build
sed -i "" "s/swell_library/$theme/g" $root/site/web/app/themes/$theme/bud.config.js
sed -i "" "s/Sage Starter/$campaign/g" $root/site/web/app/themes/$theme/style.css
sed -i "" "s/roots.io\/sage/$domain/g" $root/site/web/app/themes/$theme/style.css
sed -i "" "s/Sage is a WordPress starter theme/$campaign theme based on the Sage WordPress starter theme/g" $root/site/web/app/themes/$theme/style.css
sed -i "" "s/Roots/Swell, Inc./g" $root/site/web/app/themes/$theme/style.css
sed -i "" "s/roots.io/swellinc.co/g" $root/site/web/app/themes/$theme/style.css
rsync -aI $root/_starter/screenshot.png $root/site/web/app/themes/$theme/screenshot.png

echo "Setup README file"
rm -rf $root/README.md
rsync -aI $root/_starter/README.md $root/README.md
sed -i "" "s/Swell Module Library/$campaign/g" $root/README.md
sed -i "" "s/swell_library.org/$domain/g" $root/README.md
sed -i "" "s/swell_library/$theme/g" $root/README.md
sed -i "" "s/swell_library/$theme/g" $root/swell_tools/export-db.sh

echo "installing functions"
rsync -aI $root/_starter/functions $root/site/web/app/themes/$theme
cat $root/_starter/stubs/setup.txt >> $root/site/web/app/themes/$theme/app/setup.php

echo "Create the valet link"
trellis valet link

echo "Create the database"
mysql -u root -e "CREATE DATABASE ${theme};"

echo "Import the database"
sed -i "" "s/Swell Module Library/$campaign/g" $root/_starter/module_library.sql
sed -i "" "s/swell_library.test/$domain_test/g" $root/_starter/module_library.sql
sed -i "" "s/swell_library.org/$domain/g" $root/_starter/module_library.sql
sed -i "" "s/swell_library/$theme/g" $root/_starter/module_library.sql
mysql -uroot $theme < $root/_starter/module_library.sql

echo "removing template file directory"
rm -rf $root/_starter

echo "\nWould you like to connect to a new git repository?\n(Leave blank for no, or add your git url e.g. git@github.com:swell-creative-group/playground.swellinc.co.git)"
read repository

if [ "$repository" != '' ]
then
  echo "Setting origin"
  sed -i '' "s/REPOURL/$repository/g" $root/README.md
  git remote set-url origin $repository
  git add --all
  git commit -a -m "setup site"
  git push -u origin main
else
  git remote rm
  git checkout -b swell_library
  git add --all
  git commit -a -m 'Initial commit'
fi

# TO DOS
# Kinsta setup files (https://kinsta.com/blog/bedrock-trellis/)
#   - www_root path: example_123
#   - web_user: 
#   - Staging url: staging-example.kinsta.com
#   - Staging: DB Name, User, Password:
#   - Staging Host IP, Port
#   - Production url: example.kinsta.com
#   - Production: DB Name, User, Password:
#   - Production Host IP, Port