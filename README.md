# View models in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-view-models.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-view-models)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spatie/laravel-view-models/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-view-models.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-view-models)

Have you ever made a controller where you had to do a lot of work to prepare variables to be passed to a view? You can move that kind of work to a so called view model.  In essence, view models are simple classes that take some data, and transform it into something usable for the view.

You'll find a more detailed explanation and some good examples in [this blogpost on Stitcher.io](https://stitcher.io/blog/laravel-view-models).

Laravel's native view composers are not the same as the view models provided by this package. To learn more about the differences head over to [this blogpost on Stitcher.io](https://stitcher.io/blog/laravel-view-models-vs-view-composers).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-view-models.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-view-models)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-view-models
```

## Usage

A view model is a class where you can put some complex logic for your views. This will make your controllers a bit lighter.  You can create a view model by extending the provided `Spatie\ViewModels\ViewModel`.

```php
class PostViewModel extends ViewModel
{
    public $indexUrl = null;

    public function __construct(User $user, Post $post = null)
    {
        $this->user = $user;
        $this->post = $post;
        
        $this->indexUrl = action([PostsController::class, 'index']); 
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
        $viewModel = new PostViewModel(
            current_user()
        );
        
        return view('blog.form', $viewModel);
    }
    
    public function edit(Post $post)
    {
        $viewModel = new PostViewModel(
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

<a href="{{ $indexUrl }}">Back</a>
```

All public methods and properties in a view model are automatically exposed to the view. If you don't want a specific method to be available in your view, you can ignore it.

```php
class PostViewModel extends ViewModel
{
    protected $ignore = ['ignoredMethod'];

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

### Making a new view model

The package included an artisan command to create a new view model.

```bash
php artisan make:view-model HomepageViewModel
```

This view model will have the `App\ViewModels` namespace and will be saved in `app/ViewModels`.

or into a custom namespace, say, `App\Blog`

```bash
php artisan make:view-model "Blog/PostsViewModel"
```

This view model will have the `App\Blog\ViewModels` namespace and will be saved in `app/Blog/ViewModels`.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Brent Roose](https://github.com/brendt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
