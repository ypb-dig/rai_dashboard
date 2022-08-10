# [RAI Dashboard](https://rainvestimentos.com.br)

## Node Version
v16.15.1

## NPM Version
v8.11.0

## Download and Installation

To begin using this template, choose one of the following options to get started:

* Clone the repo: `git clone https://github.com/ypb-dig/rai_dashboard.git`

## Usage

After installation, run `npm install` and then run `npm i -g gulp` for installation Gulp. You can view the `gulpfile.js` to see which tasks are included with the dev environment.

### Gulp Tasks

* `gulp` the default task that builds everything
* `gulp watch` browserSync opens the project in your default browser and live reloads when changes are made
* `gulp css` compiles SCSS files into CSS and minifies the compiled CSS
* `gulp js` minifies the themes JS file
* `gulp vendor` copies dependencies from node_modules to the vendor directory

You must have npm installed globally in order to use this build environment. This theme was built using node v16.5.1 and the Gulp CLI v2.0.1. If Gulp is not running properly after running `npm install`, you may need to update node and/or the Gulp CLI locally.