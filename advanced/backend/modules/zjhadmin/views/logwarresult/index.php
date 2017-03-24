<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogWarResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '百人牌型记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-war-result-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'war_id',
            ['attribute'=>'men_1',
              'format'=>'raw',
              'value'=>function($model){
                  return  $model->men_1==2?Html::tag('p',"胜",['style'=>'color:red']):Html::tag('p',"负",['style'=>'color:black']);
                },    
            ],
            ['attribute'=>'men_2',
              'format'=>'raw',
              'value'=>function($model){
                return  $model->men_2==2?Html::tag('p',"胜",['style'=>'color:red']):Html::tag('p',"负",['style'=>'color:black']);
                },    
            ],
            ['attribute'=>'men_3',
              'format'=>'raw',
              'value'=>function($model){
                return  $model->men_3==2?Html::tag('p',"胜",['style'=>'color:red']):Html::tag('p',"负",['style'=>'color:black']);
                },    
            ],
            ['attribute'=>'men_4',
              'format'=>'raw',
              'value'=>function($model){
                return  $model->men_4==2?Html::tag('p',"胜",['style'=>'color:red']):Html::tag('p',"负",['style'=>'color:black']);
                },    
            ],
            'men_card_1',
            'men_card_2',
            'men_card_3',
            'men_card_4',
            'ctme',
            'banker',
            'banker_card',
        ],
    ]); ?>

</div>

<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logwarresult').addClass("active");
    $('.logwarresult').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>