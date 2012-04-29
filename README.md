SyliusThemingBundle
===================

Theming featuture for your Symfony2 applications. 
You can manage themes through a simple and customizable web interface. 
It's like Styles feature in phpBB. But it gives you even more, many theme loaders, store themes in .tar, .zip, remotely on GitHub or any themes gallery.
Interfaces allow you to implement custom loaders, packagers, everything is customizable thanks to Symfony container. 
Two theme resolvers supported, you can define theme in backend or allow users to switch between enabled themes.

**This bundle is compatible only with 2.1.x branch of Symfony2**.

Features
--------

### Planned or in progress

* Updating bundle to work with 2.1 and master of Symfony.
* More unit tests. [![Build status...](https://secure.travis-ci.org/Sylius/SyliusThemingBundle.png)](http://travis-ci.org/Sylius/SyliusThemingBundle)
* Full documentation.
* Doctrine MongoDB ODM driver. `*`
* Propel driver. `*`

`*` - wishlist, would love to see a contribution.

Sylius
------

**Sylius** is simple but **end-user and developer friendly** webshop engine built on top of Symfony2.

Please visit [Sylius.org](http://sylius.org) for more details.

Testing and build status
------------------------

This bundle uses [travis-ci.org](http://travis-ci.org/Sylius/SyliusThemingBundle) for CI.
[![Build status...](https://secure.travis-ci.org/Sylius/SyliusThemingBundle.png)](http://travis-ci.org/Sylius/SyliusThemingBundle)

Before running tests, load the dependencies using [Composer](http://packagist.org).

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install --dev
```

Now you can run the tests by simply using this command.

``` bash
$ phpunit
```

Code examples
-------------

If you want to see working implementation, try out the [Sylius sandbox application](http://github.com/Sylius/Sylius-Sandbox).
It's open sourced github project.

Documentation
-------------

Documentation is available on [readthedocs.org](http://sylius.readthedocs.org/en/latest/bundles/SyliusThemingBundle.html).

Contributing
------------

All informations about contributing to Sylius can be found on [this page](http://sylius.readthedocs.org/en/latest/contributing/index.html).

Mailing lists
-------------

### Users

If you are using this bundle and have any questions, feel free to ask on users mailing list.
[Mail](mailto:sylius@googlegroups.com) or [view it](http://groups.google.com/group/sylius).

### Developers

If you want to contribute, and develop this bundle, use the developers mailing list.
[Mail](mailto:sylius-dev@googlegroups.com) or [view it](http://groups.google.com/group/sylius-dev).

Sylius twitter account
----------------------

If you want to keep up with updates, [follow the official Sylius account on twitter](http://twitter.com/_Sylius)
or [follow me](http://twitter.com/pjedrzejewski).

Bug tracking
------------

This bundle uses [GitHub issues](https://github.com/Sylius/SyliusThemingBundle/issues).
If you have found bug, please create an issue.

Versioning
----------

Releases will be numbered with the format `major.minor.patch`.

And constructed with the following guidelines.

* Breaking backwards compatibility bumps the major.
* New additions without breaking backwards compatibility bumps the minor.
* Bug fixes and misc changes bump the patch.

For more information on SemVer, please visit [semver.org website](http://semver.org/).

This versioning method is same for all **Sylius** bundles and applications.

License
-------

License can be found [here](https://github.com/Sylius/SyliusThemingBundle/blob/master/Resources/meta/LICENSE).

Authors
-------

The bundle was originally created by [Paweł Jędrzejewski](http://pjedrzejewski.com).
See the list of [contributors](https://github.com/Sylius/SyliusThemingBundle/contributors).
