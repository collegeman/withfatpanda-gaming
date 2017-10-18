<?php
namespace App\Concerns;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

trait HasMeta {

  private static $columns = [];

  function getCasts()
  {
    return parent::getCasts() + [ 'meta' => 'array' ];
  }

  public function getTableColumns()
  {
    $class = get_class($this);

    if (empty(static::$columns[$class])) {
      static::$columns[$class] = Schema::getColumnListing($this->getTable());
    }

    return static::$columns[$class];
  }

  function setAttribute($key, $value) 
  {
    $columns = $this->getTableColumns();

    // First we will check for the presence of a mutator for the set operation
    // which simply lets the developers tweak the attribute as it is set on
    // the model, such as "json_encoding" an listing of data for storage.
    if ($this->hasSetMutator($key)) {
        $method = 'set'.Str::studly($key).'Attribute';

        return $this->{$method}($value);
    }

    // If an attribute is listed as a "date", we'll convert it from a DateTime
    // instance into a form proper for storage on the database tables using
    // the connection grammar's date format. We will auto set the values.
    elseif ($value && $this->isDateAttribute($key)) {
        $value = $this->fromDateTime($value);
    }

    if ($this->isJsonCastable($key) && ! is_null($value)) {
        $value = $this->castAttributeAsJson($key, $value);
    }

    // If this attribute contains a JSON ->, we'll set the proper value in the
    // attribute's underlying array. This takes care of properly nesting an
    // attribute in the array's value in the case of deeply nested items.
    if (Str::contains($key, '->')) {
        return $this->fillJsonAttribute($key, $value);
    }

    if (!in_array($key, $this->getTableColumns())) {

      $meta = $this->meta;
      $meta[$key] = $value;
      $this->meta = $meta;

    } else {

      $this->attributes[$key] = $value;

    }

    return $this;
  }

  function getRelationValue($key)
  {
    // If the key already exists in the relationships array, it just means the
    // relationship has already been loaded, so we'll just return it out of
    // here because there is no need to query within the relations twice.
    if ($this->relationLoaded($key)) {
        return $this->relations[$key];
    }

    // If the "attribute" exists as a method on the model, we will just assume
    // it is a relationship and will load and return results from the query
    // and hydrate the relationship's value on the "relationships" array.
    if (method_exists($this, $key)) {
        return $this->getRelationshipFromMethod($key);
    }

    if (!in_array($key, $this->getTableColumns())) {

      if (empty($this->meta)) {
        return null;
      }

      if (array_key_exists($key, $this->meta)) {
        return $this->meta[$key];
      }

    }
  }

}