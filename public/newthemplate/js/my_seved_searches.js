jQuery(function ($) {

    let SaveSearch = new SimpleSave({}, $);

    $('body')
        .on('click', '*[data-remove-ss]', function () {

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this search",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    return SaveSearch.Remove(this.dataset.removeSs)
                }

                return new Promise(function () {})

            })
            .then(()=>{

                swal("Removed",'','success');

                $(this).parents(".sev_serch_block:first").remove();

            })
            .catch(msg=>{
                swal("Error",msg,'error');
        });

    })
        .on('click','*[data-notify-ss]',function () {

            if(this.classList.contains("notif_on")){

                this.classList.remove("notif_on");

                this.src = "/newthemplate/img/Rounded_ic.svg";

                SaveSearch.Update(this.dataset.notifySs,{ notify:0 })
                    .catch(function (msg) { swal('Error',msg,'error') });

            }else{

                this.classList.add("notif_on");
                this.src = "/newthemplate/img/Rounded_ic_dis.svg";

                SaveSearch.Update(this.dataset.notifySs,{ notify:1 })
                    .catch(function (msg) { swal('Error',msg,'error') });

            }

    })

});