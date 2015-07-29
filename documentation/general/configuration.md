# Configuration

**Example Definition:**

```
protected $fields = [
    'example' => [
        'type'   => 'anomaly.field_type.multiple',
        'config' => [
            'related' => 'Anomaly\UsersModule\User\UserModel',
            'min'     => 1,
            'max'     => 10,
            'handler' => 'Anomaly\MultipleFieldType\MultipleFieldTypeOptions@handle'
        ]
    ]
];
```

### `related`

The class string of the related model.

### `min`

The minimum number of relations allowed. By Default no minimum is enforced.

### `max`

The maximum number of relations allowed. By Default no maximum is enforced.

### `handler`

The options handler callable string. Any valid callable class string can be used. The default value is `'Anomaly\MultipleFieldType\MultipleFieldTypeOptions@handle'`.

The handler is responsible for setting the available options on the field type instance.

**NOTE:** This option can not be set through the GUI configuration. 
