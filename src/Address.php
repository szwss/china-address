<?php

namespace Szwss\ChinaAddress;

use Illuminate\Database\Eloquent\Model;
use Szwss\ChinaAddress\AddressTrait;

class Address extends Model
{
    use AddressTrait;
    
    public $timestamps = false;

    protected $primaryKey = 'code';

    protected $fillable = ['code', 'name', 'name_pinyin', 'parent_code'];

    public function getRouteKeyName()
    {
        return 'code';
    }

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {

            //20190604如果 code 小于等于 4 位时才执行
            if(strlen($model->code) <= 6) {
                $pinyin = \Pinyin::abbr($model->name,'');
                $model->name_pinyin = $pinyin;
            }

        });
    }
}