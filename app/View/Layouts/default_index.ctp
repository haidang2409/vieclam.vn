<?php
include "user_header.ctp";
echo $this->fetch('content');
include "user_footer.ctp";
echo $this->Html->script('bootstrap.min');
echo $this->Html->script('jquery-ui.min');
echo $this->Html->script('ace.min');
echo $this->Html->script('select2.min');
echo $this->Html->script('wizard.min');
echo $this->Html->script('ace-elements.min');
echo $this->Html->script('function');
echo $this->Html->script('home');
?>
<script>
    $(function () {
        $('.btn-search-index').click(function () {
            search_index();
        });
    })
</script>
</body>
</html>
