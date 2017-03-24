<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script src="/css/jquery.event.swipe.js"></script>
<script src="/css/unslider.min.js"></script>
<link rel="stylesheet" href="/css/dl.css">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?> 
</head>
<body style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;">
    <?php $this->beginBody() ?>
        <div class="container" style="text-align: center">
        <?= $content ?>
        </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
