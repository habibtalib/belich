<belich::datalist
    :field="$field"
    :value="$field->responseArray[$field->value] ?? $field->value ?? null"
    :id="$field->id"
    :key="$field->uriKey"
    :store="$field->store ?? null"
    :min="$field->minChars"
>
</belich::datalist>
