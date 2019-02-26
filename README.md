# <div align='center'>Confessor</div>

A Script for a web application that resembles the likes of Sayat, Sarahah and Confessout. Because Why Not?

## Installation

### Pre - Requisites

<ul>
  <li>PHP 5</li>
  <li>MySQL Improved</li>
  <li>A Web Server</li>
</ul>

Installation is pretty easy. Clone or Download the repo to a web server using the following commands from the terminal if you have git installed or just download the zip and unpack it to a directory. 

```bash
git clone https://github.com/deve-sh/Confessor/
cd Confessor
```

Visit the path in a web browser. The Script will automatically redirect to the /install route. Enter the details of the Web Application and the Database correctly and the script should configure itself.

## Features

<ul>
  <li>Responsive Design.</li>
  <li>Beautiful Interface.</li>
  <li>Beautiful Share Page for Confessions.</li>'
  <li>Anonymity for Users.</li>
  <li>SQL Injection Resistant.</li>
</ul>

## Editing / Further Developing

For people looking to Develop the project further, or just edit it to their needs; I am sorry, there is no administrator mode for the project like other projects of mine, so for now, the only way to edit the project is by directly editing the source code. However the project is well commented wherever necessary, so editing it might not be a tough play.

For development purposes, the error reporting is turned off by default. It is recommended to turn it off in order for a better development experience. Hence, past installation, just go to <b>inc/config.php</b> and remove the following line.

```php
error_reporting(0);
```

Here is a list of all the files and what they correspond to :

```
header.php      : Header
footer.php      : Footer
inc/styles.php  : Style Information for the Web Application
inc/config.php  : Configuration file for the Web Application
inc/connect.php : Database Driver File (Crucial. Do Not Remove at any cost.)
inc/scripts.php : File to host all the Links to extra Scripts to run in the web application.
```

## Contributing

For contributions, just make changes to the project that you might feel are necessary or make the project better, and start a pull request.

## License

The Project is License Free. Do whatever you may want to do with it. (As long as its legal and doesn't destroy any one's life.)

## Support

For support and concerns, raise an Issue in the repo or <a href='mailto:devesh2027@gmail.com'>email</a> me.
