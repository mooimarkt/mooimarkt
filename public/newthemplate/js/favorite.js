jQuery(function ($) {


    $('body').on('click','*[data-favorite]',function () {

        let loader = new TextLoader($('.favorite_loader'));

        loader.setTitle("Add");
        loader.startLoading();

       $.post(
           `/favorite/${this.classList.contains("add") ? "add" : "remove"}/`+
           this.dataset.id+
           "/"+this.dataset.favorite,
           res => {

               loader.stopLoading();
               loader.showMesage(this.classList.contains("add") ? "Aded!" : "Removed");

               this.classList.toggle('add');
               this.classList.toggle('remove');
               this.parentElement.classList.toggle('favorite_active');

       }).fail(new Fail(loader));

    });


    let Fail = function (loader) {

        return function (res) {

            loader.stopLoading();

            if (
                typeof res.responseJSON == "object" &&
                typeof res.responseJSON.errors == "object"
            ) {

                let msg = "";

                for (let Field in res.responseJSON.errors) {

                    msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                }

                loader.showMesage(msg)

            } else {

                loader.showMesage("Unexpected responce");
                console.error("Respose: ", res);

            }

        }

    }

});