# View models in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-view-models.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-view-models)
[![Build Status](https://img.shields.io/travis/spatie/laravel-view-models/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-view-models)
[![StyleCI](https://github.styleci.io/repos/147871189/shield?branch=master)](https://github.styleci.io/repos/147871189)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-view-models.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-view-models)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-view-models.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-view-models)

View models provide an abstraction for passing data to views. They allow a better separation of concerns, and provide more flexibility for the developer.

View models are classes used to encapsulate view logic. hey help scale large applications with lots of views and view data.

You can read more about the pattern itself [here](https://stitcher.io/blog/laravel-view-models).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-view-models
```

## Usage

A view model is a class where you can put some complex logic for your views. This will make your controller a bit lighter.  You can create a view model by extending the provided `Spatie\ViewModels\ViewModel`.

```php
class PostViewModel extends ViewModel
{
    public function __construct(User $user, Post $post = null)
    {
        $this->user = $user;
        $this->post = $post;
    }
    
    public function post(): Post
    {
        return $this->post ?? new Post();
    }
    
    public function categories(): Collection
    {
        return Category::canBeUsedBy($this->user)->get();
    }
}
```

And used in controllers like so:

```php
class PostsController
{
    public function create()
    {
        $viewModel = new PostFormViewModel(
            current_user()
        );
        
        return view('blog.form', $viewModel);
    }
    
    public function edit(Post $post)
    {
        $viewModel = new PostFormViewModel(
            current_user(), 
            $post
        );
    
        return view('blog.form', $viewModel);
    }
}
```

In a view you can do this:

```blade
<input type="text" value="{{ $post->title }}" />
<input type="text" value="{{ $post->body }}" />

<select>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>
```

All public methods in a view model are automatically exposed to the view. If you don't want a specific method to be available in your view, you can ignore it.

```php
class PostViewModel extends ViewModel
{
    protected $ignored = ['ignoredMethod'];

    // …
    
    public function ignoredMethod() { /* … */ }
}
```

All PHP's built in magic methods are ignored automatically.

#### View models as responses

It's possible to directly return a view model from a controller. 
By default, a JSON response with the data is returned.

```php
class PostsController
{
    public function update(Request $request, Post $post)
    {
        // …
        
        return new PostViewModel($post);
    }
}
```

This approach can be useful when working with AJAX submitted forms.

It's also possible to return a view directly:

```php
class PostsController
{
    public function update(Request $request, Post $post)
    {
        // …
        
        return (new PostViewModel($post))->view('post.form');
    }
}
```

Note that when the `Content-Type` header of the request is set to JSON, 
this approach will also return JSON data instead of a rendered view.

#### Exposing view functions

View models can expose functions which require extra parameters.

```php
class PostViewModel extends ViewModel
{
    public function formatDate(Carbon $date): string
    {
        return $date->format('Y-m-d');
    }
}
```

You can use these functions in the view like so:

```blade
{{ $formatDate($post->created_at) }}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Brent Roose](https://github.com/brendt)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
