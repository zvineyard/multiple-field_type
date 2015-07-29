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
        ]
    ]
];
```

### `related`

The namespaced related model

### `min`

The minimum number of relations required

### `max`

The maximum number of relations allowed
