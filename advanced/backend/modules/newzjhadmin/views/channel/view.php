<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <a href="/newzjhadmin/channel/index">返回</a>
        </h1>
        <ol class="breadcrumb">
            <li></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box" style="width: 100%">
                    <div class="box-header text-center">
                        <h3 class="box-title">渠道ID：<?php echo $gm_channel_result['cid']?> &nbsp 渠道名称：<?php echo $gm_channel_result['channel_name']?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tr>
                                <td>渠道Id</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['cid']?></span></td>
                            </tr>
                            <tr>
                                <td>渠道名称</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['channel_name']?></span></td>
                            </tr>
                            <tr>
                                <td>渠道描述</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['channel_desc']?></span></td>
                            </tr>
                            <tr>
                                <td>后台账号</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['opname']?></span></td>
                            </tr>
                            <tr>
                                <td>当前版本</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['cur_version']?></span></td>
                            </tr>
                            <tr>
                                <td>apk地址</td>
                                <td><span class="badge bg-light-blue"><a href="<?php echo $gm_channel_result['update_url']?>" style="color: #ffffff"><?php echo $gm_channel_result['update_url']?></a></span></td>
                            </tr>
                            <tr>
                                <td>VersionCode</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['version_code']?></span></td>
                            </tr>
                            <tr>
                                <td>更新日志</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['changelog']?></span></td>
                            </tr>
                            <tr>
                                <td>是否更强</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['force'] == '0' ? '不更强' : '更强'?></span></td>
                            </tr>
                            <tr>
                                <td>更新时间</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['ctime']?></span></td>
                            </tr>
                            <tr>
                                <td>爱贝支付参数</td>
                                <td><span class="badge bg-light-blue"><a href="newzjhadmin/cftiap/view?id=<?php echo $ipay_model->id?>" style="color: #ffffff"><?php echo $ipay_model->appdesc.'appid编号'.$ipay_model->appid?></a></span></td>
                            </tr>
                            <tr>
                                <td>Appdesc</td>
                                <td><span class="badge bg-light-blue"><?php echo $ipay_model->appdesc?></span></td>
                            </tr>
                            <tr>
                                <td>审核状态</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['inreviewstat'] == '1' ? '审核中' : "已上线"."(审核中且build号大于等于下方审核build无法送礼点当，自动开启ipv6)"?></span></td>
                            </tr>
                            <tr>
                                <td>iOS审核build</td>
                                <td><span class="badge bg-light-blue"><?php echo $gm_channel_result['inreviewbuild']?></span></td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->