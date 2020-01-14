<select id="select">
    <option></option>
</select>
<script src="<?php echo asset('/xianshangke/js/jquery.min.js')?>"></script>
<script>
    $.post('/api/v1/contract/distribute/user',function(response){
        var html = '';
        $.each(response.data.userList,function(i,v){

            console.log(i);

            console.log(v);
        });
        $('#select').html();

        console.log(response.data);
    })
</script><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/test.blade.php ENDPATH**/ ?>