<div class="container" style="min-height: 450px">
    <div class="row">
        <div class="col-sm-3">
            <?php
            include ROOT.DS.'app'.DS.'View'.DS.'Employers'.DS.'_menu_bar.ctp';
            ?>
        </div>
        <div class="col-sm-9">
            <div class="row container-benefit-update">
                <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                    <h4>Cập nhật phúc lợi</h4>
                    <hr class="dotted">
                    <?php
                    echo $this->Session->flash();
                    ?>
                    <?php echo $this->Form->create('Employer', array('class' => 'form-horizontal form_has_addon', 'novalidate' => true));?>
                    <?php
                    $count = 0;
                    $arr_benefit_selected = array();
                    if(isset($employers_benefits) && count($employers_benefits) > 0)
                    {
                        $i = 0;
                        $count = count($employers_benefits);
                        foreach ($employers_benefits as $item)
                        {
                            $arr_benefit_selected[$i] = $item['Benefit']['id'];
                            $i = $i + 1;
                            ?>
                            <div class="form-group benefit-item">
                                <div class="col-sm-7 col-xs-11 col-sm-offset-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="<?php echo $item['Benefit']['icon'];?>"></i>
                                        </span>
                                        <input name="benefit_id[]" value="<?php echo $item['Benefit']['id'];?>" type="hidden">
                                        <input name="benefit_note[]" class="form-control" type="text" value="<?php echo $item['EmployerBenefit']['note'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-1 text-center">
                                    <span class="remove-benefit" data-benefit_id="<?php echo $item['Benefit']['id'];?>">
                                        <i class="fa fa-remove"></i>
                                    </span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    //Nếu ít hơn 5 phúc lợi -> Link thêm phúc lợi
                    if($count < 5)
                    {
                        ?>
                        <div class="div-more-benefit">

                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <a class="add-more-benefit" href="javascript: void(0)">+ Thêm phúc lợi</a>
                        </div>
                        <div class="col-sm-4 red text-right error-benefit" style="display: none;">
                            Không chọn quá 5 phúc lợi
                        </div>
                        <?php
                    }
                    ?>
                    <div class="text-right form-group">
                        <div class="col-sm-9"  style="padding-top: 10px !important;">
                            <button class="btn btn-index" type="submit">
                                <i class="fa fa-check"></i>
                                Cập nhật
                            </button>
                        </div>

                    </div>
                    <?php
                    echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$html_benefit_option = '';
if(isset($benefits) && count($benefits) > 0)
{
    foreach ($benefits as $item)
    {
        $class = '';
        if(is_array($arr_benefit_selected) && in_array($item['Benefit']['id'], $arr_benefit_selected))
        {
            $class = 'selected';
        }
        $html_benefit_option = $html_benefit_option
            . '<li><a href="javascript:void(0)" class="a-benefit-' . $item['Benefit']['id'] . ' a-no-bg a-benefit-item ' . $class . ' " data-icon="'
            . $item['Benefit']['icon'] . '" data-id="' . $item['Benefit']['id']
            . '"><i class="' . $item['Benefit']['icon'] . '"> </i> '
            . $item['Benefit']['benefit_name'] . '</a></li>';
    }
}
?>
<div class="hidden" id="div-benefit-option">
    <ul class="dropdown-menu dropdown-benefit-option dropdown-only-icon dropdown-caret dropdown-close">
        <?php echo $html_benefit_option;?>
    </ul>
</div>
<script>
    $(function () {
        //Khi click + Thêm phúc lợi
        $('.add-more-benefit').click(function(){
            if($('.benefit-item').length < 5)
            {
                var dropdown = $('#div-benefit-option').html();
                var html_option = get_html_benefit(dropdown);
                $('.div-more-benefit').append(html_option);
                $('.dropdown-benefit-option').css('display', 'block');
                $('.error-benefit').hide();
            }
            else
            {
                $('.error-benefit').show();
            }
        });
        //Khi click vào thẻ a trên dropdown
        $(document).on('click','.a-benefit-item', function(){
            if(!$(this).hasClass('selected'))
            {
                var icon = $(this).data('icon');
                var id = $(this).data('id');
                $(this).closest('div.benefit-item').find('span.remove-benefit').data('benefit_id', id);
                var benefit_name = $(this).text();
                $('.input-waiting').val($.trim(benefit_name)).attr('readonly', false).focus();
                $('.input-benefit-new').removeClass('input-waiting');
                $('.input-benefit-id-waiting').val(id);
                $('.input-benefit-id').removeClass('input-benefit-id-waiting');
                $('.icon-waiting').html('<i class="' + icon + '"></i>');
                $('.icon-benefit').removeClass('icon-waiting');
                $('.benefit-item .dropdown-benefit-option').remove();
                $('.a-benefit-' + id).addClass('selected');
            }
        });
        //Remove phúc lợi
        $(document).on('click', '.remove-benefit', function(){
            if($('.benefit-item').length > 1)
            {
                var benefit_id = $(this).data('benefit_id');
                $(this).closest('div.benefit-item').remove();
                $('.a-benefit-' + benefit_id).removeClass('selected');
                $('.error-benefit').hide();
            }
        });
    });
    function get_html_benefit(list_option)
    {
        var html_benefit = '<div class="form-group benefit-item">' +
            '<div class="col-sm-7 col-xs-11 col-sm-offset-2">' +
            '<div class="input-group">' +
            '<span class="input-group-addon icon-benefit icon-waiting">' +
            '<i class="fa fa-question"></i>' +
            '</span><input name="benefit_id[]" type="hidden" class="input-benefit-id input-benefit-id-waiting">' +
            '<input name="benefit_note[]" readonly="true" placeholder="Chọn phúc lợi" type="text" class="input-benefit-new input-waiting form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="true">' +
            list_option +
            '</div>' +
            '</div>' +
            '<div class="col-sm-1 col-xs-1 text-center"><span class="remove-benefit"><i class="fa fa-remove"></i></span></div> ' +
            '</div>';
        return html_benefit;
    }
</script>