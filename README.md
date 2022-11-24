# WordPress Starter Plugin

## Installation
- Create `src/.env` file and fill it using an example data from the `src/.env.example` file.
- Search for `MyPlugin` in the application's root directory to capture default PHP namespace and replace it with your own.
- Change the `KEY` constant in the `functions.php` file.
- Search for `my-plugin` to replace the default CSS class prefixes.
- Rename the `lang/my_plugin.pot` file with the WPappy application key (also by default this is the PHP namespace of your application in the lower case) which is used as the localization text domain.
- Also don't forget to edit the fields in the `composer.json` file and edit the header information in the `index.php` file.
- Then run following command in the application root directory to install Composer and Node.js dependencies:
```bash
composer install && cd src && npm install
```
- Now everything is ready, let's create. 😉

## License
WPappy Starter Plugin is free software, and is released under the terms of the GPL (GNU General Public License) version 2 or (at your option) any later version. See [LICENSE](https://github.com/dpripa/wp-starter-plugin/blob/main/LICENSE).
