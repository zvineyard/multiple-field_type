# Multiple Field Type

*anomaly.field_type.multiple*

#### A multiple relationship field type.

The multiple field type provides an HTML multi-select input for a related model.

## Configuration

- `handler` - the class string of the options handler
- `related` - the class string of the related model
- `title` - the related column to use as the option title
- `min` - any integer representing the minimum allowed selections
- `max` - any integer representing the maximum allowed selections
 
The handler will default to a class packaged with the field type. The title option will default to the model's title column.

#### Example

	config => [
	    'options' => [
	        'related' => 'Anomaly\UsersModule\User\UserModel',
            'title' => 'username',
            'min' => 5,
            'max' => 10
	    ]
	]
