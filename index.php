<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GitHUB User Search</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/jquery.js"></script>
</head>
<body>
    <form id="user_form" method="POST" role="form" class="form-horizontal" name="user_form">
        <div id="wrapper">
            <!-- Navigation -->
            <div style="border-bottom: 1px solid #e7e7e7; background-color:white" ;>
            </div>
            <div id="page-wrapper01">
                <!-- /.row -->
                <div class="row col-lg-12">
                    <div class="col-lg-6 col-md-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                GitHUB : Search User
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <input class="form-control" name='search' id='search'>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" style="text-align: center;">
                                                <input id="show_user" type="button" value="Add" name="submit" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div id="userDetailsPanel" class="col-lg-6 col-md-offset-3 hide">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                GitHUB : User Details
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                       <table id="userDetailsTable" class="table table-bordered">
									   
									   </table>
									   <div class="col-sm-12">
                                            <div class="form-group" style="text-align: center;">
                                                <a href="userDetails.php" class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
	$(document).ready(function() {
	 var userID = localStorage.getItem('userID');
	 if(userID) {
		loadUserDetails();
		$("#search").val(userID);
	 }
		
		/*START : Fetch User details from GitHUB API*/
		$("#show_user").click(function() {
			var userID = $.trim($("#search").val());
			if (userID == '') {
				alert('Please enter the GitHUB username');
				return false;
			}
		$.ajax({
			url: "https://api.github.com/users/" + userID,
			type: "GET",
			dataType: "json",
			async: false,
			crossDomain: true,
			success: function(responseData) {
				if(responseData.login) {				
					localStorage.setItem('userID', userID);
					localStorage.setItem('userDetails', JSON.stringify(responseData));
					loadUserDetails();
				}
			},
			error: function(xhr, status, error) {
				alert('Username not found. Please enter valid username');
				localStorage.removeItem('userID');
				localStorage.removeItem('userDetails');
			}
		});
	});
		/*END : Fetch User details from GitHUB API*/
});


/* Function to load user data from localstorage */
function loadUserDetails() {
		var responseData = $.parseJSON(localStorage.getItem('userDetails'));
		var outputStr = "";
		outputStr += '<tr><td><img src="'+responseData.avatar_url+'" width="60"></td><td><a name='+responseData.login+' class="userID" href="'+responseData.html_url+'">'+responseData.login+'</a></td></tr>';					
		outputStr += '<tr><td>Name</td><td>'+responseData.name+'</td></tr>';
		outputStr += '<tr><td>Company</td><td>'+responseData.company+'</td></tr>';
		outputStr += '<tr><td>Location</td><td>'+responseData.location+'</td></tr>';
		outputStr += '<tr style="border-bottom:3px solid #000"><td>Email</td><td>'+responseData.email+'</td></tr>';
		outputStr += '<tr><td>Followers</td><td>'+responseData.followers+'</td></tr>';
		outputStr += '<tr><td>Following</td><td>'+responseData.following+'</td></tr>';
		outputStr += '<tr><td>Member Since</td><td>'+responseData.created_at+'</td></tr>';
		outputStr += '<tr><td>Public Repos</td><td>'+responseData.public_repos+'</td></tr>';
		outputStr += '<tr><td>Public Gists</td><td>'+responseData.public_gists+'</td></tr>';
		$("#userDetailsPanel").removeClass('hide');
		$("#userDetailsTable").html(outputStr);
}
</script>
</form>
</body>
</html>