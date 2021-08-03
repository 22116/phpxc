# Template

Template consists of two components: `config.yaml`, `template` (directory).
Example can be found in `standard` template [here](../../templates/standard)

## Configuration

Configuration placed in a `config.yaml` file. It's a main place to
wisely build your configuration.

It consists of 2 items `nodes`, `removeEmptyDirectories`.

### Root types

|Name|Type|Description|
|----|----|-----------|
|nodes|List<Node>|Root for the question parser|
|removeEmptyDirectories|Boolean/List|Remove empty directories before executing the postScript's|
|removeEmptyDirectories.ignoreList|Array<`string`>|Array of regexp to ignore while processing removal|

### Types

|Name|Type|Required|Description|
|----|----|--------|-----------|
|Node|Object|-|Separate entity is a console item|
|Node.description|String|+|Exact question|
|Node.type|String|+|One of `text`, `choice`, `multiple`|
|Node<type=`text`>.regexp|String|-|Validation for input string|
|Node<type=`choice/multiple`>.options|Array<`Option`>|+|Available options|
|Option|Object|-|Separate item in option Node types (`choice`, `multiple`)|
|Option.description|String|+|Description|
|Option.extra|Array<Anything>|-|Additional information to pass in template|
|Option.children|Array<Node>|-|Nodes tree|
|<`Node`/`Option`>.<`preScripts`/`postScripts`>|Array<`Script`/`String`>|-|Array of scripts to be executed before or after|
|Script|Object|-|Command settings to execute|
|Script.command|String|+|Command to execute|
|Script.includes|Array<String>|-|Array of nodes which MUST be picked to execute this command|
|Script.excludes|Array<String>|-|Array of nodes which MUST NOT be picked to execute this command|

## Template

Template is an exact directory how end project will look like. It uses Twig engine
to render final items. You can use settings user passed with configuration
from previous step to customize result. \
All configuration parsed to the `nodes` array consists of `Node`s. You can
access this variable in Twig like this:

```yaml
# config.yaml

nodes:
    name:
        type: text
        regexp: '^[^\d]+$'

    vehicle:
        type: multiple
        description: Which transport do you prefer?
        options:
            bicycle: { description: Bicycle, extra: { foo: 'bar' } }
            car: { description: Bicycle }
```

```php
<?php

echo 'My name is {{ nodes['name'].text }}';

{% if nodes['vehicle'] %}
echo 'We have a vehicle';
echo '{{ nodes['vehicle'].description }}';

{% if nodes['vehicle.bicycle'] %}
echo 'Sport is life!';
echo '{{ nodes['vehicle.bicycle'].extra.foo }}';
{% endif %}

{% endif %}
```

Also you can modify the name of each file. Twig also will be parsed there.

### Remove useless files

All files and directories will be removed after the full run if you
turn on `removeEmptyDirectories` configuration option. So,
wrap your file content in a statement if you want to create this file 
only in a specific cases. Empty filenames also will not be created.
