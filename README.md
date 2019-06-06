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

php artisan address:seed
```

创建Address model

```
php artisan make:model Address -c
```

Address model 中 使用 AddressTrait

```
namespace App;

use Illuminate\Database\Eloquent\Model;
use Szwss\ChinaAddress\AddressTrait;

class Address extends Model
{
    use AddressTrait;

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
parent() 父级地址

children() 子地址

getFullPath($joiner) 获取完整的地址字符串,$joiner可选参数,地址字符串的拼接符,默认为' '

allChildren() 获取所有的用户,包含各级的children

待完善...