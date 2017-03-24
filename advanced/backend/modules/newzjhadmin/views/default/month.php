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
<!--                        <h3 class="box-title">实时信息</h3>-->
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tr>
                                <td>前后台总数</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['num']?></span></td>
                                <td>客户端充值总数</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['totalfee']?></span></td>
                                <td>Agent充值总数</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['agent']?></span></td>
                            </tr>
                            <tr>
                                <td>alipay</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['Alipay']?></span></td>
                                <td>sms</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['sms']?></span></td>
                                <td>unionpay</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['unionpay']?></span>
                            </tr>
                            <tr>
                                </td><td>wxpay</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['wxpay']?></span></td>
                                </td><td>yeepay</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['yeepay']?></span></td>
                                </td><td>appstore</td>
                                <td><span class="badge bg-light-blue"><?php echo $data['0']['appstore']?></span></td>
                            </tr>

                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="box">
                    <div class="box-header text-center">
                        <h3 class="box-title">上月数据</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tr>
                                <td>前后台总数</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['num']?></span></td>
                                <td>客户端充值总数</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['totalfee']?></span></td>
                                <td>Agent充值总数</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['agent']?></span></td>
                            </tr>
                            <tr>
                                <td>alipay</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['Alipay']?></span></td>
                                <td>sms</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['sms']?></span></td>
                                <td>unionpay</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['unionpay']?></span>
                            </tr>
                            <tr>
                                </td><td>wxpay</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['wxpay']?></span></td>
                                </td><td>yeepay</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['yeepay']?></span></td>
                                </td><td>appstore</td>
                                <td><span class="badge bg-light-blue"><?php echo $reslast['0']['appstore']?></span></td>
                            </tr>

                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header text-center">
<!--                        <h3 class="box-title">时时乐今日排行榜</h3>-->
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>日期</th>
                                <th>alipay</th>
                                <th>短信</th>
                                <th>银联</th>
                                <th>微信</th>
                                <th>易宝</th>
                                <th>appstore</th>
                                <th>总计</th>
                                <th>Agent</th>
                            </tr>
                            <?php foreach($data['1'] as $value):?>
                            <tr>
                                <td><?php echo $value['udate'] != '' ?$value['udate']: '' ?></td>
                                <td><?php echo $value['source'] == 'Alipay' ?$value['totalfee']: '' ?></td>
                                <td><?php echo $value['source'] == 'sms' ?$value['totalfee']: '' ?></td>
                                <td><?php echo $value['source'] == 'union' ?$value['totalfee']: '' ?></td>
                                <td><?php echo $value['source'] == 'wxpay' ?$value['totalfee']: '' ?></td>
                                <td><?php echo $value['source'] == 'yeepay' ?$value['totalfee']: '' ?></td>
                                <td><?php echo $value['source'] == 'appstore' ?$value['totalfee']: '' ?></td>
                                <td><?php echo $value['source'] == '所有支付' ?$value['totalfee']: '' ?></td>
                                <td><?php echo !empty($value['agent']) ? $value['agent']: '' ?></td>
                            </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="box">
                    <div class="box-header text-center">
                        <h3 class="box-title">上月数据</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>日期</th>
                                <th>alipay</th>
                                <th>短信</th>
                                <th>银联</th>
                                <th>微信</th>
                                <th>易宝</th>
                                <th>appstore</th>
                                <th>总计</th>
                                <th>Agent</th>
                            </tr>
                            <?php foreach($reslast['1'] as $value):?>
                                <tr>
                                    <td><?php echo $value['udate'] != '' ?$value['udate']: '' ?></td>
                                    <td><?php echo $value['source'] == 'Alipay' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo $value['source'] == 'sms' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo $value['source'] == 'union' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo $value['source'] == 'wxpay' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo $value['source'] == 'yeepay' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo $value['source'] == 'appstore' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo $value['source'] == '所有支付' ?$value['totalfee']: '' ?></td>
                                    <td><?php echo !empty($value['agent']) ? $value['agent']: '' ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->