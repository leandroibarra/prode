## Prode
<p>Game of result predictions of FIFA World Cup 2018.</p>
<br />

## Table of contents
- [Installation](#installation)
- [Rules](#rules)
- [Author](#author)
- [License](#license)

## Installation
- Clone repository using `https://github.com/leandroibarra/prode.git`.
- Execute `composer install`.
- Rename `.env.example` file to `.env` and set database configurations.
- Create database schema using `php artisan migrate` command.
- Configure initial state of database data using `php artisan db:seed` command.
- [Optional] Replace `prode.loc` with your url through `APP_URL` constant into `.env` and `config/app.php` files.
- Grant write permissions using below commands:
    ```
    chmod 777 -R bootstrap/cache/
    chmod 777 -R storage
    ```

## Rules
- Users can select or change the result until before the start time of the match.
- The result options are: home, draw, or away.
- The points for successful result are the following:
  - 1 in group phase.
  - 4 in round of 16.
  - 6 in quarter-finals.
  - 8 in semi-finals.
  - 10 in play-off for third place and final.

## Author
Leandro Ibarra

## License
Code released under the [MIT License](https://github.com/leandroibarra/prode/blob/master/LICENSE)
