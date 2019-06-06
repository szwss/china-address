## 中国城市区划

### 说明
1. 一个关于 Laravel 的 中国行政区: 省份 城市 区县 乡镇 四级联动数据表生成,数据来源于权威机构:民政部和国家统计局.
民政部、国家统计局：
中华人民共和国民政部-中华人民共和国行政区划代码
中华人民共和国国家统计局-统计用区划和城乡划分代码
中华人民共和国国家统计局-统计用区划代码和城乡划分代码编制规则

### 本项目已更新至：
2018年统计用区划代码和城乡划分代码（截止时间：2018-10-31，发布时间：2019-01-31）

### 使用

发布migration文件 并填充数据

```
artisan vendor:publish --provider="Szwss\ChinaAddress\ChinaAddressServiceProvider"
```
```
php artisan migrate

php artisan city:seed
```

创建City model

```
php artisan make:model City -c
```

City model 中 使用 CityTrait

```
namespace App;

use Illuminate\Database\Eloquent\Model;
use Szwss\ChinaAddress\CityTrait;

class City extends Model
{
    use CityTrait;

    public $timestamps = false;

    protected $primaryKey = 'code';

    protected $fillable = ['code', 'name', 'parent_code'];

    public function getRouteKeyName()
    {
        return 'code';
    }
    
}

```

### trait 方法
parent 父级城市

children 子城市

待完善...