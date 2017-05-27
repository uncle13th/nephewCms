<?php
/**
 * Created by PhpStorm.
 * User: uncle13th
 * Date: 2017/5/27
 * Time: 23:46
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected $guarded = [];

    protected static $instances = [];

    public static function  getInstance($type = 'default',$attributes = [])
    {
        if (empty(static::$instances[$type])) {
            static::$instances[$type] = new static($attributes);
        }
        return static::$instances[$type];
    }

    function __construct(array $attributes = []) {
        parent::__construct($attributes);

    }

    public function freshTimestamp() {
        return time();
    }

    public function fromDateTime($value) {
        return $value;
    }

    // Uncomment, if you don't want Carbon API on SELECTs
    protected function asDateTime($value) {
        return $value;
    }

    public function getDates() {
        // $defaults = [static::CREATED_AT, static::UPDATED_AT];
        $defaults = [];
        return $this->timestamps ? array_merge($this->dates, $defaults) : $this->dates;
    }

    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }


}