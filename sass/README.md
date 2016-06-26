# CSS for js13kgames website

The SASS source for the js13kgames.com website.

## Installation

Go to the project folder and execute on a shell:

```
npm install
```

## Running

After installing, execute:

```
gulp watch
```

This will process the sass files in the source folder and write them to the public/assets folder of the site ready to be used by the site. Each change to teh SASS file will trigger a new build.

## CSS Methodology 

The files are pre-processed SASS files. These are not processed at run time via express for performance reasons.

The files are arranged based on recommendations - http://thesassway.com/beginner/how-to-structure-a-sass-project and generate a single main.css file.

The CSS is structured around [12 column grid bootstrap grid](https://getbootstrap.com/examples/grid/). Additional styles use the BEM (block element modifier) methodology. In short this means styles are component based and do not cascade preventing issues around importance.
See https://en.bem.info/methodology/ for more details.
