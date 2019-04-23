$(document).ready(function() {
    
    
    $("#login-p-code").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#set-desktop-login").click();
        }
    });

    $('#set-desktop-login').click(function(){
        $('#set-desktop-login-result').html("<div class='alert alert-warning'>در حال پردازش...</div>");
        var p_id = $('#login-p-code').val();
        var g_count = $('#g_count').find('option:selected').html();
        $.post("", {set_login:1, p_id:p_id, g_count:g_count}, function(data){
            if(data=="ok")
                window.location.reload();
            else
                $('#set-desktop-login-result').html(data);
        });
    });

    $('.set-pro-to-cart').click(function(){
        var p_id = $(this).data('pid');
        var pr_id = $(this).val();
        $('#set-factor-result' + p_id).html("در حال پردازش...");
        $.post("", {set_pro_to_cart:1, p_id:p_id, pr_id:pr_id}, function(data){
            $('#set-factor-result' + p_id).html(data);
        });
    });

    $(document.body).on('click', '.remove-from-factor' ,function(){
        var fid = $(this).data('fid');
        var pid = $(this).data('pid');
        $('#set-factor-result' + pid).html("در حال پردازش...");
        $.post("", {remove_from_factor:1, fid:fid, pid:pid}, function(data){
            $('#set-factor-result' + pid).html(data);
        });
    });


    $('.load-factor').click(function(){
        $('#factor-result').html("در حال پردازش...");
        var gid = $(this).data('gid');
        var pid = $(this).data('pid');
        $.post("", {load_factor:1, pid:pid, gid:gid}, function(data){
            $('#factor-result').html(data);
        });
    });


    $(document.body).on('click', '#pay' ,function(){
		$('.light').fadeIn();
        $('#pay-result').html("در حال پردازش...");
        var pay_p_id = $('#pay_p_id').val();
        var pay_price = $('#pay_price').val();
        var pay_type = $('#pay_type').find('option:selected').html();
        $.post("", {add_pay:1, pay_p_id:pay_p_id, pay_price:pay_price, pay_type:pay_type,}, function(data){
            $('#pay-result').html(data);
			$('.light').fadeOut();
        });
    });

    $(document.body).on('click', '#set-out' ,function(){
        var gid = $(this).data('gid');
        var last = $(this).data('last');
        var pack = $(this).data('pack');
		var ezafe = $(this).data('ezafe');
        $.post("", {set_out:1, gid:gid, last:last, pack:pack, ezafe:ezafe}, function(){
            window.location.reload();
        });
    });


    $('.index-load-factor-btn').click(function(){
        var p_id = $(this).data('pid');
        $('#set-factor-result' + p_id).html("در حال پردازش...");
        $.post("", {load_light_factor:1, p_id:p_id}, function(data){
            $('#set-factor-result' + p_id).html(data);
        });
    });


	$("#sms_text").on("keyup", function() {		
		var value = $(this).val();
		var c = value.length;
		if(c==0){
			$('#sms_page').html("0");
			$('#sms_size').html("70");
		}else{
			if(c>0 && c<=70){
				$('#sms_page').html("1");
				$('#sms_size').html(70-c);	
			}
			if(c>=71 && c<=132){
				$('#sms_page').html("2");
				$('#sms_size').html(132-c);	
			}
			if(c>=133 && c<=198){
				$('#sms_page').html("3");
				$('#sms_size').html(198-c);
			}
			if(c>=199 && c<=264){
				$('#sms_page').html("4");
				$('#sms_size').html(264-c);
			}
			if(c>=265 && c<=330){
				$('#sms_page').html("5");
				$('#sms_size').html(330-c);
			}
			if(c>=331 && c<=396){
				$('#sms_page').html("6");
				$('#sms_size').html(396-c);
			}
			if(c>=397 && c<=462){
				$('#sms_page').html("7");
				$('#sms_size').html(462-c);
			}
			if(c>=463 && c<=528){
				$('#sms_page').html("8");
				$('#sms_size').html(528-c);
			}
			if(c>=529 && c<=594){
				$('#sms_page').html("9");
				$('#sms_size').html(594-c);
			}
			if(c>=595 && c<=660){
				$('#sms_page').html("10");
				$('#sms_size').html(660-c);
			}
			if(c>=661){
				$('#sms_page').html("11");
				$('#sms_size').html(661-c);
			}
		}
	});

	
	$('#send-type').change(function(){
        var send_type = $(this).find('option:selected').val();
		if(send_type=="-"){
			$('.p-alt').hide();
		}
		if(send_type==0){
			$('.p-alt').hide();
			$('#p-1').show();
		}
		if(send_type==1){
			$('.p-alt').hide();
			$('#p-2').show();
		}
		if(send_type==2){
			$('.p-alt').hide();
			$('#p-3').show();
		}
    });
	
});