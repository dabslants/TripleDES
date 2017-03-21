TripleDES -- A Simple Encryption Class using Triple Data Encryption Standard

### Table of Contents
**[Import](#import)**  
**[Encrypt](#encrypt)**  
**[Decrypt](#encrypt)**  

### Installation
To utilize this class, simply require encrypt.php into your project.

```php
require_once ('path-to-container/encrypt.php');
```

### Import
Simple initialization: import the class with php use keyword

initialize with content-type JSON and time to live
```php
use OK\OKEncrypt;
```


### Encrypt Data
```php
$data = 4;
$key = 'mykey';
OKEncrypt::encrypt($data, $key);
```


### Decrypt Data
```php
$data = 'result-string-from-encrypt';
$key = 'mykey';
OKEncrypt::encrypt($data, $key);
```
