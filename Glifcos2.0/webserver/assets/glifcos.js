var glifcos_utils = new Object();
glifcos_utils.AddAdminAccount = function(username, password){
    $.ajax({
        url: "server.php",
        method: "POST",
        data: {
            request: "AddAdminAccount",
            username: username,
            password: password
        }
    });
}