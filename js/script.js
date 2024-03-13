$.ajax({
    url: base_url + "/login/users",
    dataType: "json",
    success: function(data) {
        console.log(data);
    }
});