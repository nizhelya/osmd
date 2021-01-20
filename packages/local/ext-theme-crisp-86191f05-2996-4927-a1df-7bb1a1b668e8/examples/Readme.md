# ext-theme-crisp-86191f05-2996-4927-a1df-7bb1a1b668e8/examples

This folder contains example applications demonstrating this package. Each of
these applications will be built as part of the package build:

    cd /path/to/package
    sencha package build

As applications, they can also be built individually:

    cd /path/to/package/examples/example-app
    sencha app build

Or you can build all examples as a group:

    cd /path/to/package
    sencha ant examples

The ideal location for the example builds to reside is the `"./build"` folder:

    /path/to/package/
        src/
        resources/
        ...
        examples/
            example-app/
            other-example/
        ...
        build/
            resources/
            examples/
                example-app/
                other-example/

This can be specified in the `".sencha/app/build.properties"` file for the
example applications:

    build.dir=${package.build.dir}/examples/${app.name}
