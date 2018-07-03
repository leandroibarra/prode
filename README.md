## Prode
<p>Game of result predictions of FIFA World Cup 2018.</p>
<br />

## Table of contents
- [Installation](#installation)
- [Rules](#rules)
- [Author](#author)
- [License](#license)

## Installation
- Download content.
- Execute docs/shedule-and-data.sql into your MySQL database.
- Replace your database connection credentials into lib/constants.php file.

## Rules
- Users can select or change the result until before the start time of the match.
- The result options are: home, draw, or draw.
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
