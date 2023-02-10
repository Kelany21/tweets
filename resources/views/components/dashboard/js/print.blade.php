<script type="text/javascript">
    function PrintElem(elem) {
        var restorepage = $('body').html();
        var printcontent = $('#' + elem).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);

    }
</script>
