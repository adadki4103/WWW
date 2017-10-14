<html><head>
<link rel="icon" type="img" href="geckoIcon.png">
<script src="jquery-1.11.3.min.js"></script>
<style>
.passcode {
	float: left;
	color:#FFFFFF;
    width: 280px;
    height: 320px;
    background-color: #00CCFF;
    position: absolute;
	left: 40px;
	bottom:235px;
    margin: auto;
    border-radius: 25px;
    border: 2px solid #FFFFFF;
    padding: 20px;
	text-align: center;}
	
.imageRight {
	float: right;
	position: absolute;
	left: 400px;
	bottom:70px;
	width: 900px;
	height: 700px;
	background-color: #FF9933;
	border-radius: 25px;
	border: 2px solid #FFFFFF;}
	
.slidyContainer {
	width: 100%;
	overflow: hidden;}

/* unvisited link */
a:link {color: #FFFF66;}
/* visited link */
a:visited {color: #FFFF66;}
/* selected link */
a:active {color: #FF9933;}
/* mouse over link */
a:hover {color: #FF99CC ;}
  
.body {
	color: #FFFFFF;
    background-color: #000000;
	overflow: hidden;}
	
.btn {
  background: #3498db;
  border-radius: 12px;
  font-family: Arial;
  color: #FFFFFF;
  font-size: 20px;}

.btn:hover {
  background: #3cb0fd;
  text-decoration: none;
  }
</style>
</head>
<body class="body">
<title>My Gecko Army</title>

<div id="slidyContainer">
<figure id="slidy">
<img src="geckobg0.jpg">
<img src="geckobg1.jpg">
<img src="geckobg2.jpg">
<img src="geckobg3.jpg">
<img src="geckobg4.jpg">
<img src="geckobg5.jpg">
</figure>
</div>


<div class="passcode" id="passcode">
<img src="supTag.png">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
User Name:
<input type="text" name="userName"><br><br>
Password: 
<input type="text" name="passWord"><br><br>
<input type="submit" style="width:100px; height:40px" value="Submit" class="btn">

<!-- New Users ? -->
<a href="newUser.html" style="text-decoration:none">
<h3><tt>Create New User</h3></tt>
</a>
</form>
</div>


<!-- Background Slider found @ "http://demosthenes.info/blog/838/CSSslidy-An-Auto-Generated-Responsive-CSS3-Image-Slider" -->

<script>
var timeOnSlide = 4,
timeBetweenSlides = 2,
animationstring = 'animation',
animation = false,
keyframeprefix = '',
domPrefixes = 'Webkit Moz O Khtml'.split(' '),
pfx = '',
slidy = document.getElementById("slidy");
if (slidy.style.animationName !== undefined) { animation = true; }
if ( animation === false ) {
for ( var i = 0; i < domPrefixes.length; i++ ) {
if ( slidy.style[ domPrefixes[i] + 'AnimationName' ] !== undefined ) {
pfx = domPrefixes[ i ];
animationstring = pfx + 'Animation';
keyframeprefix = '-' + pfx.toLowerCase() + '-';
animation = true;
break;
} } }
if ( animation === false ) {
// animate using a JavaScript fallback, if you wish
} else {
var images = slidy.getElementsByTagName("img"),
firstImg = images[0],
imgWrap = firstImg.cloneNode(false);
slidy.appendChild(imgWrap);
var imgCount = images.length,
totalTime = (timeOnSlide + timeBetweenSlides) * (imgCount - 1),
slideRatio = (timeOnSlide / totalTime)*100,
moveRatio = (timeBetweenSlides / totalTime)*100,
basePercentage = 100/imgCount,
position = 0,
css = document.createElement("style");
css.type = "text/css";
css.innerHTML += "#slidy { text-align: left; margin: 0; font-size: 0; position: relative; width: " + (imgCount * 100) + "%; }";
css.innerHTML += "#slidy img { float: left; width: " + basePercentage + "%; }";
css.innerHTML += "@"+keyframeprefix+"keyframes slidy {";
for (i=0;i<(imgCount-1); i++) {
position+= slideRatio;
css.innerHTML += position+"% { left: -"+(i * 100)+"%; }";
position += moveRatio;
css.innerHTML += position+"% { left: -"+((i+1) * 100)+"%; }";
}
css.innerHTML += "}";
css.innerHTML += "#slidy { left: 0%; "+keyframeprefix+"transform: translate3d(0,0,0); "+keyframeprefix+"animation: "+totalTime+"s slidy infinite; }";
document.body.appendChild(css);
}
</script>




</body>
</html>



<?php if(!empty($_POST)){
$servername = "localhost";
$dbusername = "root";
$username = $_POST["userName"];
$password = $_POST["passWord"];
$dbpassword = "";
$dbName = "myGeckoArmy";
$options = ['cost' => 12,];
$hashedPassWord = password_hash($password, PASSWORD_BCRYPT, $options);


function checkUserName($username, $servername, $dbusername, $dbpassword, $dbName) {
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbName); 
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		} 
	$newSqlQuery = "SELECT * FROM users WHERE userName='".$username."'";
	$result = $conn->query($newSqlQuery);
	if($result->num_rows>0){
		return TRUE;
		// Does exist
	}
	else{
		return FALSE;
		// Does NOT exist
	}
	$conn->close();
}

function checkPassword($username, $servername, $dbusername, $dbpassword, $dbName, $password) {
	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbName); 
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		} 
	$newSqlQuery = "SELECT * FROM users WHERE userName='".$username."'";
	
	$result = $conn->query($newSqlQuery);
	while($row = $result->fetch_assoc()){
		if ((password_verify($password, $row['hashedPassWord']))) {
			return TRUE;
		} 
		else {
			return FALSE; 
		}
	}
}
	


if (((checkUserName($username, $servername, $dbusername, $dbpassword, $dbName)) === TRUE)&& ((checkPassword($username, $servername, $dbusername, $dbpassword, $dbName, $password)) === TRUE)){
	// User DOES exist, therefore. Proceed to welcome page.
	header("Location: welcome.html"); 	
	$conn-close();
	exit();
}
else{
	// User does NOT exist, therefore. Proceed to new User page.
	header("Location: indexBad.php"); 
    $conn->close();
	exit();
}

}
?>