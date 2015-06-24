module.exports = function(grunt) {
    grunt.initConfig({
        phpunit: {
            classes: {
                dir: 'tests/'
            },
            options: {
                bin: 'vendor/bin/phpunit',
                colors: true
            }
        },
        watch: {
            test: {
                files: ['src/**/*.*'],
                tasks: ['phpunit']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpunit');

    grunt.registerTask('default', ['watch']);

};