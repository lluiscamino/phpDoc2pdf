# phpDoc2pdf
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lluiscamino/phpDoc2pdf/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lluiscamino/phpDoc2pdf/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/lluiscamino/phpDoc2pdf/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lluiscamino/phpDoc2pdf/build-status/master)

Create PDF formatted documentation for your PHP projects.

phpDoc2pdf uses the [phpDocumentor/Reflection](https://github.com/phpDocumentor/Reflection) library to extract the classes, interfaces and traits from your project and generate a set of documentation similar to the one that [phpDocumentor2](https://github.com/phpDocumentor/phpDocumentor2) provides, but in PDF format.

You can see some examples on the [docs](/docs) folder.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Installing

1. Download the PHAR file directly from [here](https://github.com/lluiscamino/phpDoc2pdf/releases).

### Usage

Use the following command to generate the documentation:

```bash
php phpDoc2pdf.phar create <INPUT> <OUTPUT>
```

Replace ``<INPUT>`` with the PHP file or directory that you want to document and ``<OUTPUT>`` with the directory where the documentation will be saved.

Please note that the files you want to document have to be in UTF-8 format.

## Built With

* [phpDocumentor2/Reflection](https://github.com/phpDocumentor/Reflection)
* [Symfony/Console](https://github.com/symfony/console)
* [mpdf](https://github.com/mpdf/mpdf)
* [thephpleague/plates](https://github.com/thephpleague/plates)
* [erusev/parsedown](https://github.com/erusev/parsedown)
* [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit)

## Contributing

All contributions are welcome, please see the To-do list below or suggest something. 🤗

## To-do list

- [x] Add tests
- [x] Add markdown support
- [x] Add templates system
- [ ] Separate generated docs into different subdirectories
- [x] Make installation and usage simpler
- [ ] Include phpDocBlock types on method arguments
- [ ] Add support for all type of file extensions.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
