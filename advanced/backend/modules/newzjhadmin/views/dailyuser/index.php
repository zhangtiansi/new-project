<?php
use yii\widgets\LinkPager;
?>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
              每日用户数据
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
                <label for="inputVip3" class="col-sm-1 control-label">渠道</label>
                <div class="col-sm-2">
                  <select class="form-control" id="inputVip3" name="cid"/>
                    <option value="">请选择</option>
                    <?php foreach($channel_name_list as $value):?>
                        <option value="<?php echo $value['cid']?>" <?php echo $cid == $value['cid'] ? 'selected' : '' ?> ><?php echo $value['channel_name']?></option>
                    <?php endforeach;?>
                  </select>
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
                  <th>日期</th>
                  <th>渠道</th>
                  <th>登录人次/人数/人均次</th>
                  <th>活跃(参加过游戏)人数</th>
                  <th>注册(IME)</th>
                  <th>活跃/注册(IME)</th>
                  <th>活跃(所有)</th>
                  <th>注册(所有)</th>
                  <th>活跃/注册(所有)</th>
                </tr>
            <?php foreach($list as $value):?>
                <tr>
                  <td><?php echo $value->id?></td>
                  <td><?php echo $value->udate?></td>
                  <td><?php echo $value->channel?></td>
                  <td><?php echo $value->loginnum.'/'.$value->loginp.'/'.Yii::$app->formatter->asDecimal($value->loginnum/$value->loginp,1)?></td>
                  <td><?php echo $value->activenum?></td>
                  <td><?php echo $value->totalreg?></td>
                  <td><?php echo $value->activenum.'/'.$value->totalreg.'~'.Yii::$app->formatter->asDecimal($value->activenum/$value->totalreg,1)*100 .'%'?></td>
                  <td>未知</td>
                  <td>未知</td>
                  <td>未知</td>
<!--                  <td><a href="returndetail.html" style="margin-right:5px;">查看</a><a href="#">禁用</a></td>-->
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