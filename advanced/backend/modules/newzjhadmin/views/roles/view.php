<?php
use yii\widgets\LinkPager;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           <?php echo $name?>
            <a href="/newzjhadmin/roles/index" class="btn btn-primary" style="float: right">返回</a>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box table-responsive">
<!--            <form class="form-horizontal">-->
<!--                <div class="box-body">-->
<!--                    <label for="inputVip2" class="col-sm-1 control-label" style="width: 89px; border-left-width: 0px; margin-left: 22px;">权限名称</label>-->
<!--                    <div class="col-sm-2">-->
<!--                        <input type="text" class="form-control" name="display_name" value="">-->
<!--                    </div>-->
<!--                    <div class="col-sm-2">-->
<!--                        <button type="submit" class="btn btn-primary">搜索</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>权限名称</th>
                        <th>所属菜单</th>
                        <th>路由</th>
                        <th>添加时间</th>
<!--                        <th>操作</th>-->
                    </tr>
            <?php foreach($list as $value):?>
                    <tr>
                        <td><?php echo $value->id?></td>
                        <td><?php echo $value->display_name?></td>
                        <td><?php echo $value->description?></td>
                        <td><?php echo $value->route?></td>
                        <td><?php echo $value->created_at?></td>
                        <!--<td><a href="javascript:;" onclick="tag_member_edit(<?php echo $value->id?>)" style="margin-right:5px;">修改</a><a href="javascript:;" onclick="tag_member_delete(this,<?php echo $value->id?>)">删除</a></td>-->
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
<!--                <p class="pull-right" style="padding:4px 10px 10px; color:#999;">共--><?php //echo $count?><!--条 每页显示20条</p>-->
            </div>
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript" src="/assets/new_admin/lib/layer/1.9.3/layer.js"></script>
<!--<script>-->
<!--    function tag_member_edit(id){-->
<!--        layer.open({-->
<!--            type: 2,-->
<!--            title: '更新渠道信息 215',-->
<!--            shadeClose: true,-->
<!--            shade: 0.8,-->
<!--            area: ['900px', '500px'],-->
<!--            content: '/newzjhadmin/comm/updatepermission?id='+id-->
<!--        });-->
<!--    }-->
<!--    function add_channel(){-->
<!--        layer.open({-->
<!--            type: 2,-->
<!--            title: '添加渠道',-->
<!--            shadeClose: true,-->
<!--            shade: 0.8,-->
<!--            area: ['900px', '500px'],-->
<!--            content: '/newzjhadmin/comm/createpermission'-->
<!--        });-->
<!--    }-->
<!--    function tag_member_delete(obj,id){-->
<!--        layer.confirm('确认要删除吗？',function(index){-->
<!--            $.ajax({-->
<!--                url: "/newzjhadmin/permission/deletepermission?id="+id,-->
<!--                type: 'GET',-->
<!--                success: function(result) {-->
<!--                    $(obj).parents("tr").remove();-->
<!--                    layer.msg('已删除!',{icon:1,time:1000});-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    }-->
<!--</script>-->