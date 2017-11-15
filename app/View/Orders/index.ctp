<div class="container" style="min-height: 450px">
    <div class="row">
        <div class="col-sm-6">
            <h4>LỊCH SỬ HÓA ĐƠN</h4>
        </div>
        <div class="col-sm-6 text-right bigger-110" style="margin-bottom: 15px">
            <span>
                <?php echo number_format($this->Paginator->param('count'), 0, '', '.');?> hóa đơn
            </span>&nbsp;
        </div>
        <div class="col-sm-12">
            <?php
            if(isset($orders) && count($orders) > 0)
            {
                ?>
                <table class="table">
                    <tr>
                        <td class="text-center bolder">Stt</td>
                        <td class="bolder">Việc làm</td>
                        <td class="bolder">Loại tin</td>
                        <td class="text-center bolder">Ngày tạo</td>
                        <td class="text-center bolder">
                            Tổng tiền
                        </td>
                        <td class="text-center bolder">
                            Giảm giá
                        </td>
                    </tr>
                    <?php
                    $page = $this->request->paging['Order']['page'];
                    $limit = $this->request->paging['Order']['limit'];
                    $number = ($page - 1) * $limit;
                    $i = 0;
                    ?>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td style="text-align: center" width="50">
                                <?php
                                echo $number + ($i + 1);
                                $i = $i + 1;
                                ?>
                            </td>
                            <td style="max-width: 300px">
                                <a href="#">
                                    <?php echo htmlentities($order['Recruitment']['title'], ENT_QUOTES, 'UTF-8');?>
                                </a>
                            </td>
                            <td><?php echo $order['Packet']['packet_name'];?></td>
                            <td align="center"><?php echo $this->Lib->convertDateTime_Mysql_to_Date($order['Order']['created']);?></td>
                            <td align="right"><?php echo number_format($order['Order']['sumamount'], 0, '', '.');?></td>
                            <td align="right"><?php echo $order['Order']['discount'];?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <div class="text-center">
                    <?php
                    if($this->params['paging']['Order']['pageCount'] > 1)
                    {
                        ?>
                        <div class="pagination">
                            <?php echo $this->Paginator->numbers(array(
                                'separator' => '',
                                'currentTag' => 'a',
                                'currentClass' => 'active',
                                'ellipsis'=>'<a>...</a>',
                                'modulus' => 4,
                                'first' => 2,
                                'last' => 2
                            ));
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
            else
            {
                echo '<div class="alert alert-warning">Không có hóa đơn</div>';
            }
            ?>
        </div>
    </div>
</div>