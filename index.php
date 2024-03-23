<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allied school management</title>
	<!------css style sheet------------>

    <link rel="stylesheet" href="assets/login-styles.css">
</head>
<body>


<div class="form-structor">

<div class="signup">
    <h2 class="form-title" id="signup">Sign up</h2>
    <form action="data-base/register.php" method="post">
        <div class="form-holder">
            <input type="text" class="input" placeholder="Name" name="name" />
            <input type="email" class="input" placeholder="Email" name="email" />

            <input type="password" class="input" placeholder="Password" name="password" />
        </div>
        <button class="submit-btn" type="submit" value="Register">Sign up</button>
    </form>
</div>
<form action="data-base/login.php" method="post">
	<div class="login slide-up">

		<div class="center">
			<h2 class="form-title" id="login">Log in</h2>
			<div class="form-holder">
				<input type="email" class="input" placeholder="Email" name="email"  />
				<input type="password" class="input" placeholder="Password"  name="password"/>
			</div>
			<button class="submit-btn">Log in</button>
		</div>
    
	</div>
</div>

</form>


</body>

<script>
    console.clear();

const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');

loginBtn.addEventListener('click', (e) => {
	let parent = e.target.parentNode.parentNode;
	Array.from(e.target.parentNode.parentNode.classList).find((element) => {
		if(element !== "slide-up") {
			parent.classList.add('slide-up')
		}else{
			signupBtn.parentNode.classList.add('slide-up')
			parent.classList.remove('slide-up')
		}
	});
});

signupBtn.addEventListener('click', (e) => {
	let parent = e.target.parentNode;
	Array.from(e.target.parentNode.classList).find((element) => {
		if(element !== "slide-up") {
			parent.classList.add('slide-up')
		}else{
			loginBtn.parentNode.parentNode.classList.add('slide-up')
			parent.classList.remove('slide-up')
		}
	});
});
</script>

</html>
