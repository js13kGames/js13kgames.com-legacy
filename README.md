# js13kgames website

The source of the js13kgames.com website.

## Installation

1. Ensure [Node 5](https://nodejs.org/en/) is installed, then go to the project folder and execute on a shell:
```
npm install
```

2. Copy the .sqlite database in the root folder of the project

3. Edit the migrations table (just once) in the .sqlite file:

```
ALTER TABLE migrations ADD COLUMN name varchar;
```

4. Install [Imagemagick](http://www.imagemagick.org)

## Running

After installing, run all the migrations executing:

```
./node_modules/.bin/sequelize db:migrate
```

Then precompile the assets with:
```
gulp sass
```

And finally, start the app with:
```
npm start
```

Then go to http://localhost:3000 and enjoy.

## Development

To precompile your assets during development run:
```
gulp watch
```
This will process the SASS files in the source folder and write them to the public/assets folder of the site ready to
be used. Each change to the SASS file will trigger a new build.

To clean the assets:
```
gulp clean
```

## CSS Methodology

The files are pre-processed SASS files. These are not processed at run time via express for performance reasons.

The files are arranged based on recommendations - http://thesassway.com/beginner/how-to-structure-a-sass-project and
generate a single main.css file.

The CSS is structured around [12 column grid bootstrap grid](https://getbootstrap.com/examples/grid/). Additional
styles use the BEM (block element modifier) methodology. In short this means styles are component based and do not
cascade preventing issues around importance.
See https://en.bem.info/methodology/ for more details.

## Available Routes

```
js13kgames.com/                         -> index page for the current year
js13kgames.com/<year>                   -> index page for the given year
js13kgames.com/entries                  -> list of entries for the current year
js13kgames.com/<year>/entries           -> list of entries for the given year
js13kgames.com/<year>/entries/<slug>    -> details of the entry for the given year
js13kgames.com/submit                   -> form to submit a game. This form must be active only when the compo is running. It requires authentication
js13kgames.com/admin                    -> admin panel. It needs super user authentication
js13kgames.com/admin/login              -> admin login interface
js13kgames.com/admin/submissions        -> list of submissions for the current competition
js13kgames.com/admin/submissions/<id>   -> interface to interact with the submission (comment, vote, etc)
js13kgames.com/admin/editions           -> list of editions and options to close and delete the active edition
js13kgames.com/admin/editions/new       -> open a new edition
```

## Tech Stack

* [Node JS](https://nodejs.org/en/)
* [Express](http://expressjs.com/)
* [Handle Bars View Engine](http://handlebarsjs.com/)
* [SASS](http://sass-lang.com/guide) ([Bootstrap Grid](https://getbootstrap.com/examples/grid/) + [BEM Methodology](https://en.bem.info/methodology/))
