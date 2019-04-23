<?php
include"header.php";
if(isset($_GET['id'])){
	$factor = $_GET['id'];
}else{
	$factor = 0;
}
?>
<div class="container-fluid">
	<h2 style="float: right">مدیریت اسناد <?php echo get_item_name($factor); ?></h2>
	<a href="items.php" class="btn btn-info btn-lg" style="float: left;">بازگشت</a>
	<section class="col-lg-12 col-md-12">

		<h3 class="text-center">آپلود فایل</h3><hr>
		<form class="form-horizontal" method="post" enctype="multipart/form-data">
			<div class="factor-body-form">
				<div class="row">
					<div class="col-md-4 form-group">
						<label class="col-md-5 control-label">کد</label>
						<div class="col-md-7">
							<input readonly="readonly" name="factor" class="form-control" type="text" value="<?php echo $factor; ?>">
						</div>
					</div>
					<div class="col-md-4 form-group">
						<label class="col-md-5 control-label">انتخاب فایل</label>
						<div class="col-md-7">
							<input name="file" class="form-control" type="file">
						</div>
					</div>
					<div class="col-md-4 form-group">
						<label class="col-md-5 control-label">عنوان فایل</label>
						<div class="col-md-7">
							<input required name="namee" class="form-control" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center form-group">
						<div class="col-md-12">
							<button name="upload-media" class="btn btn-success">آپلود فایل</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<?php
		if(isset($_POST['upload-media'])){
			$factor = $_POST['factor'];
			$namee = $_POST['namee'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    		$check = getimagesize($_FILES["file"]["tmp_name"]);
    		if($check !== false) {
        		$uploadOk = 1;
    		} else {
        		alert("warning", "فایل ارسال شده معتبر نیست");
        		$uploadOk = 0;
    		}

			if (file_exists($target_file)) {
    			alert("warning", "فایلی با این نام از قبل وجود دارد. لطفا نام فایل خود را تغییر دهید و مجدد آن را آپلود کنید");
    			$uploadOk = 0;
			}

			if ($_FILES["file"]["size"] > 500000) {
    			alert("warning", "حجم فایل شما باید زیر 5 مگابایت باشد");
    			$uploadOk = 0;
			}

			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"

				&& $imageFileType != "gif" ) {
				alert("warning", "فقط فرمت های JPG, JPEG, PNG و GIF قابل قبول هستند");
				$uploadOk = 0;
			}

			if ($uploadOk == 0) {
				alert("danger", "متاسفیم فایل شما آپلود نشد");
			} else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$img_name = basename( $_FILES["file"]["name"]);
					$datee = jdate('Y/m/d H:i');
					$src = "/uploads/". $img_name;
					ex_query("insert into media(factor, src, datee, namee) values($factor, '$src', '$datee', '$namee')");
					alert("success", "فایل با موفقیت آپلود شد");
				} else {
					alert("danger", "متاسفیم. خطایی زمان آپلود رخ داده است. مجددا امتحان کنید");
				}

			}
		}
		?>
		<hr>
		<?php
		if(isset($_POST['remove'])){
			$id = $_POST['remove'];
			$src = $_POST['src'];
			$list = explode('/', $src);
			$c = count($list);
			$filename = "uploads/" . $list[$c-1];
			if (file_exists($filename)) {
                unlink($filename);
                ex_query("delete from media where ID=$id");
				alert("success", "تصویر با موفقیت حذف شد"); 
				?>
				<script type="text/javascript">
					window.location.reload();
					return;
				</script>
				<?php
            } else {
				alert("danger", "خطا در حذف تصویر رخ داده است"); 
            }
		}
		?>
		<form action="" method="post">
			<div class="row">
				<?php
				$list = get_select_query("select * from media where factor=$factor and src!=''");
				foreach($list as $l){ ?>
				<div class="col-md-4">
					<div class="badge text-center">
						<img style="width: 100px; height: auto;" data-toggle="modal" data-target="#modal<?php echo $l['ID']; ?>" src="<?php theme_dir(); ?>/<?php echo $l['src']; ?>" class="img-responsive">
						<div id="modal<?php echo $l['ID']; ?>" class="modal fade" role="dialog">
  							<div class="modal-dialog modal-lg">
    							<div class="modal-content">
      								<div class="modal-header">
        								<button type="button" class="close" data-dismiss="modal">&times;</button>
        								<h4 class="modal-title"><?php echo $l['namee']; ?></h4>
      								</div>
      								<div class="modal-body">
        								<img src="<?php theme_dir(); ?>/<?php echo $l['src']; ?>" class="img-responsive">
      								</div>
					     		 	<div class="modal-footer">
        								<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
      								</div>
    							</div>
  							</div>
						</div>
						<input type="hidden" name="src" value="<?php echo $l['src']; ?>">
						<button onclick="confirm('آیا از حذف این فایل اطمینان دارید؟')" class="btn btn-danger" name="remove" value="<?php echo $l['ID']; ?>">حذف</button>
					</div>
				</div>
					<?php
					} ?>
			</div>
		</form>
	</section>
</div>
<?php include"footer.php"; ?>