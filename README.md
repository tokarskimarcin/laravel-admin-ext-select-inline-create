laravel-admin-ext/SelectInlineCreate
======
![preview](preview-field.png)
Use select field to create entity if not exists. Created entity is selected immediately.
## Requires
- "php": ">=7.2.0",
- "encore/laravel-admin": "~1.6"
- "tokarskimarcin/laravel-admin-ext-modal-form": "^0.1"

## Installation
### Publishing
Execute command below to publish package. 
It will copy vendor resources to your application public directory.
~~~
php artisan admin:select-inline-create:publish
~~~
### Update
To update/overwrite assets of package add ```--force``` option to publishing command.

## Documentation
### Usage
SelectInlineCreate field can be used by executing method ```selectInlineCreate``` on Admin/Form.
```php
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;

Admin::form(new Administrator(), function (Form $form){
    $form->selectInlineCreate('manager', 'Manager');
    ...;
});
```

While entity is created it looks for the option by searching url with `id` parameter in query string.
Use `SelectResponse` class and static function `get` to return proper response.
```php
use Encore\SelectInlineCreate\Form\SelectResponse;
use Illuminate\Support\Facades\Request;

class SearchController{
    public function search(){
        $id = Request::offsetGet('id');

        // SelectResponse::get($entity, $callback)
        // $entity can be null, then SelectResponse will return suitable message
        // in $callback return array with 'id' and 'text' keys. 
        // js will create an option based on this

        return SelectResponse::get(
            Administrator::query()->find($id),
            function(Administrator $administrator){
                return ['id' => $administrator->id, 'text' => $administrator->name];
            });
    }
}

```
### Methods
SelectInlineCreate has same methods as regular Select from Admin

#### 1. `setSearchUrl`
If `ajax(...)` function it's not used so `setSearchUrl` should be used.
```php
//Example
$form->selectInlineCrate(...)
    ->setSearchUrl(route('manager.search'))
    ->options(...);
```
If ```ajax(...)``` is used then `setSearchUrl` is executed inside of ajax and searching url is the same as ajax.
```php
$form->selectInlineCrate(...)
    ->ajax(route('manager.search'));
```
Search url can be overwritten if it's set by ajax function. To do that `setSearchUrl` must be executed after `ajax`.
```php
$form->selectInlineCrate(...)
    ->ajax(route('manager.search-by-query'))
    ->setSearchUrl(route('manager.search-by-id'));
```
