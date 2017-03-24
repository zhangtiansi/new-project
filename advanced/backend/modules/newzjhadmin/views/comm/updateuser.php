<!-- <div class="modal fade" id="tagaboutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> -->
    <div style="width:70%;height:200px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">管理员名称:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="username" style="width: 304px;" value="<?php echo $user->username?>"/>
                            <input type="hidden" name="id" value="<?php echo $user->id?>"/>
                        </div>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label for="inputSales1" class="col-sm-2 control-label">用户显示名称:</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input class="form-control" type="text" id="inputSales1" name="userdisplay" style="width: 304px;" value=""/>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">用户显示名称:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales2" name="userdisplay" style="width: 304px;" value="<?php echo $user->userdisplay?>"/>
                            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">邮箱:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales5" name="email" style="width: 304px;" value="<?php echo $user->email?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">密码:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="inputSales3" name="password1" style="width: 304px;" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">确认密码:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="inputSales4" name="password2" style="width: 304px;" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">角色:</label>
                        <?php foreach($list as $value):?>
<!--                            <div class="checkbox">-->
<!--                                <div for="inputSales1" class="col-sm-2 control-label">-->
                                    <input type="checkbox" name="role_id[]" value="<?php echo $value->id?>"  <?php echo $user_roles_id !='' && in_array($value->id, $user_roles_id) ? 'checked' : ''?>>
                                    <?php echo $value->name?>
<!--                                </div>-->
<!--                            </div>-->
                        <?php endforeach;?>
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
        if(inputSales1 == '' || inputSales2 == ''){
            $("#error_message").html('请将参数填写完');
            return false;
        }
        if(inputSales3 != inputSales4){
            $("#error_message").html('两次密码输入不一致');
            return false;
        }
        $.ajax({
            url : "/newzjhadmin/user/update",
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
    var username = $("#inputSales1").val();
    $("#inputSales1").blur(function(){
        var name = $("#inputSales1").val();
        if(name == ''){
            return false;
        }
        if(name != username){
            $.get("/newzjhadmin/comm/finduser",{'name':name},function(data){
                if(data != '0'){
                    alert('该管理员以添加');
                    $("#inputSales1").val('');
                }
            })
        }
    })
    var user_display = $("#inputSales2").val();
    $("#inputSales2").blur(function(){
        var name = $("#inputSales2").val();
        if(name == ''){
            return false;
        }
        if(user_display == name){
            return false;
        }
        $.get("/newzjhadmin/comm/finduserdisplay",{'display_name':name},function(data){
            if(data != '0'){
                alert('该名称以添加');
                $("#inputSales2").val('该名称已存在');
            }
        })
    })
</script>