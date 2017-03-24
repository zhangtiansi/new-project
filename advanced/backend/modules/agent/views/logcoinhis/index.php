<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCoinHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '金币记录(汇总单局)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-coin-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//             'id',
            ['attribute'=>'uid',
                'format'=>'raw',
                'value'=>function($model){
                    $hx="  ";
                    $hx.= "UID:".$model->uid.Html::a("昵称：".$model->player->name,'/agent/player/view?id='.$model->uid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->uid]);
                    if (is_object($model->player)){
                        $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                    }
                    return $hx;
            }],
            
            ['attribute'=>'change_type',
               'value'=>'changeType.c_name'],
            'change_before',
            'change_coin',
            'change_after',
            'coin_box',
            ['label'=>'总身家',
                'value'=>function($model){
                $x=  $model->change_after+$model->coin_box;
                if ($x>100000000){
                    $x =  Yii::$app->formatter->asDecimal($x/100000000,4)."亿";
                }elseif ($x>10000){
                    $x =  Yii::$app->formatter->asDecimal($x/10000,2)."万";
                }
                return $x;
                },
            ],
            [
                'attribute'=>'game_no',
                'format'=>'raw',
                'value'=>function($model){
                    $hx="  ";
                    if ($model->change_type==1){
                        $hx.= Html::a("<追踪该局『".$model->game_no."==".$model->prop_id."』>",'/agent/logcoin?gameno='.$model->game_no.'&propid='.$model->prop_id,['class'=>'btn btn-minier btn-purple modify']);
                        $hx.= Html::a("<追踪该桌『".$model->game_no."』>",'/agent/logcoin?gameno='.$model->game_no,['class'=>'btn btn-minier btn-yellow modify']);
                    }elseif ($model->change_type==30){
                        $hx.= Html::a("<本场百人记录『".$model->game_no."』>",'/agent/logwarrecord?gameno='.$model->game_no,['class'=>'btn btn-minier btn-blue modify']);
                    }elseif ($model->change_type==14){
                        if (is_object($model->dicerecord))
                        {
                            $hx .= '点数：['.$model->dicerecord->point1.']['.$model->dicerecord->point2.']['.$model->dicerecord->point3.']';
                        }
                    }
                    return $hx;
                }
            ],
//             'game_no',
            [
            'attribute'=>'prop_id',
                'format'=>'raw',
                'value'=>function($model){
                        $hx="  ";
                        if ($model->change_type==14){
                            if ($model->prop_id==0){
                                $hx.="发奖金";
                            }elseif (is_object($model->dice)){
                                $hx.="押注门：".$model->dice->dicename;
                            }else {
                                $hx.= $model->prop_id;
                            }
                        }elseif ($model->change_type==30){
                            switch ($model->prop_id)
                            {
                                case 0:
                                    $hx.="坐庄/结算";
                                    break;
                                case 1:
                                    $hx.="恭";
                                    break;
                                case 2:
                                    $hx.="喜";
                                    break;
                                case 3:
                                    $hx.="发";
                                    break;
                                case 4:
                                    $hx.="财";
                                    break;
                                case 31:
                                    $hx.="喜金";
                                    break;
                                case 32:
                                    $hx.="喜金";
                                    break;
                                case 33:
                                    $hx.="喜金";
                                    break;
                                default:
                                    $hx.=$model->prop_id;
                                    break;
                            }
                        }
                        else {
                            $hx= $model->prop_id;
                        }
                        return $hx;
                       }],
//             'prop_id',
            'ctime',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logcoinhis').addClass("active");
    $('.logcoinhis').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>