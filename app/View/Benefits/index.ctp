<div class="circle-loader">
    <div class="checkmark draw"></div>
</div>
<div class="circle-confirm">
    <div class="circle-confirm-top"></div>
    <div class="circle-confirm-bottom"></div>
</div>


<div class="container">
    <table class="table-bordered">
        <?php
        for($i = 0; $i < 5; $i++)
        {
            ?>
            <tr>
                <?php
                for ($j = 0; $j < 10; $j++)
                {
                    ?>
                    <td  style="width: 100px !important; height: 100px !important;">

                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </table>

</div>