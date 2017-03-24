<?php
use yii\widgets\LinkPager;
?>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
              每日金币数据
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="box table-responsive">
            <form class="form-horizontal">
              <div class="box-body">
                <label for="inputVip2" class="col-sm-1 control-label">日期</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="pay_time" id="datepicker" style="display:inline-block; width:auto; margin-left:8px;" value="<?php echo isset($pay_time) ? $pay_time : ''?>">
                </div>
                  <label for="inputVip2" class="col-sm-1 control-label" style="width: 89px; border-left-width: 0px; margin-left: 22px;">支付方式</label>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" name="source" id="datepicker" value="<?php echo isset($source) ? $source : '' ?>">
                  </div>
                <label for="inputVip3" class="col-sm-1 control-label">渠道</label>
                <div class="col-sm-2">
                  <select class="form-control" id="inputVip3" name="cid"/>
                    <option value="">请选择</option>
<!--                    --><?php //foreach($channel_name_list as $value):?>
<!--                        <option value="--><?php //echo $value['cid']?><!--" --><?php //echo $cid == $value['cid'] ? 'selected' : '' ?><!-- >--><?php //echo $value['channel_name']?><!--</option>-->
<!--                    --><?php //endforeach;?>
                  </select>
                </div>
                <div class="col-sm-2">
<!--                  <button type="submit" class="btn btn-primary">搜索</button>-->
                </div>
              </div>
            </form>     
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
<!--                  <th>序号</th>-->
<!--                  <th>日期</th>-->
<!--                  <th>渠道</th>-->
<!--                  <th>支付方式</th>-->
<!--                  <th>总金额</th>-->
<!--                  <th>充值人数</th>-->
<!--                  <th>充值人次</th>-->
<!--                  <th>Up值</th>-->
<!--                  <th>平均值</th>-->
                </tr>
<!--            --><?php //foreach($list as $value):?>
<!--                <tr>-->
<!--                  <td>--><?php //echo $value->id?><!--</td>-->
<!--                  <td>--><?php //echo $value->udate?><!--</td>-->
<!--                  <td>--><?php //echo $value->channel?><!--</td>-->
<!--                  <td>--><?php //echo $value->source?><!--</td>-->
<!--                  <td>--><?php //echo $value->totalfee?><!--</td>-->
<!--                  <td>--><?php //echo $value->pnum?><!--</td>-->
<!--                  <td>--><?php //echo $value->ptime?><!--</td>-->
<!--                  <td>--><?php //echo $value->up?><!--</td>-->
<!--                  <td>--><?php //echo $value->avg?><!--</td>-->
<!--<!--                  <td><a href="returndetail.html" style="margin-right:5px;">查看</a><a href="#">禁用</a></td>-->-->
<!--                </tr>-->
<!--            --><?php //endforeach;?>
              </table>
            </div><!-- /.box-body --> 
            <div class="box-footer clearfix">
<!--              <ul class="pagination pagination-sm no-margin pull-right">-->
<!--                  --><?php
//                  echo LinkPager::widget([
//                      'pagination' => $pagination
//                  ]);
//                  ?>
<!--              </ul>-->
<!--              <p class="pull-right" style="padding:4px 10px 10px; color:#999;">共--><?php //echo $count?><!--条 每页显示20条</p>-->
            </div> 
          </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->