<!-- <div class="modal fade" id="tagaboutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> -->
    <div style="width:70%;height:200px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">角色:</label>
                        <div class="col-sm-5 formControls">
                            <input class="form-control" type="text" id="inputSales1" name="name" style="width: 304px;" placeholder="填写范围4-16个字符" datatype="*4-16" value=""/>
                        </div>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label for="inputSales1" class="col-sm-2 control-label">用户显示名称:</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input class="form-control" type="text" id="inputSales1" name="userdisplay" style="width: 304px;" value=""/>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">角色名称:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales2" name="display_name" style="width: 304px;" value=""/>
                            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        </div>
                    </div>
                    <div class="row">
                        <label for="inputSales1" class="col-sm-2 control-label">权限:</label>
                        <div style="width: 577px; padding-left: 120px;">
                            <?php foreach($list as $value):?>
                                <div class="checkbox">
                                    <label style="color: rgb(159,159,159);font-size: 15px;font-weight:bold">
                                        <input type="checkbox" name="permission_id[]" value="<?php echo $value->id?>">
                                        <?php echo $value->display_name.'---------'.$value->route?>
                                    </label>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </form>  
            </div>
            <div class="modal-footer">
                <span id="error_message" style="color: red"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel()">取消</button>
                <button type="button" class="btn btn-primary" onclick="save_update()">保存</button>
            </div>
        </div>
    </div>
<!-- </div> -->
<script type="text/javascript">
    function save_update(){
        var inputSales1 = $("#inputSales1").val();
        var inputSales2 = $("#inputSales2").val();
        var inputSales3 = $("#inputSales3").val();
        var inputSales4 = $("#inputSales4").val();
        if(inputSales1 == '' || inputSales2 == '' || inputSales3 == '' || inputSales4 == ''){
            $("#error_message").html('请将参数填写完');
            return false;
        }
        $.ajax({
            url : "/newzjhadmin/roles/create",
            type : "POST",
            data : $( '.form-horizontal').serialize(),
            success : function(data) {
                var index = parent.layer.getFrameIndex(window.name);
                parent.location.replace(parent.location.href);
                parent.layer.close(index);
            },
            error : function(data) {
                alert("修改失败！");
            }
        });
    }

    function cancel(){
        var index = parent.layer.getFrameIndex(window.name);
        parent.location.replace(parent.location.href);
        parent.layer.close(index);
    }
    $("#inputSales1").blur(function(){
        var name = $("#inputSales1").val();
        if(name == ''){
            return false;
        }
        $.get("/newzjhadmin/comm/rolesfind",{'name':name},function(data){
            if(data != '0'){
                alert('该角色已存在');
                $("#inputSales1").val('');
            }
        })
    })
    $("#inputSales2").blur(function(){
        var name = $("#inputSales2").val();
        if(name == ''){
            return false;
        }
        $.get("/newzjhadmin/comm/rolesfind",{'display_name':name},function(data){
            if(data != '0'){
                alert('该名称已存在');
                $("#inputSales2").val('');
            }
        })
    })
</script>