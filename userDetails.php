<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GitHUB User Details</title>
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
					<div id="userDetailsRepoFollower" class="col-lg-6 col-md-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                GitHUB : User Public Repos & Followers
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <div class="form-group">
									 <table id="userDetailsTable" class="table table-bordered">
									   
									   </table>
										<div  style="width:45%;float:left;">
										  <label>List Of Public Repos</label>
										   <table id="userDetailsRepo" class="table table-bordered">
										   
										   </table>
										</div>
										<div  style="width:45%;float:right;">
										  <label>List Of Followers</label>
										   <table id="userDetailsFollower" class="table table-bordered">
										   
										   </table>
										</div>
										<div class="col-sm-12">
                                            <div class="form-group" style="text-align: center;">
                                                <a href="search.php" class="btn btn-primary">Back</a>
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
		/*START : Fetch follower details from GitHUB API*/
		var userID = localStorage.getItem('userID');
		$.ajax({
				url: "https://api.github.com/users/"+ userID +"/followers",
				type: "GET",
				dataType: "json",
				async: false,
				crossDomain: true,
				success: function(responseData) {
					var outputStr = "";
					if(responseData.length > 0 ){				
							$(responseData).each(function(i,value) {
								 outputStr += '<tr><td>'+parseInt(i+1)+'</td><td><a href="'+value.html_url+'">'+value.login+'</a></td></tr>';	
							});
						$("#userDetailsFollower").html(outputStr);
					} else {
						$("#userDetailsFollower").html("<tr><td>No Followers found for the given username</td></tr>");
					}
				},
				error: function(xhr, status, error) {
					alert('Username not found. Please enter valid username');
				}
		});
		/*END : Fetch follower details from GitHUB API*/
		/*START : Fetch repo details from GitHUB API*/
		$.ajax({
				url: "https://api.github.com/users/"+ userID +"/repos",
				type: "GET",
				dataType: "json",
				async: false,
				crossDomain: true,
				success: function(responseData) {
					var outputStr = "";
					if(responseData.length > 0 ){				
							$(responseData).each(function(i,value) {
								 outputStr += '<tr><td>'+parseInt(i+1)+'</td><td><a href="'+value.html_url+'">'+value.name+'</a></td></tr>';	
							});
						$("#userDetailsRepo").html(outputStr);
					} else {
						$("#userDetailsRepo").html("<tr><td>No Repos found for the given username</td></tr>");
					}
				},
				error: function(xhr, status, error) {
					alert('Username not found. Please enter valid username');
				}
		});
		/*END : Fetch repo details from GitHUB API*/
		
		//Load User Profile photo and username from localstorage
		var responseData = $.parseJSON(localStorage.getItem('userDetails'));
		var outputStr = "";
		outputStr += '<tr><td><img src="'+responseData.avatar_url+'" width="60"></td><td><a name='+responseData.login+' class="userID" href="'+responseData.html_url+'">'+responseData.login+'</a></td></tr>';
		$("#userDetailsTable").html(outputStr);
		
	});
</script>
</form>
</body>
</html>