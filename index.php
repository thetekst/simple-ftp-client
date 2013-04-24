<?php

define('GW_MAXFILESIZE', 10490000); // 10Mb
define("USER_NAME", "user");
define("USER_PASS", "0J184yM7rt");
define("USER_HOST", "62.76.187.249");

if(isset($_POST['submit'])) {
	$thisFile = $_FILES['uploadedfile']['name'];
	$thisFileSize = $_FILES['uploadedfile']['size'];
	$thisType = $_FILES['uploadedfile']['type'];

	if (!empty($thisFile)) {
		if(($thisFileSize > 0) && ($thisFileSize <= GW_MAXFILESIZE)) {
		
			$source_ftp_path = "./".$thisFile;
			$source_file_path = $_FILES['uploadedfile']['tmp_name'];
			
			// установить базовое соединение
			$conn_id = ftp_connect(USER_HOST);

			// login с username и password
			$login_result = ftp_login($conn_id, USER_NAME, USER_PASS); 

			// проверить соединение
			if ((!$conn_id) || (!$login_result)) { 
					echo "FTP connection has failed!<br>".
						"Attempted to connect to ".USER_HOST." for user ".USER_NAME; 
					die; 
				} else {
					//echo "Connected to ".USER_HOST.", for user \"".USER_NAME."\"<br>";
				}

			// включение пассивного режима
			ftp_pasv($conn_id, true);
				
			// загрузить файл
			$upload = ftp_put($conn_id, $source_ftp_path, $source_file_path, FTP_BINARY); 

			// проверить статус загрузки
			if (!$upload) { 
					echo "FTP upload has failed!";
				} else {
					//echo "Uploaded ".$thisFile." to ".USER_HOST." as ".$source_ftp_path;
					unset($_FILES['uploadedfile']);
				}

			// закрыть поток FTP
			ftp_close($conn_id);
			
			// Try to delete the temporary uploadedfile
			@unlink($_FILES['uploadedfile']['tmp_name']);
		}
	}
}
$htmlForm = '
			<form class="file_input_uploadform" id="uploadform_1" name="uploadform_1" method="post" 
			action="./" enctype="multipart/form-data">
				<input type="file" name="uploadedfile" id="uploadedfile">
				<input type="submit" name="submit" value="Ok" />
			</form>
			';
echo $htmlForm;

?>