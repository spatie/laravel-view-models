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

    protected $view = '';

    public function toArray(): array
    {
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

        $publicMethods = collect($class->getMethods(ReflectionMethod::IS_PUBLIC));

        return $publicMethods
            ->reject(function (ReflectionMethod $method) {
                return $this->shouldIgnore($method->getName());
            })
            ->mapWithKeys(function (ReflectionMethod $method) {
                return [$method->getName() => $this->createVariable($method)];
            });
    }

    protected function shouldIgnore(string $methodName): bool
    {
        if (Str::startsWith($methodName, '__')) {
            return false;
        }

        return in_array($methodName, $this->ignoredMethods());
    }

    protected function ignoredMethods(): array
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
