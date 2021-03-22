<?php
use App\Services\SortService;

echo SortService::getOl($items);


?>
<script>
    $(document).ready(function(){
        /*$('.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            excludeRoot: true,
        });*/

        $('.btn-delete-filter').click(function () {
            if (confirm('Are you sure?')) {
                let filter_id = $(this).parent().data('id');
                let sub_category_id = $('#sub_category_id').val()
                $.post('/admin/filters/delete/'+filter_id, {
                    _token: '{{ csrf_token() }}'
                }, function(data){
                    location.reload(true);
                });

            }
        });

        $('.btn-edit-filter').click(function () {
            let filter_id = $(this).parent().data('id');
            let sub_category_id = $('#sub_category_id').val();
            window.location.href = "/admin/filters/edit/"+sub_category_id+"/"+filter_id;
        })

    })
</script>
<style>
    .sortable div{
        /*cursor: all-scroll;*/
        padding: 10px;
        background: #e2e2e2;
        color: #404040;
        margin-bottom: 8px;
        display: inline-block;
        width: 80%;
    }
    .btn-delete-filter, .btn-edit-filter {
        width: 10%;
        color: white;
        padding: 9px;
        border-radius: inherit;
        margin-top: -2px;
    }
    .btn-delete-filter {
        background-color: #dc3545;
    }
    .btn-edit-filter {
        background-color: #17a2b8;
    }
</style>
