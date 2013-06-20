Nerdery Documentation Bundle
============================

This bundle provides a way to configure packages of markdown documentation and
render them into readable, traversable HTML pages.
These documentation files are typically located in `Resources/doc/` for Symfony2
projects, but could be located anywhere or just point at a README file.
Currently, Markdown is the only supported format.

It is intended that this documentation be used for development use only.

Installation
------------

Add the following bundles to your `app/AppKernel.php` file in the development
environments

    ....
    if (in_array($this->getEnvironment(), array('dev', 'staging', 'test'))) {
        ...
        $bundles[] = new Nerdery\DocumentationBundle\NerderyDocumentationBundle();
        $bundles[] = new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle();
    }
    ....

Configuration
-------------

To start, you need to specify some locations where documentation can be found.
You do so by specifying an index file, which will function as the base path for
all documentation in that package.

You may specify the package index location explicitly by file path or by using
bundle resource notation.

    nerdery_documentation:
        packages:
            index:
                title: "Explicit path example"
                index: %kernel.root_dir%/../README.md
            dashboard_web:
                title: "Bundle notation Example"
                index: @NerderyDemoBundle/Resources/doc/index.md

To view the documentation at a web URL you must configure a route for it. It is
recommended that you add this to your `routing_dev.yml` file so that these are
not publicly available.

    _nerdery_documentation:
        resource: @NerderyDocumentationBundle/Controller/
        type:     annotation
        prefix:   /_docs
