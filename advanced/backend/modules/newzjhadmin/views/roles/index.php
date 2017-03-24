<?php
use yii\widgets\LinkPager;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            权限管理
            <a href="javascript:;" class="btn btn-primary" style="float: right" onclick="add_channel()">添加角色</a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box table-responsive">
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>角色</th>
                        <th>角色名称</th>
<!--                        <th>权限</th>-->
<!--                        <th>用户</th>-->
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
            <?php foreach($list as $value):?>
                    <tr>
                        <td><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo $value->display_name?></td>
                        <td><?php echo $value->created_at?></td>
                        <td><a href="/newzjhadmin/roles/view?id=<?php echo $value->id?>" style="margin-right:5px;">查看</a><a href="javascript:;" onclick="tag_member_edit(<?php echo $value->id?>)" style="margin-right:5px;">修改</a><a href="javascript:;" onclick="tag_member_delete(this,<?php echo $value->id?>)">删除</a></td>
                    </tr>
            <?php endforeach;?>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <!--              <ul class="pagination pagination-sm no-margin pull-right">-->
                <!--              </ul>-->
                <?php
//                echo LinkPager::widget([
//                    'pagination' => $pagination
//                ]);
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
            title: '修改角色',
            shadeClose: true,
            shade: 0.8,
            area: ['900px', '500px'],
            content: '/newzjhadmin/comm/updaterole?id='+id
        });
    }
    function add_channel(){
        layer.open({
            type: 2,
            title: '添加角色',
            shadeClose: true,
            shade: 0.8,
            area: ['900px', '500px'],
            content: '/newzjhadmin/comm/createroles'
        });
    }
    function tag_member_delete(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                url: "/newzjhadmin/roles/rolesdelete?id="+id,
                type: 'GET',
                success: function(result) {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }
</script>