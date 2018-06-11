<footer class="footer">

	<div class="container">

		<p>&copy; My Website 2018</p>
	
	</div>
</footer>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	
	
	
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="loginModalTitle">Login</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  
		  <div class="alert alert-danger" id="loginAlert"></div>
		  
			<form>
				<input type="hidden" name="loginActive" id="loginActive" value="1">
			  <div class="form-group">
				<label for="email">Email address</label>
				<input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" class="form-control" id="password" placeholder="Password">
			  </div>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-light" id="togglelogin">Sign up</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="loginSignUpButton">Login</button>
		  </div>
		</div>
	  </div>
	</div>
	
	<script>
	
		$("#togglelogin").click(function(){
			if($("#loginActive").val() == "1"){
				
				$("#loginActive").val("0");
				$("#loginModalTitle").html("Sign up");
				$("#loginSignUpButton").html("Sign up");
				$("#togglelogin").html("Login");
				
			} else {
				
				$("#loginActive").val("1");
				$("#loginModalTitle").html("Login");
				$("#loginSignUpButton").html("Login");
				$("#togglelogin").html("Sign up");
				
			}
		})
		
		$("#loginSignUpButton").click(function(){
			
			
			$.ajax({
				type:"POST",
				url:"actions.php?action=loginSignup",
				data:"email=" + $("#email").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
				success: function(result){
					if(result == "1"){
						window.location.assign("http://wsomerset.info/12-twitter/");
					} else {
						$("#loginAlert").html(result).show();
					}
				}
			})
			
		})
		
		$(".toggleFollow").click(function(){
		  //  alert($(this).attr("data-userId"));
		    
		    var id = $(this).attr("data-userId");
		    
		    $.ajax({
				type:"POST",
				url:"actions.php?action=toggleFollow",
				data:"userId=" + id,
				success: function(result){
					if(result == "1"){//unfollowed change to follow
					    $("button[data-userId='" + id + "']").html("Follow");
					} else if (result == "2"){
					    $("button[data-userId='" + id + "']").html("Unfollow");
					}
				}
			})
		})
		
		$("#postTweetButton").click(function(){
		    $.ajax({
				type:"POST",
				url:"actions.php?action=postTweet",
				data:"tweetContent=" + $("#tweetContent").val(),
				success: function(result){
				    
					
					if(result == "1"){
					    $("#tweetSuccess").show();
					    $("#tweetFail").hide();
					} else if(result != ""){
					    $("#tweetFail").html(result).show();
					    $("#tweetSuccess").hide();
					}
				}
			})
		})
	
	</script>
	
	
  </body>
</html>