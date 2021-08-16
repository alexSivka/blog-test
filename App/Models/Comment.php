<?php
/**
 * simple model
 */

namespace App\Models;

class Comment
{

    protected array $data = [
        'name'  => '',
        'email' => '',
        'title' => '',
        'text'  => 0,
        'date'  => ''
    ];

    protected array $validateRules = [
        'name'  => 'emptyValidate',
        'email' => 'emailValidate',
        'title' => 'emptyValidate',
        'text'  => 'emptyValidate'
    ];

    public array $errors = [];

    function __construct($input = [])
    {
        foreach ($input as $key => $value) {
            if (isset($this->data[$key])) $this->data[$key] = trim($value);
        }
        $this->date = date('Y-m-d H:i:s');
    }

    // inputs simple validation

    public function validate(): bool
    {
        foreach ($this->validateRules as $key => $method) {
            if (!$this->$method($this->data[$key])) {
                $this->errors[$key] = $key;
            }
        }
        return !$this->errors;
    }

    private function emptyValidate($value): bool
    {
        return $value !== '';
    }

    private function emailValidate($value): bool
    {
        return strpos($value, '@') && strpos($value, '.');
    }

    function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    function all(): array
    {
        return $this->data;
    }
}
