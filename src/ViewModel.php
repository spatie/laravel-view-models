<?php

namespace Spatie\ViewModels;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Response;

class ViewModel implements Arrayable, Responsable
{
    protected $ignore = [];

    protected $view = null;

    public function toArray(): array
    {
        // Add viewmodel?

        return $this
            ->items()
            ->all();
    }

    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse($this->items()->toJson());
        }

        if ($this->view) {
            return response()->view($this->view, $this);
        }

        return new JsonResponse($this->items()->toJson());
    }

    public function view(string $view): ViewModel
    {
        $this->view = $view;

        return $this;
    }

    protected function items(): Collection
    {
        $class = new ReflectionClass($this);

        $methods = collect($class->getMethods(ReflectionMethod::IS_PUBLIC));

        $ignore = $this->ignore();

        return $methods
            ->reject(function (ReflectionMethod $method) use ($ignore) {
                return
                    Str::startsWith($method->getName(), '__')
                    || in_array($method->getName(), $ignore);
            })
            ->mapWithKeys(function (ReflectionMethod $method) {


                return [$method->getName() => $this->createVariable($method)];
            });
    }

    protected function ignore(): array
    {
        return array_merge([
            'toArray',
            'toResponse',
            'view',
        ], $this->ignore);
    }

    protected function createVariable(ReflectionMethod $method)
    {
        if ($method->getNumberOfParameters() === 0) {
            return $this->{$method->getName()}();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }
}
