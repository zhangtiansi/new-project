<?php
/**
 * Write Asset for Echarts.
 */

namespace app\assets;

use yii\web\AssetBundle;

class EchartsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/echarts/build/dist';
    public $js = [
        'echarts.js',
    ];
}