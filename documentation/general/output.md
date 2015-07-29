# Output

This field type returns the related objects in a collection by default. You can access the objects like normal.

**Examples:**

```
// Twig usage
{% for related in entry.example %}
    The entry {{ related.id }} has a title: {{ entry.title }}.
{% endfor %}

// API usage
foreach ($entry->example as $k => $related) {
    echo "The entry {$related->id} has a title: {$file->title}";
}
```
