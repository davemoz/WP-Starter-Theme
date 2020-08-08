module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            target: {
                options: {
                    style: 'expanded'
                },
                files: [{
                    'style.css': 'scss/style.scss'
                }]
            }
        },
        postcss: {
            options: {
                map: {
                    inline: false,
                    annotation: ''
                },
                processors: [
                    require('autoprefixer')(),
                    require('cssnano')()
                ]
            },
            files: {
                src: 'style.css',
                dest: 'style.css'
            }
        },
        concat: {
            options: {
                // define a string to put between each file in the concatenated output
                seperator: ';',
                sourceMap: true
            },
            files: {
                // the files to concatenate
                src: ['js/src-bundle/*.js'],
                // the location of the resulting JS file
                dest: 'js/src-bundle/bundle.js'
            }
        },
        babel: {
            bundle: {
                options: {
                    sourceMaps: true,
                    inputSourceMap: grunt.file.readJSON('js/src-bundle/bundle.js.map')
                },
                files: {
                    'js/src-bundle/bundle-compiled.js': '<%= concat.files.dest %>'
                }
            },
            single: {
                options: {
                    sourceMaps: true
                },
                files: [{
                    expand: true,
                    cwd: 'js/src-single',
                    src: '**/*.js',
                    dest: 'js/src-single',
                    ext: '-compiled.js'
                }]
            }
        },
        uglify: {
            bundle: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                    compress: true,
                    mangle: {
                        reserved: ['jQuery']
                    },
                    sourceMap: {
                        includeSources: true
                    },
                    sourceMapIn: 'js/src-bundle/bundle-compiled.js.map'
                },
                files: {
                    'js/dist/<%= pkg.name %>-bundle.min.js': 'js/src-bundle/bundle-compiled.js'
                }
            },
            single: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                    sourceMap: true,
                    mangle: {
                        reserved: ['jQuery']
                    }
                },
                files: [{
                    expand: true,
                    src: ['**/*.js', '!**/*-compiled.min.js'],
                    dest: 'js/dist',
                    cwd: 'js/src-single',
                    rename: function (dst, src) {
                        // To keep the source js files and make new files as `*.min.js`:
                        // return dst + '/' + src.replace('.js', '.min.js');
                        // Or to override to src: return src;
                        return dst + '/' + src.replace('.js', '.min.js');
                    }
                }]
            }
        },
        clean: {
            dist: {
                files: {
                    src: ['js/dist/*-compiled.min.js', 'js/dist/*-compiled.min.js.map']
                }
            },
            bundle: {
                files: {
                    src: ['js/src-bundle/bundle.*', 'js/src-bundle/*.js.map', 'js/src-bundle/*-compiled.js', 'js/src-bundle/*-compiled.js.map']
                }
            },
            single: {
                files: {
                    src: ['js/src-single/*-compiled.js', 'js/src-single/*-compiled.js.map']
                }
            }
        },
        watch: {
            grunt: {
                files: ['Gruntfile.js'],
                options: {
                    reload: true
                }
            },
            jsbundle: {
                files: ['js/src-bundle/*.js', '!js/src-bundle/bundle.*'],
                tasks: ['concat', 'babel:bundle', 'uglify:bundle', 'clean:bundle', 'clean:dist']
            },
            jssingle: {
                files: ['js/src-single/*.js', '!js/src-single/*-compiled.js'],
                tasks: ['babel:single', 'uglify:single', 'clean:single', 'clean:dist']
            },
            css: {
                files: ['scss/**/*.scss'],
                tasks: ['sass', 'postcss']
            },
            options: {
                spawn: false
            }
        }
    });

    // Load the plugins
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-babel');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Default task(s)
    grunt.registerTask('default', ['watch']);

}