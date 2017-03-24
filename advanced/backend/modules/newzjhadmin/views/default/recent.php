<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            首页
        </h1>
        <ol class="breadcrumb">
            <li></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header text-center">
                        <h3 class="box-title">实时信息</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <?php foreach ($recentData as $key => $val) {?>
                            <tr>
                                <td><?php echo $val['k']?></td>
                                <td><span class="badge bg-light-blue"><?php echo $val['v']?></span></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header text-center">
                        <h3 class="box-title">时时乐今日排行榜</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>名次</th>
                                <th>GID</th>
                                <th>昵称</th>
                                <th>VIP</th>
                                <th>中奖(万)</th>
                                <th>中奖局数</th>
                            </tr>
                            <tr>
                                <?php foreach ($ssl as $k=>$ar){
                                    echo '<tr><td>'.($k+1).'</td><td>'.$ar['gid'].'</td><td>'.$ar["name"].'</td><td>'.$ar["power"].'</td><td>'.$ar["totalReward"].'</td><td>'.$ar["totalNum"].'</td></tr>';
                                }?>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->