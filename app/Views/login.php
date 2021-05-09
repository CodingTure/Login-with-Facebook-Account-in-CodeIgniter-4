<!DOCTYPE html>
<html lang="en">
<head>
	<title>User Login</title>
	<?php include('header.php'); include('menu.php'); ?>
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData('success')) echo session()->getFlashData('success') ?></span>
				<span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData('error')) echo session()->getFlashData('error') ?></span>
				<form class="login100-form validate-form flex-sb flex-w" action="" method="post" >
					<span class="login100-form-title p-b-32"> User Login </span>

					<span class="txt1 p-b-11"> Email </span>
					<div class="wrap-input100 validate-input m-b-36" data-validate="Email is required">
						<input class="input100" type="text" name="email" value="">
						<span class="focus-input100"></span>						
						<span></span>
					</div>

					<span class="txt1 p-b-11"> Password </span>
					<div class="wrap-input100 validate-input m-b-12" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn"> Login </button>
					</div>
					<div class="" style="margin-left: 200px;">
						<u><a href="">Don't have an Account.</a></u>
					</div>
				</form>
				<?php  
					if($fb_btn){
						echo "<a href='".$fb_btn."' ><img src='public/uploads/facebook.png'></a>";
					}
				?>
				
			</div>
		</div>
	
    <?php include('footer.php'); ?>
