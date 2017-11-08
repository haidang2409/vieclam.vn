<div class="container-list-viewed">
    <?php
    if(isset($recruitments_viewed) && count($recruitments_viewed) > 0)
    {
        foreach ($recruitments_viewed as $item)
        {
            ?>
            <div class="item">
                <h4>
                    <a href="/tim-viec-lam/<?php echo $item['Recruitment']['link'];?>/<?php echo $item['Recruitment']['id'];?>">
                        <?php echo $item['Recruitment']['title'];?>
                    </a>
                </h4>
                <span class="company">
                    <?php echo $item['Employer']['company_name'];?>
                </span>
            </div>
            <?php
        }
    }
    ?>
</div>