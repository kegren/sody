# Welcome to Sody Framework!

[![Build Status](https://travis-ci.org/kegren/sody.png?branch=master)](https://travis-ci.org/kegren/sody)

A small and flexible PHP framework under development. This should not yet be used
in production. More information about releases, versions etc will appear soon.

### Features

* Easy to use
* PSR-2
* Restful routing system
* View system
* Events
* Simple textfile logger

### System requirements

PHP >= 5.3.3

### Installation

Coming soon

### How to use

```php
$sody = new Sody\App();

$sody->get('home', '/', function () use ($sody) {
   return $sody->response('hello world!');
});
```

### License

Copyright (c) 2014 Kenny Damgren

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.