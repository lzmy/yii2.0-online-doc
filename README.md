## Home page ##
```
    本扩展包是根据  https://github.com/kaopur/yii2-doc-online 修改而来
    在此首先感谢原作者
    可能有人疑问，为什么你要克隆人家的项目，这么的无赖 xxx
    原因：
     1.原扩展包的代码注释风格
     2.原扩展包对嵌套模块的支持有些问题
    基于以上的情况，只能很无耻的 在原作者的项目上做一些修改了
```
```
How to install?

composer require phpdoc/yii2.0-online-doc
```

### How to use? ###
1. Install the library.
2. Create a new module config to web.php like this:
    ```
    'modules' => [
        'doconline' => [
            'class' => 'phpdoc\online\Module',
            'defaultRoute' => 'index', //默认控制器
            'appControllers' => true, //是否检测app\controllers命名空间下的控制器
            'suffix' => '', //api后缀
            'prefix' => '', //api前缀
            'modules' => [  //需要生成文档的模块命名空间
                'app\modules\admin\Module',
            ],
        ],
    ],
    ```
3. Open the url from you browser. `http://url.com?r=doconline`

### Example ###
#### The code like this: ####
```
/**
 * 这是一个测试的Api
 * @desc 列举所有的注释格式
 * @param string $user_type |用户类型|yes|其他说明|
 * @param int $sex |性别|no|0:不限 1:男 2:女|
 * @return 
 * {
 *    "success": 1,
 *    "message": "success",
 *    "code": 200,
 *    "data": {
 *        "points": "1000", 总凑集的红积分
 *        "donors": "11"    总捐赠人数
 *    }
 * }
 * @exception 400 参数传递错误
 * @exception 500 服务器内部错误
 */
public function actionDemoapi($user_type, $sex)
{
    $result = [
        'status' => 0,
        'list' => [
            'id' => 1,
            'name' => 'kaopur'
        ],
        'msg' => 'OK'
    ];
    return \yii\helpers\Json::encode($result);
}
```
#### Show ####
![image](https://raw.githubusercontent.com/kaopur/yii2-doc-online/master/imgs/desc_page.png)