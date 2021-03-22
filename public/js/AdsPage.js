var adsTable = $('#adsTable').DataTable({
    processing: true,
    serverSide: true,
    "order"   : [[0, "desc"]],
    ajax      : {
        url : 'getAdsTable',
        data: function (d) {
            d.fromDate = $('#fromDate').val();
            d.toDate   = $('#toDate').val();
        }
    },
    columns   : [
        {data: "id"},
        {data: "adsName"},
        {data: "adsPrice"},
        {data: "adsCountry"},
        {data: "adsRegion"},
        {data: "adsContactNo"},
        // {
        //   "data": null,
        //   "searchable": false,
        //   "render": function(data, type, row, meta){ 
        //     return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success userEditBtn" data-target="#editModal" data-id="'+ row.id +'" data-name="' + row.name + '" data-email="'+ row.email +'">Edit</button>';
        //   }
        // },

        {
            "data"      : null,
            "searchable": false,
            "render"    : function (data, type, row, meta) {
                return '<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnDeleteAds" data-target="#editModal" data-id="' + row.id + '" data-name="' + row.name + '" data-email="' + row.email + '">Delete</button>';
            }
        },

    ],

    "fnDrawCallback": function () {

        $('.btnDeleteAds').on('click', function (e) {
            if (confirm('Are you sure to delete?')) {

                var adsId = $(this).attr('data-id');

                $.ajax({
                    type    : "POST",
                    url     : 'deleteAds',
                    headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data    : ({"adsId": adsId}),
                    dataType: "html",
                    success : function (data) {

                        if (data.includes('1')) {
                            alert("delete successful");
                            adsTable.ajax.reload();
                        } else {
                            alert("Delete Fail");
                        }

                    },
                    error   : function () {
                        alert('Something Wrong ! Please Try Again');
                    }
                });
            }
        });
    }
});