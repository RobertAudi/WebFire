WebFire
=======

WebFire is a stand-alone web version of
[fire](https://github.com/AzizLight/fire).

Installation
------------

### Using fire (recommended)

Using fire is the recommended way to install WebFire. Once [you
installed](https://github.com/azizlight/fire#integration-with-webfire) fire, navigate to the root of your CodeIgniter project and
run the following command:

    fire web install

That's it!

### Manually

Copy the contents of the folders to right location. So the `fire` folder
in the controllers folder should go in the controllers folder of your
application. The assets folder should be copied as-is in the root of
your application (where the index.php file is). The directory structure
of your application should look similar to this after installing
WebFire:

![WebFire Directory Structure](https://img.skitch.com/20120826-8mm451a6yr82rdpnd3kji4k25r.jpg)

Also make sure to add an encryption key to the config file
(`application/config/config.php`). You can find a good encryption key
generator [here](http://randomkeygen.com/).

Usage
-----

Navigate to the `fire/generate` controller, ie:
`http://example.com/index.php/fire/generate` and navigate through the
links to create controllers, models or migrations.
