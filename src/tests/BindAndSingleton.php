<?php
require __DIR__ . '/../vendor/autoload.php';

class FirstClass
{
    public $value;
}

class SecondClass
{
    public $value;
}

// Test bind()
$container = new Illuminate\Container\Container();

$container->bind('FirstClass');

$instance = $container->make('FirstClass');
$instance->value = 'test';

$instance2 = $container->make('FirstClass');
$instance2->value = 'test2';

echo "Bind: $instance->value vs. $instance2->value\n";

// Test singleton()
$container->singleton('SecondClass');

$instance = $container->make('SecondClass');
$instance->value = 'test';

$instance2 = $container->make('SecondClass');
$instance2->value = 'test2'; // <--- also changes $instance->value

echo "Singleton: $instance->value vs. $instance2->value\n";