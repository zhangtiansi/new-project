<?php
use yii\widgets\LinkPager;
?>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
              渠道信息
              <a href="javascript:;" class="btn btn-primary" style="float: right" onclick="add_channel()">新增渠道</a>
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="box table-responsive">
            <form class="form-horizontal">
              <div class="box-body">
                  <label for="inputVip2" class="col-sm-1 control-label" style="width: 89px; border-left-width: 0px; margin-left: 22px;">渠道名称</label>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" name="channel_name" value="<?php echo $channel_name !='' ? $channel_name : ''?>">
                  </div>
                <div class="col-sm-2">
                  <button type="submit" class="btn btn-primary">搜索</button>
                </div>
              </div>
            </form>
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th>渠道ID</th>
                  <th>渠道名称</th>
                  <th>当前版本</th>
                  <th>apk地址</th>
                  <th>VersionCode</th>
                  <th>爱贝编号</th>
                  <th>ios审核状态</th>
                  <th>登录账号</th>
                  <th>操作</th>
                </tr>
            <?php foreach($list as $value):?>
                <tr>
                  <td><?php echo $value->cid?></td>
                  <td><?php echo $value->channel_name?></td>
                  <td><?php echo $value->cur_version?></td>
                  <td><a href="<?php echo $value->update_url?>"><?php echo $value->update_url?></a></td>
                  <td><?php echo $value->version_code?></td>
                  <td><?php echo $value->pay_method == 0 ? '默认' : '爱贝支付'?></td>
                  <td><?php echo $value->inreviewstat == 0 ? '非审核状态' : '正在审核(屏蔽点当赠送开启IPV6)'?></td>
                  <td><?php echo $value->opname?></td>
                  <td><a href="/newzjhadmin/channel/view?cid=<?php echo $value->cid?>" style="margin-right:5px;">查看</a><a href="javascript:;" onclick="tag_member_edit(<?php echo $value->cid?>)">修改</a></td>
                </tr>
            <?php endforeach;?>
              </table>
            </div><!-- /.box-body --> 
            <div class="box-footer clearfix">
<!--              <ul class="pagination pagination-sm no-margin pull-right">-->
                  <?php
                  echo LinkPager::widget([
                      'pagination' => $pagination
                  ]);
                  ?>
<!--              </ul>-->
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
        title: '更新渠道信息 215',
        shadeClose: true,
        shade: 0.8,
        area: ['900px', '500px'],
        content: '/newzjhadmin/comm/channel?id='+id
    });
}
function add_channel(){
    layer.open({
        type: 2,
        title: '添加渠道',
        shadeClose: true,
        shade: 0.8,
        area: ['900px', '500px'],
        content: '/newzjhadmin/comm/createchannel'
    });
}
</script>