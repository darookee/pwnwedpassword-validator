# haveibeenpwned Validator Constraint

This Validator uses curl to query the https://haveibeenpwned.com API for the
first 5 chars of the SHA1 of a value, that is to be validated. If it finds the
exact SHA1 hash in the response it will add a validation error.

## Usage

```
use R\Validator\Constraints as RAssert;

class MyEntity {

    /**
    * @RAssert\PwnedPasswords()
    **/
    var $password;
}
```
