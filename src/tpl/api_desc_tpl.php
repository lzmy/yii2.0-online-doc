<?php
echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{$service} - 在线接口文档 - {$projectName}</title>

    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/semantic.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/table.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/container.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/message.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/label.min.css">
    <script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
</head>

<body>

<br /> 

    <div class="ui text container" style="max-width: none !important;">
        <div class="ui floating message">

EOT;

echo "<h2 class='ui header'>接口：$service</h2><br/> <span class='ui teal tag label'>$description</span>";

/**
 * 接口说明 & 接口参数
 */
echo <<<EOT
            <div class="ui raised segment">
                <span class="ui red ribbon label">接口说明</span>
                <div class="ui message">
                    <p>{$descComment}</p>
                </div>
            </div>
            <h3>接口参数</h3>
            <table class="ui red celled striped table" >
                <thead>
                    <tr><th>参数名字</th><th>类型</th><th>是否必须</th><th>说明</th><th>其他</th></tr>
                </thead>
                <tbody>
EOT;

$typeMaps = array(
    'string' => '字符串',
    'int' => '整型',
    'float' => '浮点型',
    'boolean' => '布尔型',
    'date' => '日期',
    'array' => '数组',
    'fixed' => '固定值',
    'enum' => '枚举类型',
    'object' => '对象',
);

foreach ($rules as $key => $rule) {
    $name = isset($rule['1'])?ltrim($rule['1'], '$'):'';
    if (!isset($rule['0'])) {
        $rule['type'] = 'string';
    }
    $type = isset($typeMaps[$rule[0]]) ? $typeMaps[$rule[0]] : $rule[0];
    $content_require_desc_String = isset($rule[2])?trim($rule[2], '|'):'';
    $content_require_desc_Arr = explode('|', $content_require_desc_String);
    $content = isset($content_require_desc_Arr[0])?$content_require_desc_Arr[0]:'无';
    $require = isset($content_require_desc_Arr[1]) && $content_require_desc_Arr[1]=='yes'?'<font color="red">必须</font>':'可选';
    $desc = isset($content_require_desc_Arr[2])?htmlentities($content_require_desc_Arr[2]):'无';

    echo "<tr><td>$name</td><td>$type</td><td>$require</td><td>$content</td><td>$desc</td></tr>\n";
}

/**
 * 返回结果
 */
echo <<<EOT
                </tbody>
            </table>
            <h3>返回结果</h3>
            <!--<table class="ui green celled striped table" >-->
                <!--<thead>-->
                    <!--<tr><th>返回字段</th><th>类型</th><th>说明</th></tr>-->
                <!--</thead>-->
                <!--<tbody>-->
EOT;
//
//foreach ($returns as $item) {
//    $name = $item[1];
//    $type = isset($typeMaps[$item[0]]) ? $typeMaps[$item[0]] : $item[0];
//    $detail = $item[2];
//
//    echo "<tr><td>$name</td><td>$type</td><td>$detail</td></tr>";
//}

echo <<<EOT
            <!--</tbody>-->
        <!--</table>-->
EOT;

echo <<<EOT
        <span class="ui red ribbon label">Response</span>
        <div class="ui message">
        <pre>
EOT;
foreach ($examples as $example) {
    echo $example.PHP_EOL;
}
echo <<<EOT
        </pre>
        </div>
EOT;

/**
 * 异常情况
 */
if (!empty($exceptions)) {
    echo <<<EOT
            <h3>异常情况</h3>
            <table class="ui red celled striped table" >
                <thead>
                    <tr><th>错误码</th><th>错误描述信息</th>
                </thead>
                <tbody>
EOT;

    foreach ($exceptions as $exItem) {
        $exCode = $exItem[0];
        $exMsg = isset($exItem[1]) ? $exItem[1] : '';
        echo "<tr><td>$exCode</td><td>$exMsg</td></tr>";
    }

    echo <<<EOT
            </tbody>
        </table>
EOT;
}

/**
 * 返回结果
 */
echo <<<EOT
<h3>
    请求模拟 &nbsp;&nbsp;
</h3>
EOT;


echo <<<EOT
<table class="ui green celled striped table" >
    <thead>
        <tr><th>参数</th><th>是否必填</th><th>值</th></tr>
    </thead>
    <tbody id="params">
EOT;
foreach ($rules as $key => $rule){
    $name = ltrim($rule['1'], '$');
    if (!isset($rule['type'])) {
        $rule['type'] = 'string';
    }
    $type = isset($typeMaps[$rule[0]]) ? $typeMaps[$rule[0]] : $rule[0];
    $content_require_desc_String = isset($rule[2])?trim($rule[2], '|'):'';
    $content_require_desc_Arr = explode('|', $content_require_desc_String);
    $content = isset($content_require_desc_Arr[0])?$content_require_desc_Arr[0]:'无';
    $require = isset($content_require_desc_Arr[1]) && $content_require_desc_Arr[1]=='yes'?'<font color="red">必须</font>':'可选';
    $desc = isset($content_require_desc_Arr[2])?$content_require_desc_Arr[2]:'无';
    $inputType = (isset($rule['type']) && $rule['type'] == 'file') ? 'file' : 'text';
    echo <<<EOT
        <tr>
            <td>{$name}</td>
            <td>{$require}</td>
            <td><input name="{$name}" value="" placeholder="{$desc}" style="width:100%;" class="C_input" type="$inputType"/></td>
        </tr>
EOT;
}
echo <<<EOT
    </tbody>
</table>
<div style="display: flex;align-items:center;">
    <select name="request_type" style="font-size: 14px; padding: 2px;">
        <option value="POST">POST</option>
        <option value="GET">GET</option>
    </select>
EOT;
//$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://';
//$url = $url . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');
//$url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
$url = \Yii::$app->urlManager->createAbsoluteUrl("{$service}");
echo <<<EOT
&nbsp;<input name="request_url" value="{$url}" style="width:500px; height:24px; line-height:18px; font-size:13px;position:relative; padding-left:5px;margin-left: 10px"/>
    <input type="submit" name="submit" value="发送" id="submit" style="font-size:14px;line-height: 20px;margin-left: 10px "/>
</div>
EOT;

/**
 * JSON结果
 */
echo <<<EOT
<div class="ui blue message" id="json_output">
</div>
EOT;

/**
 * 底部
 */
$_csrf = \Yii::$app->request->getCsrfToken();
echo <<<EOT
        <div class="ui blue message">
          <strong>温馨提示：</strong> 此接口参数列表根据后台代码自动生成，可将 ?r= 改成您需要查询的接口/服务
        </div>
        <!--<p>&copy; Powered  By <a href="http://www.phalapi.net/" target="_blank">PhalApi </a><span id="version_update"></span></p>-->
        </div>
    </div>
    <script type="text/javascript">
        function getData() {
            var data={};
            $("td input").each(function(index,e) {
                if ($.trim(e.value)){
                    data[e.name] = e.value;
                }
            });
            if ($("select").val() == 'POST') {
                data['_csrf'] = "$_csrf";
            }
            return data;
        }
        
        $(function(){
            $("#json_output").hide();
            $("#submit").on("click",function(){
                $.ajax({
                    url:$("input[name=request_url]").val(),
                    type:$("select").val(),
                    data:getData(),
                    success:function(res,status,xhr){
                        console.log(xhr);
                        var statu = xhr.status + ' ' + xhr.statusText;
                        var header = xhr.getAllResponseHeaders();
                        var json_text = JSON.stringify(res, null, 4);    // 缩进4个空格
                        $("#json_output").html('<pre>' + statu + '<br/>' + header + '<br/>' + json_text + '</pre>');
                        $("#json_output").show();
                    },
                    error:function(error){
                        console.log(error)
                    }
                })
            })

        })

        // $('#version_update').html('&nbsp; | &nbsp; <a target="_blank" href="http://www.liyangweb.com"><strong>kaopur移植至Yii2</strong></a>');
    </script>
</body>
</html>
EOT;

