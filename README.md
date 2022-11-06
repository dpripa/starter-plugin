# WPappy Starter Plugin

Boilerplate for developing a WordPress plugin using WebPack, [WPappy framework](https://github.com/wpappy/wpappy) and other helpful solutions.

## Installation
- Create `src/.env` file and fill it using an example data from the `src/.env.example` file.
- Search for `MyPlugin` in the application's root directory to capture default PHP namespace and replace it with your own.
- Search for `my-plugin` to replace the default CSS class prefixes.
- Rename the `lang/my_plugin.pot` file with the WPappy application key (also by default this is the PHP namespace of your application in the lower case) which is used as the localization text domain.
- Also don't forget to edit the fields in the `composer.json` file and edit the header information in the `index.php` file.
- Then run following command in the application root directory to install Composer and Node.js dependencies:
```bash
composer install && cd src && npm install
```
- Now everything is ready, let's create. 😉

## Questions and Answers

### How I can add entry points for JS or CSS to the WebPack process?
Just add an entry to the `src/entry.json` file, using the existing example.

### Do I need to somehow declare the image or font files that I've added to the `src/image` or `src/font` directories?
No, WebPack automatically deploys it to the `asset` directory with the same directory hierarchy. In addition, the images will be auto-optimized without quality loss.

### Why aren't the `asset` and partially `vendor` directories ignored?
We store an application in a repository as ready to use. If this is not what you need in your case, just add these directories to the `.gitignore` file.

## License
WPappy Starter Plugin is free software, and is released under the terms of the GPL (GNU General Public License) version 2 or (at your option) any later version. See [LICENSE](https://github.com/wpappy/starter-plugin/blob/main/LICENSE).
