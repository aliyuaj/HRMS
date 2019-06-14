<?php
	//require_once('includes/image_compress.php');
require'../includes/conn.php';
$path = "../images/passport/";

	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
            $staffID=$_POST['sid'];
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];

			if(strlen($name))
				{
					list($txt1, $ext1) = explode(".", $name);
					$ext=strtolower($ext1);
					$txt=strtolower($txt1);
					if(in_array($ext,$valid_formats))
					{
						if($size<(1024*1024))
						{

							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							//if(compress_image($_FILES['photoimg']['tmp_name'], $actual_image_name, 100))
							//{
								if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
									$query = mysqli_query($con,"UPDATE personalinfo SET passport='$actual_image_name' WHERE staffID='$staffID'");
                                    $_SESSION['PASSPORT']=$actual_image_name;
										echo "<img src='../images/passport/".$actual_image_name."' height='150px' width='150px'  id='preview'>";
								}
								else
									echo "failed";

							//}else{ echo "Out range";}
						}
						else
							echo "Image file size max 1 MB";
					}
					else
						echo "Invalid file format..";
				}

			else
				echo "Please select image..!";

				// Delete the uploaded file if it still exists:
				if ( isset($tmp) && file_exists ($tmp) && is_file($tmp) )
				{
					unlink ($tmp);
				}

			exit;
		}
?>