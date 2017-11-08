<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="/"><?php echo __('Home');?></a>
                    </li>
                    <li><a href="/bai-viet"><?php echo __('Bài viết');?></a></li>
                    <?php
                    if(isset($breadcrumb_postcat))
                    {
                        ?>
                        <li>
                            <?php echo $breadcrumb_postcat['PostCategory']['name'];?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <br>
        </div>
        <div class="col-sm-9 col-sm-push-3">
            <div class="row">
                <div class="col-xs-12">
                    <h3>BÀI VIẾT NỔI BẬT</h3>
                </div>
            </div>
            <hr class="hr-dotted">
            <div class="post-container">
                <?php
                if(isset($posts))
                {
                    $count_post = count($posts);
                    //Sm-4
                    if($count_post >= 3 && $this->params['paging']['Post']['page'] == 1)
                    {
                        ?>
                        <div class="row">
                            <?php
                            for($i = 0; $i < 3; $i++)
                            {
                                $item = $posts[$i];
                                ?>
                                <div class="col-sm-4 feature" style="margin-bottom: 10px !important;">
                                    <div class="" style="padding-right: 0 !important;">
                                        <?php
                                        $image = '/uploads/posts/no_post.png';
                                        if($item['Post']['image'] != '' && file_exists(WWW_ROOT . '/uploads/posts/' . $item['Post']['image']))
                                        {
                                            $image = '/uploads/posts/' . $item['Post']['image'];
                                        }
                                        ?>
                                        <a href="/bai-viet/<?php echo $item['Post']['postlink'];?>-<?php echo $item['Post']['id'];?>" title="<?php echo $item['Post']['title'];?>">
                                            <img width="100%" height="190px" src="<?php echo $image;?>" alt="<?php echo $item['Post']['title'];?>">
                                        </a>
                                    </div>
                                    <div class="">
                                        <?php
                                        $title = $item['Post']['title'];
                                        ?>
                                        <h4>
                                            <a class="link-hover none-textdecoretion" href="/bai-viet/<?php echo $item['Post']['postlink'];?>-<?php echo $item['Post']['id'];?>" title="<?php echo $item['Post']['title'];?>">
                                                <?php echo $title;?>
                                            </a>
                                        </h4>
                                        <div class="">
                                        </div>
                                        <div>
                                            <i class="fa fa-user"> </i>
                                            <?php echo $item['Staff']['fullname'];?>
                                            <i class="fa fa-calendar"> </i>
                                            <?php echo $this->Lib->convertDateTime_Mysql_to_Date($item['Post']['created']);?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                        </div>
                        <?php
                    }
                    //End SM-4
                    if($count_post >= 3 && $this->params['paging']['Post']['page'] == 1)
                    {
                        unset($posts[0]);
                        unset($posts[1]);
                        unset($posts[2]);
                    }
                    foreach ($posts as $item)
                    {
                        ?>
                        <div class="row" style="margin-bottom: 10px !important;">
                            <div class="col-sm-3 col-xs-5" style="padding-right: 0 !important;">
                                <?php
                                $image = '/uploads/posts/no_post.png';
                                if($item['Post']['image'] != '' && file_exists(WWW_ROOT . '/uploads/posts/' . $item['Post']['image']))
                                {
                                    $image = '/uploads/posts/' . $item['Post']['image'];
                                }
                                ?>
                                <a href="/bai-viet/<?php echo $item['Post']['postlink'];?>-<?php echo $item['Post']['id'];?>" title="<?php echo $item['Post']['title'];?>">
                                    <img width="100%" height="190px" src="<?php echo $image;?>" alt="<?php echo $item['Post']['title'];?>">
                                </a>
                            </div>
                            <div class="col-sm-9 col-xs-7" style="padding-left: 5px !important;">
                                <?php
                                $title = $item['Post']['title'];
                                ?>
                                <h4>
                                    <a class="link-hover none-textdecoretion" href="/bai-viet/<?php echo $item['Post']['postlink'];?>-<?php echo $item['Post']['id'];?>">
                                        <?php echo $title;?>
                                    </a>
                                </h4>
                                <div class="hidden-xs">
                                    <?php echo $item['Post']['summary'];?>
                                </div>
                                <div style="">
                                    <i class="fa fa-user"> </i>
                                    <?php echo $item['Staff']['fullname'];?>
                                    <i class="fa fa-calendar"></i>
                                    <?php echo $this->Lib->convertDateTime_Mysql_to_Date($item['Post']['created']);?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    if($this->params['paging']['Post']['pageCount'] > 1)
                    {
                        ?>
                        <div class="">
                            <ul class="pagination">
                                <?php
                                $here = $this->here;
                                $len_here = strlen($here);
                                $here = substr($here, 1, $len_here);
                                $this->Paginator->options(array(
                                    'url'=> array(
                                        'controller' => '/',
                                        'action' => '/',
                                        $here
                                    )
                                ));
                                $this->Paginator->options['url']['?'] = $this->params['url'];
                                echo urldecode($this->Paginator->prev(__('<<'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')));
                                echo urldecode($this->Paginator->numbers(
                                    array(
                                        'separator' => '',
                                        'currentTag' => 'a',
                                        'currentClass' => 'active',
                                        'tag' => 'li',
                                        'ellipsis'=>'<li class="ellipsis"><a>...</a></li>',
                                        'modulus' => 4,
                                        'first' => 2,
                                        'last' => 2
                                    )));
                                echo urldecode($this->Paginator->next(__('>>'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')));
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="bigger-150">
                        Trang không tìm thấy hoặc đã bị xóa
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-sm-3 col-sm-pull-9">
            <div class="">
                <div id="" class="accordian">
                    <ul style="margin-left: 0 !important;">
                        <?php
                        $postcat_id = isset($this->params['postcatid'])? substr($this->params['postcatid'], 2): '';
                        if(isset($postcats))
                        {
                            for($i = 0; $i < count($postcats); $i++)
                            {
                                ?>
                                <li>
                                    <h4>
                                        <a class="a-group <?php if($postcats[$i]['PostCategory']['id'] == $postcat_id){ echo 'link-waring';}?>" href="/bai-viet/<?php echo $postcats[$i]['PostCategory']['link'];?>-cp<?php echo $postcats[$i]['PostCategory']['id'];?>">
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
            </div>
        </div>
    </div>
</div>
