<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!--            Breadcrumbs-->
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="/"><?php echo __('Home');?></a>
                    </li>
                    <li><a href="/bai-viet"><?php echo __('Bài viết');?></a></li>
                    <li><a href="/bai-viet/<?php echo $posts['PostCategory']['link']?>-cp<?php echo $posts['PostCategory']['id']?>"><?php echo $posts['PostCategory']['name'];?></a> </li>
                    <li><?php echo $posts['Post']['title'];?></li>
                </ul>
            </div>
            <br>
            <!--            End Breadcrumbs-->
        </div>
        <!--        Right-->
        <div class="col-sm-9 col-sm-push-3">
            <h1 style="margin-bottom: 10px !important; font-size: 1.7em">
                <?php echo $posts['Post']['title'];?>
            </h1>
            <div class="post-summary">
                <?php echo $posts['Post']['summary'];?>
            </div>
            <div class="post-content">
                <?php
                echo str_replace('/app/webroot', '', $posts['Post']['description']);
                ?>
                <hr class="hr-dotted">
            </div>
<!--            Prev and next-->
            <div class="prev-next text-center">
                <?php
                if(isset($post_prev_next['prev']))
                {
                    ?>
                    <a title="Bài trước" href="/bai-viet/<?php echo $post_prev_next['prev']['Post']['postlink'];?>-<?php echo $post_prev_next['prev']['Post']['id'];?>">
                        <i class="fa fa-angle-double-left"></i> BÀI TRƯỚC
                    </a>
                    <?php
                }
                if(isset($post_prev_next['next']))
                {
                    ?>
                    <a title="Bài kế tiếp" href="/bai-viet/<?php echo $post_prev_next['next']['Post']['postlink'];?>-<?php echo $post_prev_next['next']['Post']['id'];?>">
                        BÀI KẾ <i class="fa fa-angle-double-right"></i>
                    </a>
                    <?php
                }
                ?>
                <hr class="hr-dotted visible-xs">
            </div>
<!--            End Prev and next-->
        </div>
        <!--        Left-->
        <div class="col-sm-3 col-sm-pull-9">
            <div class="">
                <div id="" class="accordian">
                    <ul style="margin-left: 0 !important;">
                        <?php
                        if(isset($postcats))
                        {
                            for($i = 0; $i < count($postcats); $i++)
                            {
                                ?>
                                <li>
                                    <h4>
                                        <a class="a-group" href="/bai-viet/<?php echo $postcats[$i]['PostCategory']['link'];?>-cp<?php echo $postcats[$i]['PostCategory']['id'];?>">
                                            <i class="fa fa-caret-right"></i>
                                            <?php echo $postcats[$i]['PostCategory']['name'];?>
                                        </a>
                                    </h4>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!--            Posts relative-->
                <div style="margin: 15px 0" class="post-relative-container">
                    <h3>BÀI VIẾT MỚI</h3>
                    <hr class="hr-dotted">
                    <?php
                    if(isset($post_relatives))
                    {
                        foreach ($post_relatives as $item)
                        {
                            ?>
                            <div class="row" style="margin-bottom: 10px !important;">
                                <div class="col-sm-4 col-xs-5" style="padding-right: 0 !important;">
                                    <?php
                                    $image = '/uploads/posts/no_post.png';
                                    if($item['Post']['image'] != '' && file_exists(WWW_ROOT . '/uploads/posts/' . $item['Post']['image']))
                                    {
                                        $image = '/uploads/posts/' . $item['Post']['image'];
                                    }
                                    ?>
                                    <a href="/bai-viet/<?php echo $item['Post']['postlink'];?>-<?php echo $item['Post']['id'];?>" title="<?php echo $item['Post']['title'];?>">
                                        <img width="100%" src="<?php echo $image;?>" alt="<?php echo $item['Post']['title'];?>">
                                    </a>
                                </div>
                                <div class="col-sm-8 col-xs-7" style="padding-left: 5px !important;">
                                    <?php
                                    $title = $item['Post']['title'];
                                    $num_str = strlen($title);
                                    if($num_str > 90)
                                    {
                                        $title = substr($title, 0, 90);
                                        $start = strripos($title, ' ');
                                        if($start > 0)
                                        {
                                            $title = substr($title, 0, $start + 1);
                                        }
                                    }
                                    ?>
                                    <h4>
                                        <a class="link-hover none-textdecoretion" href="/bai-viet/<?php echo $item['Post']['postlink'];?>-<?php echo $item['Post']['id'];?>">
                                            <?php echo $title;?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!--            End posts relative-->
            </div>
        </div>
    </div>
</div>