# CodeIgniter4 Frontend
CodeIgniter4 template engine (<a href="https://github.com/eftec/bladeone">BladeOne</a>) and theming (<a href="https://github.com/tattersoftware/codeigniter4-assets/tree/v2.3.0#example">Tatter\Assets</a>)

Run `composer require mjamilasfihani/ci4-frontend` to install this library

Prototype `\CI4\FrontEnd\Engine::initialize($view, [$data])->run()`

Add Meta `\CI4\FrontEnd\Engine::initialize($view, [$data])->meta($meta_from_tags_generator)->run()`

You can set `$view` as namespace and file ext must `.blade.php`