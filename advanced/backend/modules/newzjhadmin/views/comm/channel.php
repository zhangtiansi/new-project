<!-- <div class="modal fade" id="tagaboutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> -->
    <div style="width:70%;height:200px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal">
<!--                    <div class="form-group">-->
<!--                        <label for="inputSales2" class="col-sm-2 control-label">审核选项</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <select class="form-control" id="inputSales2" name="state" style="width: 304px;"/>-->
<!--                            <option value="1">通过</option>-->
<!--                            <option value="-1">禁用</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">渠道名称</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[channel_name]" style="width: 304px;" value="<?php echo $result->channel_name?>"/>
                            <input class="form-control" type="hidden" name="gm_channel_info[cid]" style="width: 304px;" value="<?php echo $result->cid?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">渠道描述</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[channel_desc]" style="width: 304px;" value="<?php echo $result->channel_desc?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">anysdk渠道号</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[any_channel]" style="width: 304px;" value="<?php echo $result->any_channel?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">登录用户名</label>
                        <div class="col-sm-10">
                            <input class="form-control inputUserName" type="text" id="inputUserName" name="user[username]" style="width: 304px;" value="<?php echo $user->username?>"/>
                            <input type="hidden" name="user[id]" value="<?php echo $user->id !='' ? $user->id : ''?>" id="user_id"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">显示用户名</label>
                        <div class="col-sm-10">
                            <input class="form-control inputUserName" type="text" id="inputUserDisplay" name="user[userdisplay]" style="width: 304px;" value="<?php echo $user->userdisplay?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="oldPasswordInput" name="user[password_hash]" style="width: 304px;" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="user[newpasswd]" style="width: 304px;" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSales2" name="user[status]" style="width: 304px;"/>
                                <option value="0" <?php echo $user->status == "'0'" ? 'selected' : '' ?>>正常</option>
                                <option value="1" <?php echo $user->status == "1" ? 'selected' : '' ?>>禁止登录</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">角色</label>
                        <?php foreach($role_list as $value):?>
                            <input type="checkbox" name="role_id[]" value="<?php echo $value->id?>" <?php echo $user_roles_id !='' && in_array($value->id, $user_roles_id) ? 'checked' : ''?>>
                            <?php echo $value->name?>
                        <?php endforeach;?>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">用户数据配比</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[p_user]" style="width: 304px;" value="<?php echo $result->p_user?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">充值数据配比</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[p_recharge]" style="width: 304px;" value="<?php echo $result->p_recharge?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">局数配比(大于几局才算活跃，只在渠道后台统计)</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[p_gm]" style="width: 304px;" value="<?php echo $result->p_gm?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">当前版本</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[cur_version]" style="width: 304px;" value="<?php echo $result->cur_version?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">apk地址</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[update_url]" style="width: 304px;" value="<?php echo $result->update_url?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">更新日志</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[changelog]" style="width: 304px;" value="<?php echo $result->changelog?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">VersionCode</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[version_code]" style="width: 304px;" value="<?php echo $result->version_code?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">是否强更</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSales2" name="gm_channel_info[force]" style="width: 304px;"/>
                                <option value="0" <?php echo $result->force == "0" ? 'selected' : '' ?>>不强更</option>
                                <option value="1" <?php echo $result->force == "1" ? 'selected' : '' ?>>强更</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">pay_method</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSales2" name="gm_channel_info[pay_method]" style="width: 304px;"/>
                                <option value="0">默认</option>
                                <option value="1">爱贝支付</option>
                            </select>
                            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">爱贝编号</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSales2" name="gm_channel_info[ipay]" style="width: 304px;"/>
                            <?php foreach($ipay_list as $key=>$value):?>
                                <option value="<?php echo $key?>" <?php echo $result->ipay == $key ? 'selected' : '' ?>><?php echo $value?></option>
                            <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">iOS审核状态</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSales2" name="gm_channel_info[inreviewstat]" style="width: 304px;"/>
                                <option value="0" <?php echo $result->inreviewstat == '0' ? 'selected' : '' ?>>不审核</option>
                                <option value="1" <?php echo $result->inreviewstat == '1' ? 'selected' : '' ?>>在审核，开启IPV6关闭典当赠送</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">iOS审核build</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="inputSales1" name="gm_channel_info[inreviewbuild]" style="width: 304px;" value="<?php echo $result->inreviewbuild?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSales1" class="col-sm-2 control-label">更新时间</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="gm_channel_info[ctime]" id="datepicker"  value="<?php echo $result->ctime?>" disabled="">
                        </div>
                    </div>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel()">取消</button>
                <button type="button" class="btn btn-primary" onclick="save_update()">保存</button>
            </div>
        </div>
    </div>
<!-- </div> -->
<script type="text/javascript">
    function save_update(){
        $.ajax({
            url : "/newzjhadmin/channel/update",
            type : "POST",
            data : $( '.form-horizontal').serialize(),
            success : function(data) {
//                var index = parent.layer.getFrameIndex(window.name);
//                parent.location.replace(parent.location.href);
//                parent.layer.close(index);
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
    var oldUserName = $("#inputUserName").val();
    $("#inputUserName").blur(function(){
        var username = $("#inputUserName").val();
        if(username == ''){
            return false;
        }
        $.get("/newzjhadmin/channel/finduser",{'username':username},function(data){
            if(data != '0'){
                alert('该用户名已存在');
                $("#inputUserName").val(oldUserName);
            }
        })
    })
    $("#oldPasswordInput").blur(function(){
        var oldPassword = $("#oldPasswordInput").val();
        var user_id = $("#user_id").val();
        if(oldPassword == ''){
            return false;
        }
        if(user_id == ''){
            return false;
        }
        $.get("/newzjhadmin/channel/thequerypassword",{'password':oldPassword,'id':user_id},function(data){
            if(data != '1'){
                alert('密码输入错误');
                $("#oldPasswordInput").val('');
            }
        })
    })
</script>