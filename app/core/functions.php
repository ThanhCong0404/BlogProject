<?php 

function query(string $query,array $data = []){
	

	$string = "mysql:hostname=".DB_HOST.";dbname=".DB_NAME;
	$con = new PDO($string,DB_USER,DB_PASS);

	$stm = $con->prepare($query);
	$stm->execute($data);

	/* Phương thức `fetchAll` sử dụng đối số `PDO::FETCH_ASSOC` để chỉ định rằng mảng kết quả trả về sẽ sử dụng tên cột của bảng (hoặc tên trường của bảng) làm khóa của mảng. */
	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
	if(is_array($result) && !empty($result)){
		return $result;
	}

	return false;
}

function redirect($page){
	header('location: '.$page);
	die;
}

function old_value($key){
	if(!empty($_POST[$key])) return $_POST[$key];

	return "";

}

function old_checked($key){
	if(!empty($_POST[$key])) return " checked ";

	return "";

}

// chuyển đổi chuổi sang url phục vụ cho SEO web
function str_to_url($url){
	$url = str_replace("'", "", $url); // loại bỏ các ký tự `'`
	$url = preg_replace("~[^\\pL0-9_]+~u", "-", $url); /* thay thế bất kỳ ký tự nào trong chuỗi đầu vào không phải là chữ cái tiếng Anh, số hoặc dấu gạch dưới bằng một dấu gạch ngang. */
	$url = trim($url,"-"); //loại bỏ bất kỳ dấu gạch ngang nào ở đầu hoặc cuối chuỗi.
	$url = iconv("utf-8", "us-ascii//TRANSLIT", $url); /*chuyển đổi các ký tự tiếng Việt(utf-8) có dấu thành dạng không dấu, và các ký tự có ký hiệu đặc biệt thành dạng ASCII*/
	$url = strtolower($url); //
	$url = preg_replace('~[^-a-z0-9_]+~', '', $url); //xóa bất kỳ ký tự nào trong chuỗi đầu vào không phải là chữ cái tiếng Anh, số, dấu gạch dưới hoặc dấu gạch ngang cuối cùng

	return $url;
}

function authenticate($row){
	$_SESSION['USER'] = $row;
}

function logged_in(){
	if(!empty($_SESSION['USER'])){
		return true;
	}

	return false;
}


//create_tables();
function create_tables(){
	

	$string = "mysql:hostname=".DB_HOST.";" ;
	$con = new PDO($string,DB_USER,DB_PASS);

	$query = "create database if not exists ".DB_NAME;
	$stm = $con->prepare($query);
	$stm->execute();

	$query = "use ".DB_NAME;
	$stm = $con->prepare($query);
	$stm->execute();

	//users table
	$query = "create table if not exists users(
		id int primary key auto_increment,
		username nvarchar(50) not null,
		email varchar(100) not null,
		password varchar(255) not null,
		image varchar(1024) null,
		date datetime default current_timestamp,
		role varchar(10) not null,


		key username (username),
		key email (email)
	)";	
	$stm = $con->prepare($query);
	$stm->execute();

	//categories table
	$query = "create table if not exists categories(
		id int primary key auto_increment,
		category varchar(50) not null,
		slug varchar(100) not null,
		disabled tinyint default 0,

		key slug (slug),
		key category (category)
	)";	
	$stm = $con->prepare($query);
	$stm->execute();

	// posts table
	$query = "create table if not exists posts(
		id int primary key auto_increment,		
		user_id int ,
		category_id int ,
		title varchar(100) not null,
		content text null,
		image varchar(1024) null,
		date datetime default current_timestamp,
		slug varchar(100) not null,


		key user_id (user_id),
		key category_id (category_id),
		key title (title),
		key slug (slug),
		key date (date)
	)";	
	$stm = $con->prepare($query);
	$stm->execute();
}

?>