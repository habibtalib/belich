<belich::datalist
    :item="$field"
    :value="$field->response[$field->value] ?? $field->value ?? null"
>
</belich::datalist>
