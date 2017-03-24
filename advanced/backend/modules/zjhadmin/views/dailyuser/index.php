<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataDailyUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每日用户数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-user-index">
    <div><h1><?= Html::encode($this->title) ?></h1></div>
    <?php   echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-xs-12 row-block">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'udate',
            [
                'attribute'=>'channel',
                'format'=>'raw',
                'value'=>function($model){
                    return GmChannelInfo::findChannelNamebyid($model->channel);
                },
            ],
            ['label'=>'登录人次/人数/人均次',
            'format'=>'raw',
            'value'=>function($model){
                $str=$model->loginnum.'/'.$model->loginp.'/';
                $str.=$model->loginp==0?0:Yii::$app->formatter->asDecimal($model->loginnum/$model->loginp,1);
                return $str;
            },
            ],
            'activenum',
            ['label'=>'注册(IME)',
            'format'=>'raw',
            'value'=>function($model){
                $str=$model->totalreg;
                 return $str;
            },
            ],
            ['label'=>'活跃/注册(IME)',
                'format'=>'raw',
              'value'=>function($model){
                    $str=$model->regactive.'/'.$model->totalreg.'~';
                    $str.=$model->totalreg==0?0:Yii::$app->formatter->asPercent($model->regactive/$model->totalreg);
                    return $str;
                },
            ], 
            ['label'=>'活跃(所有)',
            'format'=>'raw',
            'value'=>function($model){
//                $str = $model->allregactive ;
                return $str;
            },
            ],
            ['label'=>'注册(所有)',
            'format'=>'raw',
            'value'=>function($model){
//                $str = $model->allreg;
                return $str;
            },
            ],
            ['label'=>'活跃/注册(所有)',
                'format'=>'raw',
              'value'=>function($model){
//                    $str = $model->allregactive.'/'.$model->allreg.'~';
//                    $str.=$model->allreg==0?0:Yii::$app->formatter->asPercent($model->allregactive/$model->allreg);
                    return $str;
                },
            ],

        ],
    ]); ?>
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.data-user').addClass("active");
    $('.data-user').parent('ul').parent('li').addClass("active open");
});
</script>