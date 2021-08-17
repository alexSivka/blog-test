<?php
/**
 * simple model
 */

namespace App\Models;

use App\Components\DB;

class Comment
{

    /**
     * model attributes
     * @var $data array
     */
    protected array $data = [
        'name' => '',
        'email' => '',
        'title' => '',
        'text' => 0
    ];

    /**
     * attribute validate rules
     * @var $validateRules array|string[]
     */
    protected array $validateRules = [
        'name' => 'emptyValidate',
        'email' => 'emailValidate',
        'title' => 'emptyValidate',
        'text' => 'emptyValidate'
    ];

    /**
     * @var $errors array
     */
    public array $errors = [];

    /**
     * Comment constructor.
     * @param array $input
     */
    function __construct($input = [])
    {
        foreach ($input as $key => $value) {
            if (isset($this->data[$key])) $this->data[$key] = trim($value);
        }
        $this->date = date('Y-m-d H:i:s');
    }

    /**
     * @param string $direction sort direction
     * @return array
     */
    public function getAll(string $direction = 'desc'): array
    {
        $db = DB::getInstance();
        return $db->query("SELECT * FROM comments ORDER BY id " . $direction);
    }

    /**
     * saves comment into database
     * @return void
     */
    public function save() :void
    {
        $sql = "INSERT INTO comments (name, email, title, text, date) VALUES (?, ?, ?, ?, ?)";
        $pdo = DB::getInstance()->getPDO();
        $pdo->prepare($sql)
            ->execute([
                $this->name,
                $this->email,
                $this->title,
                $this->text,
                date('Y-m-d H:i:s')
            ]);
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->validateRules as $key => $method) {
            if (!$this->$method($this->data[$key])) {
                $this->errors[$key] = $key;
            }
        }
        return !$this->errors;
    }

    /**
     * @param $value
     * @return bool
     */
    private function emptyValidate($value): bool
    {
        return $value !== '';
    }

    /**
     * @param $value
     * @return bool
     */
    private function emailValidate($value): bool
    {
        return strpos($value, '@') && strpos($value, '.');
    }

    /**
     * magic method for getting model attribute
     * @param $key
     * @return mixed|null
     */
    function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * returns all attributes as array
     * @return array
     */
    function all(): array
    {
        return $this->data;
    }
}
