<?php
/**
 * Module.php
 * @author  Lee <lizf@yunlianguoji.com>
 * @license http://www.yunlianhui.com/license/
 * @copyright www.yunlianhui.com (c) 2018
 * Date: 2018/4/25
 * Time: 14:42
 */

namespace phpdoc\online;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'phpdoc\online';

    public $appControllers = true;
    public $suffix = '';
    public $prefix = '';
    public $modules = [];

    public function init()
    {
        parent::init();
    }
}