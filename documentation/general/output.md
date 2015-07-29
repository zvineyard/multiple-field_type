# Output

This field type returns the rendered markdown content by default.

### Lists

Returns the lists output.

```
// Twig Usage
{% for key, value in entry.example.lists %}
    // Outputs key and value will be the related model
    {{ key }}
    {{ value }}
{% endfor %}

// API usage
foreach($entry->example->lists() as $key => $value) {
    // $key will be the model key
    // $value will be the related model
}
```
