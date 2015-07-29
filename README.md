# hoist-php-sdk
PHP SDK for Hoist

## Run as a background process
```bash
nohup php ./sdk/launcher.php start ./my-hoist-methods.php > /dev/null 2>&1 & echo $!
```

Swap out `./my-hoist-methods.php` for the file you want to store your Hoist methods in. It simply does a require_once() to that argument