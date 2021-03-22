var userTable = $('#userTable').DataTable({
    processing: true,
    serverSide: true,
    "order": [[ 0, "desc" ]],
    ajax: {
        url: 'getUserTable',
        data: function (d) {
            d.userFromDate = $('#userFromDate').val();
            d.userToDate = $('#userToDate').val();
        }
    },
      columns:[
        {data: "id"},
        {data: "userType"},
        {data: "userRole"},
        {data: "name"},
        {data: "email"},
        {data: "country"},
        {data: "region"},
        {data: "phone"},
        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success userEditBtn" data-target="#editModal" data-id="'+ row.id +'" data-role="'+ row.userRole +'" data-name="' + row.name + '" data-email="'+ row.email +'">Edit</button>';
          }
        },

        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success userDeleteBtn" data-target="#editModal" data-id="'+ row.id +'" data-name="' + row.name + '" data-email="'+ row.email +'">Delete</button>';
          }
        },

      ],

      "fnDrawCallback":function(){
        $('.userEditBtn').on('click', function(e) {
          //get the id or the row
            $('#modalEditUser').modal('show');
            $('#txtUserId').val($(this).attr('data-id'));
            $('#txtUserEmail').val($(this).attr('data-email'));
            $('#txtUserName').val($(this).attr('data-name'));
            $('#modalDropDownRole').val($(this).attr('data-role'));
        });

        $('.userDeleteBtn').on('click', function(e) {

          if(confirm('Are you sure to delete ?')){
          var id = $(this).attr('data-id');

            $.ajax({
              type: "POST",
              url: 'deleteUser',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: ({ "id": id }),
              dataType: "html",
              success: function(data) {
                
                if(data.includes('1')){
                  alert("delete successful");
                      userTable.ajax.reload();
                }
                else{
                  alert("Delete Fail");
                }
                  
              },
              error: function() {
                  alert('Something Wrong ! Please Try Again');
              }
            });
          }
        });
      }
});

$('#btnSubmitUpdateUser').on('click', function(e) {

  var id = $('#txtUserId').val();
  var email = $('#txtUserEmail').val();
  var name = $('#txtUserName').val();
  var role = $('#modalDropDownRole').val();

    $.ajax({
      type: "POST",
      url: 'updateUser',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: ({ "id": id, "email": email, "name": name, "userRole":role }),
      dataType: "html",
      success: function(data) {

        if(data.includes('1')){
          alert('Update successful');
              $('#modalEditUser').modal('hide');
              userTable.ajax.reload();
        }
        else{
          alert("Email had been used");
        }
          
      },
      error: function() {
          alert('Something Wrong ! Please Try Again');
      }
    });
});