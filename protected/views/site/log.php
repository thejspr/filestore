<div id="log-title">Log:</div>
<div id="log-entries">
</div>
<script>
    function getMessages() {
        $.ajax({
            url: '<?= $this->createUrl('log/getMessages') ?>',
            success: function(data) {
                $("#log-entries").html(data);
            }
        });
    }
    $(document).ready(function(){
        getMessages();
        setInterval('getMessages()', 5000);
    });
</script>