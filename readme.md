# PHP lightweight Enum trait

[![Build Status](https://travis-ci.org/richard-ejem/enum.svg?branch=master)](https://travis-ci.org/richard-ejem/enum)
[![Downloads this Month](https://img.shields.io/packagist/dm/richard-ejem/enum.svg)](https://packagist.org/packages/richard-ejem/enum)
[![Latest stable](https://img.shields.io/packagist/v/richard-ejem/enum.svg)](https://packagist.org/packages/richard-ejem/enum)

Simple trait to create enumeration classes.

Separate your enumerations into standalone classes and validate
through your application that you are passing valid enumeration values.

## Installation

Recommended to install using composer:

`composer require richard-ejem/enum`

## Example

```php
class UserRole
{
    use \Ejem\Enum\EnumTrait;
    
    const GUEST = 'guest';
    const USER = 'user';
    const ADMIN = 'admin';
}

class User
{
    /** @var string UserRole enum */
    private $role;
    
    /** @throws \Ejem\Enum\InvalidEnumValueException */
    public function __construct(string $role)
    {
        $this->setRole($role);
    }
    
    public function getRole(): string
    {
        return $this->role;
    }
    
    /** @throws \Ejem\Enum\InvalidEnumValueException */
    public function setRole(string $role): void
    {
        UserRole::assertValidValue($role);
        $this->role = $role;
    }
    
    // ... more user stuff
}
```

## Other features

```php

// Validate without throwing exception.
// imagine you are importing users from an old system,
// setting all unsupported roles to GUEST:

$role = UserRole::isValidValue($row['role']) ? $row['role'] : UserRole::GUEST;
    
// Retrieve all possible values.
// Assign random color to a shape

$values = Color::getPossibleValues();
$shape->setColor($values[mt_rand(0, count($values)-1)]); 
```
