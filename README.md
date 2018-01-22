TripleDES -- A Simple Encryption Class using Triple Data Encryption Standard

### Table of Contents
**[Initialization](#initialization)**
**[Encrypt](#encrypt)**
**[Encrypt with Skip](#encrypt-skip)**
**[Decrypt](#encrypt)**

### Installation
To utilize this class, simply require encrypt.php into your project.

```php
require_once ('path-to-container/encrypt.php');
```

### Initialization
Simple initialization: import the class with php use keyword

initialize with content-type JSON and time to live
```php
use OK\OKEncrypt;
```


### Encrypt Data
```php
// encrypt string
$data = 4;
$key = 'mykey';
$enc = OKEncrypt::encrypt($data, $key);

// encrypt array
$data = ['Dabs', 0200, 'March-2016'];
$key = 'mykey';
$enc = OKEncrypt::encrypt($data, $key);

// encrypt associative array
$assoc_data = ['name'=>'Dabs','time'=>0200,'date'=>'March-2016'];
$key = 'mykey';
$enc = OKEncrypt::encrypt($data, $key);
```

### Encrypt with Skip
```php
// encrypt associative array but skip an element using array values
$data = ['Dabs', 0200, 'March-2016'];
$key = 'mykey';
$skip = 'Dabs';
$menc = OKEncrypt::encrypt($data, $key, $skip);

// encrypt associative array but skip multiple element using array values
$data = ['Dabs', 0200, 'March-2016'];
$key = 'mykey';
$skip = ['dabs', 0200];
$menc = OKEncrypt::encrypt($data, $key, $skip);

// encrypt associative array but skip an element using array keys
$data = ['name'=>'Dabs','time'=>0200,'date'=>'March-2016'];
$key = 'mykey';
$skip = 'date';
$menc = OKEncrypt::encrypt($data, $key, $skip);

// encrypt associative array but skip multiple element using array keys
$data = ['name'=>'Dabs','time'=>0200,'date'=>'March-2016'];
$key = 'mykey';
$skip = ['time', 'date'];
$menc = OKEncrypt::encrypt($data, $key, $skip);
```


### Decrypt Data
```php
// decrypt array or string
$data = $enc;   // result of encrypted data string or array
$key = 'mykey';
$enc = OKEncrypt::encrypt($data, $key); // encrypted data

// decrypt array but skip an element
$data = $enc;   // result of encrypted data array
$key = 'mykey';
OKEncrypt::decrypt($data, $key);
```

### Decrypt with Skip
```php
// encrypt associative array but skip an element using array values
$data = ['Dabs', 0200, 'March-2016'];
$key = 'mykey';
$skip = 'Dabs';
$menc = OKEncrypt::encrypt($data, $key, $skip);

// decrypt array but skip an element
$data = $menc;   // result of encrypted data array
$key = 'mykey';
$skip = 'Dabs';
OKEncrypt::decrypt($data, $key, $skip);
