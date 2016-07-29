# Netgen's Site API for eZ Platform


[![Build Status](https://img.shields.io/travis/netgen/ezplatform-site-api.svg?style=flat-square)](https://travis-ci.org/netgen/ezplatform-site-api)
[![Code Coverage](https://img.shields.io/codecov/c/github/netgen/ezplatform-site-api.svg?style=flat-square)](https://codecov.io/gh/netgen/ezplatform-site-api)
[![Downloads](https://img.shields.io/packagist/dt/netgen/ezplatform-site-api.svg?style=flat-square)](https://packagist.org/packages/netgen/ezplatform-site-api)
[![Latest stable](https://img.shields.io/packagist/v/netgen/ezplatform-site-api.svg?style=flat-square)](https://packagist.org/packages/netgen/ezplatform-site-api)
[![License](https://img.shields.io/packagist/l/netgen/ezplatform-site-api.svg?style=flat-square)](https://packagist.org/packages/netgen/ezplatform-site-api)

## Features

- A set of read-only services on top of Repository API, made to transparently resolve correct translation

  - [`LoadService`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/LoadService.php)
  - [`FindService`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/FindService.php)

- New set of aggregate objects, tailored to make buidling websites easier

  - [`Content`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/Values/Content.php)
  - [`ContentInfo`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/Values/ContentInfo.php)
  - [`Location`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/Values/Location.php)
  - [`Node`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/Values/Node.php)
  - [`Field`](https://github.com/netgen/ezplatform-site-api/blob/master/lib/API/Values/Field.php)

## Examples

- Twig

  ```twig
  {% extends noLayout == true ? viewbaseLayout : pagelayout %}
  {% block content %}
    <h1>{{ content.name }} [{{ content.contentInfo.contentTypeIdentifier }}]</h1>
    <h2>{{ content.fields.title.value.text }}</h2>
    {% for identifier, field in content.fields %}
        <h3>[{{ identifier }}]</h3>
        {% if not field.isEmpty() %}
            {{ ng_render_field(field) }}
        {% else %}
            <p>Field is empty.</p>
        {% endif %}
    {% endfor %}
  {% endblock %}
  ```
