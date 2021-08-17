DataRouter
==========

Simple library to route data based on nested routing rules

## Use-cases:

* Advanced alert/support routing based on schedules, escalation, priorities, etc
* Q/A routing
* Self-service
* On-call scheduling

## Concepts

Using the DataRouter library you create a nested tree structure of Routes.

Every Route has a name, expression (for matching), and optionally child routes and output data.

The expressions are evaluated hierarchically using the [Symfony Expression Language Component](https://symfony.com/doc/current/components/expression_language.html) allowing for arbitrarily complex routing rules.

You can pass in your own "ExpressionLanguage" instance to support your own custom functions to enrich your expressions.

## Example

Check `example/example.php` for a simple example for a common usage scenario:

1. Loading routes from a YAML config file (included `test-routes.yaml`)
2. Instantiating a custom ExpressionLanguage instance with a custom method
3. Instantiating a Router
4. Routing / output
5. Logging / debugging

```sh
php example/example.php
```

## License

MIT. Please refer to the [license file](LICENSE) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!