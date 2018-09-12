<?php

namespace Spatie\ViewModels;

use Closure;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

abstract class ViewModel implements Arrayable, Responsable
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
            return new JsonResponse($this->items());
        }

        if ($this->view) {
            return response()->view($this->view, $this);
        }

        return new JsonResponse($this->items());
    }

    public function view(string $view): ViewModel
    {
        $this->view = $view;

        return $this;
    }

    protected function items(): Collection
    {
        $class = new ReflectionClass($this);

        $publicProperties = collect($class->getProperties(ReflectionProperty::IS_PUBLIC))
            ->reject(function (ReflectionProperty $property) {
                return $this->shouldIgnore($property->getName());
            })
            ->mapWithKeys(function (ReflectionProperty $property) {
                return [$property->getName() => $this->{$property->getName()}];
            });

        $publicMethods = collect($class->getMethods(ReflectionMethod::IS_PUBLIC))
            ->reject(function (ReflectionMethod $method) {
                return $this->shouldIgnore($method->getName());
            })
            ->mapWithKeys(function (ReflectionMethod $method) {
                return [$method->getName() => $this->createVariableFromMethod($method)];
            });

        return $publicProperties->merge($publicMethods);
    }

    protected function shouldIgnore(string $methodName): bool
    {
        if (Str::startsWith($methodName, '__')) {
            return true;
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

    protected function createVariableFromMethod(ReflectionMethod $method)
    {
        if ($method->getNumberOfParameters() === 0) {
            return $this->{$method->getName()}();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }
}
