# phpDoc2pdf

Create PDF formatted documentation for your PHP projects.

phpDoc2pdf uses the [phpDocumentor/Reflection](https://github.com/phpDocumentor/Reflection) library to extract the classes, interfaces and traits from your project and generate a set of documentation similar to the one that [phpDocumentor2](https://github.com/phpDocumentor/phpDocumentor2) provides, but in PDF format.

You can see some examples on the [docs](/docs) folder.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Installing

1. Clone the repo

```bash
git clone https://github.com/lluiscamino/phpDoc2pdf.git
```

2. Go into the ``phpDoc2pdf`` folder

```bash
cd phpDoc2pdf
```

3. Install [composer](https://github.com/composer/composer) dependencies

```bash
php composer.phar install
```

### Usage

Go into the ``src/application`` directory and run this command:

```bash
php createDocs.php create INPUT OUTPUT
```

Replace ``INPUT`` with the PHP file or directory that you want to document and ``OUTPUT`` with the directory where documentation will be generated.

## Built With

* [phpDocumentor2/Reflection](https://github.com/phpDocumentor/Reflection)
* [Symfony/Console](https://github.com/symfony/console)
* [mpdf](https://github.com/mpdf/mpdf)

## Contributing

All contributions are welcome, please see the To-do list below or suggest something. 🤗

## To-do list

- [ ] Add tests
- [ ] Add markdown support
- [ ] Add templates system
- [ ] Separate generated docs into different subdirectories
- [ ] Make installation and usage simpler
- [ ] Include phpDocBlock types on method arguments

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

