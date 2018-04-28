<?php
/**
 * IndexController.php
 * @author  Lee <lizf@yunlianguoji.com>
 * @license http://www.yunlianhui.com/license/
 * @copyright www.yunlianhui.com (c) 2018
 * Date: 2018/4/28
 * Time: 11:18
 */

namespace phpdoc\online;

use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * @var bool 是否检测基础控制器
     */
    public $appControllers = true;
    /**
     * @var string 接口前缀
     */
    public $prefix = '';
    /**
     * @var string 接口后缀
     */
    public $suffix = '';
    /**
     * @var array 希望生成文档的模块
     */
    public $modules = [];

    public function actionIndex()
    {
        if ($service = \Yii::$app->request->get('service')) {
            $api = new ApiDesc();
            $api->appControllers = $this->module->appControllers;
            $api->suffix = $this->module->suffix;
            $api->prefix = $this->module->prefix;
            $api->render();
        } else {
            $api = new ApiList();
            $api->appControllers = $this->module->appControllers;
            $api->suffix = $this->module->suffix;
            $api->prefix = $this->module->prefix;
            $api->modules = $this->module->modules;
            $api->render($api->modules);
        }
    }
}