PHP Enum implementation.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist Corp-Soft/php-enum "*"
```

or add

```
"Corp-Soft/php-enum": "*"
```

to the require section of your `composer.json` file.

## Available Methods:

- `createByName()` - Creates a new type instance using the name of a value.
- `getValueByName()` - Returns the constant key by value(label)
- `createByValue()` - Creates a new type instance using the value.
- `listData()` - Returns the associative array with constants values and labels
- `getLabel()`- Returns the constant label by key
- `getConstantsByName()` - Returns the list of constants (by name) for this type.
- `getConstantsByValue()` - Returns the list of constants (by value) for this type.
- `isValidName()` - Checks if a name is valid for this type.
- `isValidValue()` - Checks if a value is valid for this type.

## Declaration

```php
<?php

namespace App\Enums;

use CorpSoft\Enum\BaseEnum;

class PostStatus extends BaseEnum
{
    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    const POSTPONED = 3;
    
    /**
     * @var array
     */
    public static $list = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::REJECTED => 'Rejected',
        self::POSTPONED => 'Postponed',
    ];
}
```
## Enum creation
```php
$status = new PostStatus(PostStatus::PENDING);

// or you can use the magic methods

$status = PostStatus::PENDING();
```

## Static methods
```php
PostStatus::getConstantsByValue() // ['PENDING', 'APPROVED', 'REJECTED', 'POSTPONED']
PostStatus::getConstantsByName() // ['PENDING' => 0, 'APPROVED' => 1, 'REJECTED' => 2, 'POSTPONED' => 3]
PostStatus::isValidName(1) // false
PostStatus::isValidName('APPROVED') // true
PostStatus::isValidValue(1) // true
PostStatus::isValidValue('Approved') // false
PostStatus::listData() // ['Pending', 'Approved', 'Rejected', 'Postponed']
PostStatus::getLabel(1) // Approved
PostStatus::getValueByName('Approved') // 1
```
## Type-Hint and Validation Rules
```php
<?php

use App\Enums\PostStatus;

class Post
{
   /**
    * @var integer status 
    */
    public $status;
    
    public function setStatus(PostStatus $status)
    {
        $this->status = $status->getValue();
    }

    public function getStatus(): PostStatus
    {
        return $this->status;
    }
}
```

