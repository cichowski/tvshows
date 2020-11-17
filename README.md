# TV Shows
Simple application made as a part of recrutation process.
 
## Architecture & dependencies

- It is build on Lumen & Vue frameworks.
- It uses http://www.tvmaze.com/ API for taking results

## Requirements

Application needs for running:
- php 7.3+ server

Application needs for set up:
- composer

## Installation

1. Download the repository by preffered way

- https: `git close https://github.com/cichowski/tvshows.git`
- ssh: `git@github.com:cichowski/tvshows.git`
- or just download archive and unzip files
 
2. Run `composer install`

3. Rename `.env.local` to `.env`

4. Change `APP_URL` or even other values in `.env`

## Configuration

Number of results per page returned by API:
- Set `resultsPerPage` in `config/tvshows.php` file

Number of results per single load on view page:
- Set `resultsPerPage` in Form class initialization in `public/js/app.js` file 

## Usage

API
- address:
    - `your.doman/api/`
- parameters:
    - `q` - search phrase (required, alphanumerical)
    - `p` - ask for a specific page (positive integer, default: 1)
    - `s` - page size: number o results on single page (positive integer, default: see Configuration)
- examples:
    - `localhost/api?q=castle`
    - `json-api.local/api?s=12&p=1&q=war`    
    
WEB
- address:
    - `your.domain/`    

## Issues

1. For some reason http://www.tvmaze.com/ API right now returns maximum 10 results.
2. Keep in mind that either this application and TV Maze caches every search query for 1 hour.

## ToDo

* Add list view with more information about shows 
* Cover whole the rest of PHP code with unit tests 
* Write tests for Vue code
* Write OpenAPI description for API endpoint
* Build Swagger documentation using above
* Throttle infinite scroll event
* Refactor app.js
* For many users: cache tv shows in advance 

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
