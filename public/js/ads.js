$('.inputfile').change(function () {
    if (this.files.length > 10) {
        $(this).val('');
        alert('to many files');
    }
});

// Prevent submission if limit is exceeded.
$('#placeAdsForm').submit(function () {
    if (this.files.length > 10) {
        return false;
        $(this).val('');
        alert('to many files');
    }
});