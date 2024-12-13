# Amica Center
This site uses Trellis, Bedrock, and Sage tech stack to develop and deploy [Amica Center](amicacenter.org) WordPress website hosted on Kinsta.

## Local Development

### Requirements
- [ ] [NVM](https://github.com/nvm-sh/nvm#installing-and-updating), node (`nvm install node`)
- [ ] [Homebrew](https://brew.sh/)
- [ ] [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- [ ] Yarn (`brew install **yarn**`)
- [ ] Trellis (`brew install roots/tap/trellis-cli`)
- [ ] [MySql](https://dev.mysql.com/downloads/mysql/)
- [ ] Python (`brew install python`), Ansible (`brew install ansible`)
- [ ] [Sequel Ace](https://github.com/Sequel-Ace/Sequel-Ace) (optional)
- [ ] Pre-M1 chip
  - [ ] Vagrant 2.2.7
  - [ ] [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
- [ ] M1 chip
  - [ ] [Valet](https://laravel.com/docs/9.x/valet#installation)
  - [ ] [Trellis-to-Valet Driver](https://github.com/danielroe/trellis-valet-driver)

### Clone from Git
To begin developing locally, you must clone this repo:
```
  git clone REPOURL
```
Go to `/site` and run `composer install`.

Create a `.vault_pass` file in the `trellis` directory and enter the plain text encyption key. Ask the [Swell Dev Team](mailto:dev@swellinc.co) for the key.

Still in your `trellis` directory, run `trellis init`.

### Trellis Setup (pre-M1 Chips)
Run `trellis up`. 

Install the [self-signed ssl certificate](https://docs.roots.io/trellis/master/ssl/#configuration) for the local site `amica.test`.

```
vagrant plugin install vagrant-trellis-cert
vagrant trellis-cert trust
```

### Valet Setup (M1 Chips)
Use `trellis valet link` on the `/site` folder.
`mysql -u root`, `create database amica;` then you add that information to `project/site/.env`:
```
  DB_NAME='amica'
  DB_USER='root'
  DB_PASSWORD=''
```

Replace the database with either the downloaded one (`mysql -uroot amica < <filename>.sql`) or using the Migrate DB plugin.


### Setting up the theme 
From your project's root directory, browse to the custom theme directory `amica` and run the following to install dependencies
```
cd site/web/app/themes/amica/
composer install
yarn install
```

To get started with theming and development:

```
yarn start
```

### Grabbing the uploads folder
Get SFTP credentials on Kinsta and copy the `public/shared/source/site/web/app/uploads` folder from the live site to your local version.

## Deploying to Kinsta
To deploy this site, go to the `trellis` directory and run the deploy script for the desired environment
- **Production**: `trellis deploy production`
- **Staging**: `trellis deploy staging`

Additional information on configuration and setup can be found [here](https://kinsta.com/blog/bedrock-trellis/).


## Resources
- Layouts: https://www.figma.com/file/BeYnzxawWpJlMSWBkwmk1u/Web-Component-Library?node-id=0%3A1

## Troubleshooting
* [Advanced Custom Fields Cheatsheet](https://github.com/Log1x/acf-builder-cheatsheet)
* "Error: Your Command Line Tools are too outdated.":
  Update xcode libraries using ```sudo rm -rf /Library/Developer/CommandLineTools
  sudo xcode-select --install```
* There was an error while executing `VBoxManage`, a CLI used by Vagrant
  Open System Preferences -> Security & Privacy and Click on Lock to give Oracle permissions (h/t ritwikjamuar): Reinstall vagrant
* `yarn start` Error: error:0308010C:digital envelope routines::unsupported
  [Set your node version to lts (latest stable)](https://itsmycode.com/error-digital-envelope-routines-unsupported/)
* A bunch of "Deprecated" messages: `valet use php@8.0`
* Can't connect to local MySQL server through socket '/tmp/mysql.sock': reinstall mysql, not from homebrew
* Root password issues: `ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';`
* Need to create new database users `CREATE USER 'sammy'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';`
* "Error locating autoloader. Please run composer install": 
* DROP DATABASE [database_name];

## Pre-launch Checklist
- [ ] Access to domain's registrar (DNS)
- [ ] Google Tag Manager setup
- [ ] Google Analytics
- [ ] Favicon
- [ ] Meta image and content
- [ ] Run the site through Lighthouse to optimize build & performance
- [ ] XML Sitemap
- [ ] Submit sitemap to [Google](https://search.google.com/search-console)
