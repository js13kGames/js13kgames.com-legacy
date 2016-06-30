# js13kgames website

The source of the js13kgames.com website.

## Installation

Ensure [Node JS](https://nodejs.org/en/) is installed, go to the project folder and execute on a shell:

```
npm install
```

## Running

After installing, execute:

```
npm start
```

Then go to http://localhost:3000 and enjoy.

## Available Routes

```
js13kgames.com/                         -> index page for the current year
js13kgames.com/<year>                   -> index page for the given year
js13kgames.com/entries                  -> list of entries for the current year
js13kgames.com/<year>/entries           -> list of entries for the given year
js13kgames.com/<year>/entries/<slug>    -> details of the entry for the given year
js13kgames.com/submit                   -> form to submit a game. This form must be active active only when the compo is running. It needs authentication
```

## Tech Stack

* [Node JS](https://nodejs.org/en/)
* [Express](http://expressjs.com/)
* [Handle Bars View Engine](http://handlebarsjs.com/)
* [SASS](http://sass-lang.com/guide) ([Bootstrap Grid](https://getbootstrap.com/examples/grid/) + [BEM Methodology](https://en.bem.info/methodology/))
