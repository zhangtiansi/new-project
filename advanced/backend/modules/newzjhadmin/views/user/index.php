<?php
use yii\widgets\LinkPager;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            管理员列表
            <a href="javascript:;" class="btn btn-primary" style="float: right" onclick="add_user()">添加管理员</a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box table-responsive">
            <form class="form-horizontal">
                <div class="box-body">
                    <label for="inputVip2" class="col-sm-1 control-label" style="width: 100px; border-left-width: 0px; margin-left: 22px;">管理员名称</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="username" value="<?php echo $username?>">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">搜索</button>
                    </div>
                </div>
            </form>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>序号</th>
                        <th>管理员名称</th>
                        <th>渠道名称</th>
                        <th>邮箱</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
            <?php foreach($list as $value):?>
                    <tr>
                        <td><?php echo $value->id?></td>
                        <td><?php echo $value->username?></td>
                        <td><?php echo $value->userdisplay?></td>
                        <td><?php echo $value->email?></td>
                        <td><?php echo date('Y-m-d H:i:s',$value->created_at)?></td>
                        <td><a href="javascript:;" onclick="tag_member_edit(<?php echo $value->id?>)" style="margin-right:5px;">修改</a><a href="javascript:;" onclick="tag_member_delete(this,<?php echo $value->id?>)">删除</a></td>
                    </tr>
            <?php endforeach;?>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <!--              <ul class="pagination pagination-sm no-margin pull-right">-->
                <!--              </ul>-->
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination
                ]);
                ?>
                <p class="pull-right" style="padding:4px 10px 10px; color:#999;">共<?php echo $count?>条 每页显示20条</p>
            </div>
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript" src="/assets/new_admin/lib/layer/1.9.3/layer.js"></script>
<script>
    function tag_member_edit(id){
        layer.open({
            type: 2,
            title: '修改管理员',
            shadeClose: true,
            shade: 0.8,
            area: ['900px', '500px'],
            content: '/newzjhadmin/comm/updateuser?id='+id
        });
    }
    function add_user(){
        layer.open({
            type: 2,
            title: '添加管理员',
            shadeClose: true,
            shade: 0.8,
            area: ['900px', '500px'],
            content: '/newzjhadmin/comm/createuser'
        });
    }
    function tag_member_delete(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url: "/newzjhadmin/user/userdelete?id="+id,
                type: 'GET',
                success: function(result) {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }
</script>