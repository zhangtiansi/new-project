<?php if (isset($gamecard)):?>
<div class="c-om">
        <div class="c-mobile">
            <div class="cm-tl">
                选择游戏卡类型
            </div>
            <div class="cg-lis"  id="cm-lis">
                <div class="cg-ul">
                    <div class="cg-li">
                        <i class="cg-li1"  ptype="SNDACARD"></i>
                    </div>
                    <div class="cg-li">
                        <i class="cg-li2" ptype="JIUYOU"></i>
                    </div>
                </div>
                <div class="cg-ul">
                    <div class="cg-li">
                        <i class="cg-li11" ptype="TIANHONG"></i>
                    </div>
                    <div class="cg-li">
                        <i class="cg-li4" ptype="NETEASE"></i>
                    </div>
                </div>
                <div class="cg-ul">
                    <div class="cg-li">
                        <i class="cg-li5" ptype="QQCARD"></i>
                    </div>
                    <div class="cg-li">
                        <i class="cg-li6" ptype="SOHU"></i>
                    </div>
                </div>
                <div class="cg-ul">
                    <div class="cg-li">
                        <i class="cg-li7" ptype="WANMEI"></i>
                    </div>
                    <div class="cg-li">
                        <i class="cg-li8" ptype="ZONGYOU"></i>
                    </div>
                </div>
                <div class="cg-ul">
                    <div class="cg-li">
                        <i class="cg-li9" ptype="TIANXIA"></i>
                    </div>
                    <div class="cg-li"></div>
                </div>
            </div>
        </div>
    </div>
<?php else :?>
<div class="c-om">
        <div class="c-mobile">
            <div class="cm-tl">
                选择手机卡类型
            </div>
            <div class="cm-lis" id="cm-lis">
                <div class="cm-li">
                    <i class="cm-li1" ptype="SZX"></i>
                </div>
                <div class="cm-li">
                    <i class="cm-li2" ptype="UNICOM"></i>
                </div>
                <div class="cm-li">
                    <i class="cm-li3"  ptype="TELECOM"></i>
                </div>
            </div>
        </div>
</div>
<?php endif;?>
    
    
<script type="text/javascript">
(function(window){
    var qstr = '<?php echo Yii::$app->getRequest()->getQueryString()?>';
    var lis = document.getElementById('cm-lis'); 
    lis.addEventListener('click',function(e){
        var target = e.target;
        var tagName = target.tagName.toLowerCase();
        if(tagName != 'i'){
            return;
        }
        var ptype=target.getAttribute('ptype');
        window.location.href = window.location.href+"&ptype="+ptype;
    }); 
})(window);
</script>