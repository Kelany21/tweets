<script>
    function dateRender(date, withTime) {
        let cla = "text-success";
        let rowDay = moment(date).format('yyyy-MM-DD');
        let today = moment().format('yyyy-MM-DD');
        let time = moment(rowDay, 'yyyy-MM-DD');
        let time2 = moment(today, 'yyyy-MM-DD');
        if (time.diff(time2, "days") < 0) {
            cla = "text-black-50";
        }
        let render = '<span class="' + cla + '"><i class="flaticon2-calendar-9  ' + cla + ' font-size-xs mr-1"></i> ';
        render += '<sapn class="mr-1">' + rowDay + '</span>';
        if (withTime !== undefined) {
            render += '<span class="' + cla + '"><i class="flaticon-clock-1  ' + cla + ' font-size-xs mr-1"></i>' + moment(date).format('h:m:s') + '</span>'
        }
        render += '</span>'
        return render
    }
</script>
