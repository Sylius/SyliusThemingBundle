SyliusThemingBundle documentation.
=====================================

This bundle is part of **Sylius e-commerce system**.
Prototype version of bundle that add theming feature to any Symfony2 application.
You can manage themes through a simple and customizable web interface.
There are two theme resolvers built in, first one is static, that means the theme is activated only by admin in backend.
The second is dynamic, that means the user can change the theme anytime they want.
It is something like Styles in phpBB.
Stay tuned and [follow me on twitter](http://twitter.com/pjedrzejewski) for updates.
Have a nice read, and remember that it still lacks some of the important features.

**Note!** This documentation is inspired by [FOSUserBundle docs](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).

Installation.
-------------

+ Downloading the bundle.
+ Autoloader configuration.
+ Adding bundle to kernel.
+ DIC configuration.
+ Importing routing cfgs.
+ Updating database schema.
+ Testing.
+ Creating theme.
+ The pattern of locating files.

### Downloading the bundle.

The good practice is to download the bundle to the `vendor/bundles/Sylius/Bundle/ThemingBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script.**

Add the following lines in your `deps` file...

```
[SyliusThemingBundle]
    git=git://github.com/Sylius/SyliusThemingBundle.git
    target=bundles/Sylius/Bundle/ThemingBundle
```

Now, run the vendors script to download the bundle.

``` bash
$ php bin/vendors install
```

**Using submodules.**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/Sylius/SyliusThemingBundle.git vendor/bundles/Sylius/Bundle/ThemingBundle
$ git submodule update --init
```

### Autoloader configuration.

Add the `Sylius\Bundle` namespace to your autoloader.

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Sylius\\Bundle' => __DIR__.'/../vendor/bundles',
));
```

### Adding bundle to kernel.

Finally, enable the bundle in the kernel.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sylius\Bundle\ThemingBundle\SyliusThemingBundle(),
    );
}
```

### Container configuration.

Now you have to do the minimal configuration, no worries, it is not painful.

Open up your `config.yml` file and add this...

``` yaml
sylius_theming:
    driver: ORM
    directory: ../themes # Relative to kernel root dir.
    classes:
        model:
            theme: Sylius\Bundle\ThemingBundle\Entity\Theme
```

`Please note, that the "ORM" is currently the only supported driver.`

### Import routing files.

Now is the time to import routing files. Open up your `routing.yml` file. Customize the prefixes or whatever you want.
If you want to use static theme resolver import just the second one, otherwise import both files.

``` yaml
sylius_theming_theme:
    resource: "@SyliusThemingBundle/Resources/config/routing/frontend/theme.yml"

sylius_theming_backend_theme:
    resource: "@SyliusThemingBundle/Resources/config/routing/backend/theme.yml"
    prefix: /administration
```

### Updating database schema.

The last thing you need to do is updating the database schema.

For "ORM" driver run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Testing.

Now if you want to test the bundle, use the two sample themes. They are located in...

`Resources/fixtures`

Copy both `ThemeA` and `ThemeB` to the themes directory.
Now go to `/administration/themes` and install both of them.
You can switch between them by activating the desired theme.
If you can see the difference, the bundle is working properly.

**Note!** The dynamic resolver might not be working properly as I am still modifying it.

### Creating theme.

`Will be written soon.`

### The pattern of locating files.

First the locator looks into kernel dir, where you can override any resource files. Just like in pure Symfony2.

Second, the locator looks in the following path.

```
{The directory where themes are stored}/{Active theme path}/{Bundle name}
```

If the file is not present it just looks into the bundle.

`This documentation is under construction.`
