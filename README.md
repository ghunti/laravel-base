# Laravel Base

This is a packaged that brings small improvements to the [Laravel] framework.

All the improvements were developed trying to use the most of the framework.
If you want to contribute don't hesitate.

## Installation


```json
{
    "require": {
        "ghunti/laravel-base": "~0.1"
    }
}
```

## Features

### Permission Denied Exception
[Exception/PermissionDeniedException.php]

I like to use exceptions on my controllers to have a cleaner code followed by a bunch of catches, so this is just an exception that I throw whenever a user doesn't have enough permissions or is not logged in.

### Validator
[Validation/Validator.php]

This is an extension to the `Illuminate\Validation\Validator` and adds a single method `passOrFail`.

If the validation fails, the method will create a new `Ghunti\LaravelBase\Exception\ValidatorException` and inject itself into the exception, throwing it.

### Validator Exception
[Exception/ValidatorException.php]

This is an exception that holds the failed validation object. The idea is to use it like this:

```php
use Ghunti\LaravelBase\Exception\ValidatorException;
...
try {
    Validator::make(
        Input::all(),
        array(
            'name' => array(
            'required',
            'unique:table_name',
            ),
        )
    )->passOrFail();

} catch (ValidatorException $e) {
    return Redirect::route('creation_route')
        ->withInput()
        ->withErrors($e->getValidator());
}
```

As you can see, this ways we can retrieve the validator from the exception (`$e->getValidator()`) to use it in any way we want.

### Redirect With Messages
I like the way Laravel redirects the [errors] and makes them available on the views, so I've implemented the same logic for any message with the method `withMessages()`.

```php
    return Redirect::route('some_route')
        ->withMessages(
            array('success' => 'Something worked for a change!!!')
        );
    //or
    return Redirect::route('some_route')
        ->withMessages(
            array('error' => 'Crappy as usual!')
        );
```
Check that i'm passing an array to the `withMessages()` method and I'm even specifying a type for the message so latter on the view I can do:

```php
<?php
    $messageMap = array(
        'information' => 'info',
        'success' => 'success',
        'warning' => 'warning',
        'error' => 'danger',
    );
?>

@foreach ($messageMap as $key => $class)
    @if ($messages->has($key))
        <div class="alert alert-{{ $class }}">
            <ul class="list-unstyled">
            @foreach ($messages->get($key, '<li>:message</li>') as $message)
                {{ $message }}
            @endforeach
            </ul>
        </div>
    @endif
@endforeach
```

### Base Model
[Models/BaseModel.php]

The `BaseModel` is an abstract class that extends `Eloquent` and provides the method `getValidationRules()`. This method will return the validation rules for the current model, and wil cal the `getCreateRules()` method if the current model doesn't exist, or the `getEditRules()`method if it does.

If instead of extendind `Eloquent` you extend the `BaseModel` you end up with the possibility to call the `getValidationRules()` method anywhere in your code and be sure to get the proper validation rules.

```php
try {
    Validator::make(
        Input::all(),
        Model::getValidationRules()
    )
    ->passOrFail();
    ...

//or

try {
    $model = $this->repository->findOrFail($id);
    Validator::make(
        Input::all(),
        $model->getValidationRules()
    )
    ->passOrFail();
    ...
```

### Base Repository
[Repositories/BaseRepository.php]

The `BaseRepository` tries to separate the idea of repository from model/entity since there are some "questions" that should be answered by the repository and others by the model/entity.

The idea is that your repository includes all the methods that can hit the database (or any other storage system) and in some cases even return models.

Imagine that you want to list all your users ordered by their name so you create the `allOrderedByName` method. Instead of implementing this method in the model you implement it in the repository (that will end up calling the model):

```php
public function allOrderedByName($direction = 'asc')
{
    return $this->model->orderBy('name', $direction)->get();
}
```

License
----

MIT

[Laravel]:http://laravel.com
[Exception/PermissionDeniedException.php]:src/Exception/PermissionDeniedException.php
[Validation/Validator.php]:src/Validation/Validator.php
[Exception/ValidatorException.php]:src/Exception/ValidatorException.php
[errors]:http://laravel.com/docs/validation#error-messages-and-views
[Models/BaseModel.php]:src/Models/BaseModel.php
[Repositories/BaseRepository.php]:src/Repositories/BaseRepository.php