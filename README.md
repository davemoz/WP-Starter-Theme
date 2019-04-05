# A Wordpress starter theme using Stylus & Grid

### What is this?

WPSS is an adaptation of @luclemo's Styl_s starter theme, which is an adaptation of Automattic's very own starter theme,
[Underscores (\_s)](http://underscores.me). I originally used @luclemo's starter because of the use of
[Stylus](https://learnboost.github.io/stylus/), and as I modified it to fit my own projects I found myself doing a lot
of the same "normalizing" changes, so I decided to throw it up on Github for my own future projects and whomever else
wanted to utilize it as well.

Here's the rundown of the 🍬 included in this theme:

- Stylus CSS
  - **CSS Grid** for structure
  - **Mixin** media-query (use `+widerThan(768px)` for nice and easy media-queries)
  - **Mixin** px-to-rem (use `font-size 16px` normally and a rem equivalent will be added automatically)
  - A tiny .styl to lightly handle some FOUC
- Wordpress Functions
  - A basic, lightweight mobile nav solution
  - FontAwesome integrated
  - A WP_Nav_Walker to detect social urls and attach the appropriate FA icon
  - Customizable **async** & **defer** function for enqueued scripts
- Optional (commented out in `functions.php`)
  - Useful WooCommerce functions
  - Separate custom post types & taxonomies file
  - CMB2 library included

## Getting Started

- ### Installing the theme

- Just download or clone from here and rename the directory from `WP-Styl-Starter` to something of your own choosing.
- You will also want to do a search & replace on all instances of `'WPSS'` in the template files as
  [explained here](https://github.com/Automattic/_s#user-content-getting-started).
- Then get to editing the theme files.

- ### Task Running

I currently use Codekit for processing, so I haven't included any Gulp or Grunt-type packages with this theme.

## Plans and TODO's

TBD

## Why am I making YAWPT \* ?

- I much prefer Stylus over other pre-processors and had a hard time finding good starter themes using it.
- I'm trying to learn/practice using git[hub], and putting this all up here forces me to use best practice and version
  control to update my stuff, and also DRY, rather than making the same changes for each project.

---

#### Help me improve!

I'm honing my skills daily, so I would love to get constructive feedback on anything I've done here. Pull requests,
comments, don't hold back.
