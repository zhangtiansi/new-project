<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmOptactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '运营活动';
$this->params['breadcrumbs'][] = $this->title;

$actlist=[
1=>'不可选',
2=>'充值满送',
3=>'ios满送活动',
4=>'每日登录即送活动',
    5=>'时时乐排名',
    6=>'每日充值单笔6元礼包',
    7=>'特殊牌型',
    8=>'vip送礼',
        9=>'首充指定金额',
            10=>'充值指定金额必送',
            11=>'水浒传指定次数',
            12=>'百人赢四门',
            13=>'普通游戏场满N场送N万9点',
            14=>'时时乐累积押注超过N万次日送N万10点',
            15=>'首日充值满N元次日送N万金币9.30',
        16=>'百人押注排行榜9.30',
        17=>'百人坐庄排行榜9.30',
        18=>'百人盈利排行榜9.30',
        ];
?>
<div class="gm-optact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('创建活动', ['create'], ['class' => 'btn btn-success']) ?>
        
        
    </p>
    <p>普通满送活动 类型2 | 满送活动IOS专享 类型3 | IOS每日登录即送活动 类型4 |时时乐排行奖励  类型5 | 6元礼包 类型6| 豹子我最大 类型7 |VIP尊享好礼 类型8|首充固定金额  类型9|充值指定金额必送 类型10|水浒传指定次数 类型11|百人赢四门 类型12</p>
    <?php 
    print_r($actlist); 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'act_title',
            'act_desc',
//             'act_type',
            [
            'label'=>'活动类型',
            'value'=>function($model){
                    return isset($actlist[$model->act_type])?$actlist[$model->act_type]:$model->act_type;
                }, 
            ],
            'begin_tm',
            'end_tm',
            'standard',
            'diamond',
            'coin',
            'propid',
            'propnum',
            'vcard_g',
            'vcard_s',
            'vcard_c',
            'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.gmoptact').addClass("active");
    $('.gmoptact').parent('ul').parent('li').addClass("active open");
});
</script>