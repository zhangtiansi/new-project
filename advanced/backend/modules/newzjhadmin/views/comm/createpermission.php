<!-- <div class="modal fade" id="tagaboutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> -->
    <div style="width:70%;height:200px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">模块名称</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="name" style="width: 304px;" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">显示名称</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales2" name="display_name" style="width: 304px;" value=""/>
                            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">所属菜单</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSales3" name="description" style="width: 304px;"/>
                                <option value="">请选择</option>
                                <option value="日常数据">日常数据</option>
                                <option value="渠道运营">渠道运营</option>
                                <option value="客服功能">客服功能</option>
                                <option value="百人">百人</option>
                                <option value="Agent管理">Agent管理</option>
                                <option value="日志">日志</option>
                                <option value="时时乐信息">时时乐信息</option>
                                <option value="运营功能">运营功能</option>
                                <option value="权限设置">权限设置</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">路由</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales4" name="route" style="width: 304px;" value=""/>
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
            url : "/newzjhadmin/permission/create",
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
        $.get("/newzjhadmin/comm/permissionfind",{'name':name},function(data){
            if(data != '0'){
                alert('该模块以添加');
                $("#inputSales1").val('');
            }
        })
    })
    $("#inputSales2").blur(function(){
        var name = $("#inputSales2").val();
        if(name == ''){
            return false;
        }
        $.get("/newzjhadmin/comm/permissionfind",{'display_name':name},function(data){
            if(data != '0'){
                alert('该名称以添加');
                $("#inputSales2").val('');
            }
        })
    })
    $("#inputSales4").blur(function(){
        var route = $("#inputSales4").val();
        if(route == ''){
            return false;
        }
        $.get("/newzjhadmin/comm/permissionfind",{'route':route},function(data){
            if(data != '0'){
                alert('该路由以添加');
                $("#inputSales4").val('');
            }
        })
    })
</script>