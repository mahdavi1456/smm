<?php include"header.php"; ?>
    <div class="light"></div>
	<div class="container-fluid">
		<div class="col-md-6">
			
         
            <div id="frmLogin" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">ثبت ورود</h4>
                            </div>
                            <div class="modal-body text-center">
                                <div class="row">
                                <div class="col-md-6">
                                    <h4>تعداد</h4>
                                    <select id="g_count" name="g_count" class="form-control">
                                        <option>1</option>    
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <h4>کد اشتراک</h4>
                                    <input id="login-p-code" class="form-control" type="text" name="p_code" placeholder="لطفا کد اشتراک را وارد کنید...">
                                </div>
                                </div>
                                <br>
                                <button id="set-desktop-login" class="btn btn-success btn-lg">ثبت ورود</button><br>
                                <div id="set-desktop-login-result"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>
            
            
            <h3>صورتحساب<a href="payment.php" style="float: left;" class="btn btn-danger">مدیریت حساب شخص</a></h3>
            <div class="m500 well well-lg desktop">
                <div id="factor-result"></div>
            </div>

		</div>

        <div class="col-md-6">
            <h3 style="width: 100%">لیست افراد حاضر			
                <button style="float: left;" id="desktop_login_btn" data-toggle="modal" data-target="#frmLogin" class="btn btn-success">ثبت ورود</button>
			</h3>
            <div class="m500 well well-lg">
                <label>جستجوی شخص</label><br>
                <form action="" method="post">
                    <button name="search_p_code" style="width: 28%; float: left; padding: 14px 0;" class="btn btn-success">جستجو</button>
                    <input style="width: 70%;" type="text" class="form-control" placeholder="کد را در این قسمت وارد کنید" name="p_code">
                </form>
                <hr>
                <?php
                $i = 1;
                if(isset($_POST['search_p_code'])){
                    $p_code = $_POST['p_code'];
                    $p_id = get_var_query("select p_id from person where p_code = '$p_code'");
                    $res = get_select_query("select * from game where p_id = $p_id and g_status = 0");
                }else if(isset($_POST['show_all'])){
                    $res = get_select_query("select * from game where g_status = 0");
                }else{
                    $res = get_select_query("select * from game where g_status = 0");
                }
                if(count($res)>0){
                    ?>
                    <table class="table table-striped">
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>تعداد</th>
                            <th>ساعت ورود</th>
                            <th>مدیریت</th>
                        </tr>
                    <?php
                    foreach($res as $row){
                        $p_name = get_name("person", "p_name", "p_id", $row['p_id']);
                        $p_family = get_name("person", "p_family", "p_id", $row['p_id']);
                        ?>
                        <tr>
                            <td><?php echo per_number($i); ?></td>
                            <td><?php echo $p_name . " " . $p_family; ?></td>
                            <td><?php echo per_number($row['g_count']); ?></td>
                            <td><?php echo per_number($row['g_in']); ?></td>
                            <td>
                                <button data-toggle="modal" data-target="#frmShop<?php echo $row['p_id']; ?>" data-pid="<?php echo $row['p_id']; ?>" class="index-load-factor-btn btn btn-warning btn-sm"><span class="glyphicon glyphicon-apple"></span></button>
                                <button data-pid="<?php echo $row['p_id']; ?>" data-gid="<?php echo $row['g_id']; ?>" class="load-factor btn btn-info btn-sm"><span class="glyphicon glyphicon-hourglass"></span></button>
                            </td>
							<div id="frmShop<?php echo $row['p_id']; ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">فروشگاه</h4>
										</div>
										<div class="modal-body text-center">
											<?php
											$items = get_select_query("select * from product");
											foreach($items as $item){ ?>
												<button style="margin-bottom: 5px;" data-pid="<?php echo $row['p_id']; ?>" class="btn btn-warning btn-lg set-pro-to-cart" value="<?php echo $item['pr_id']; ?>"><?php echo $item['pr_name']; ?></button>
												<?php } ?>
											<hr>
											<div id="set-factor-result<?php echo $row['p_id']; ?>"></div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
										</div>
									</div>
								</div>
							</div>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            <form class="text-center" action="" method="post">
                                <button name="show_all" class="btn btn-info btn-lg">نمایش همه افراد حاضر</button>
                            </form>
                        </td>
                    </tr>
                    </table>
                    <?php
                }else{ ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="alert alert-danger text-center">موردی یافت نشد</div>
                            <form class="text-center" action="" method="post">
                                <button name="show_all" class="btn btn-info btn-lg">نمایش همه افراد حاضر</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </div>
        </div>


	</div>
<?php include"footer.php"; ?>