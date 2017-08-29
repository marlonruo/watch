<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$id=$_GET['id'];
$canal=$_GET['canal'];
include ("phps/conexion.php");
	 $connect = mysql_connect("$host", "$user", "$pass");
     mysql_select_db("$db", $connect);

	$result = mysql_query("INSERT INTO llama (id_browser, id_caster, estatus) VALUES ('$id', '$canal', '1')");

	$monto = '0';
	$result = mysql_query("SELECT SUM(monto) as total FROM creditos_browser WHERE id_usuario_credito=$id");
	 while($row=mysql_fetch_array($result)){
		$monto = $row['total'];
	 }
	if($monto==""){
		$monto = 0;
	}
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script src="https://www.paypalobjects.com/api/checkout.js"></script>


<title>WatchME!</title>
		<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
        <script src="js/jquery-1.11.2.js"></script>
		<script src="js/jquery.mobile.custom.js" type="text/javascript"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/ui.touch.punch.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
	    <script src="out/simplewebrtc-with-adapter.bundle.js"></script>
 
        
		<style>
.redondear {
     -moz-border-radius: 4px;
     -webkit-border-radius: 4px;
     border-radius: 4px;
}
.redondear2 {
     -moz-border-radius: 10px;
     -webkit-border-radius: 10px;
     border-radius: 10px;
}
			
.sombra{			
	-webkit-box-shadow: 0px 6px 5px -5px rgba(0,0,0,0.31);
	-moz-box-shadow: 0px 6px 5px -5px rgba(0,0,0,0.31);
	box-shadow: 0px 6px 5px -5px rgba(0,0,0,0.31);
}

		</style>   
</head>


<body onLoad="inicio(); transmitir()">
	
	<div id="mas_credito" style="position: absolute"></div>

	<div id="donar" style="position: absolute"></div>
    <div id="tiempo" style="position: absolute"></div>

    <div id="todo" style="position: absolute; width: 100%; height: 100%; background: rgba(212,34,36,1.00); background: url(img/azul.png);">
		

	    
      <div id="fotos" style="position:absolute; top:0%; width:100%; height:100%; background: rgba(255,255,255,1.00); background: url(img/azul.png);">
			
		   		   
			
		<?php					
		$result = mysql_query("SELECT * FROM usuarios WHERE id=$canal");
		$cant = 0;
        while($row=mysql_fetch_array($result)){
			$foto1=$row['foto1'];
		}
		?>
		
			
				<div style="position:absolute; width: 100%; height: 92%; top: 8%; background: #8E8E8E; background-image:url(uploads/<?php echo $foto1?>); background-position:center; background-size: cover">
					
					
				   <div class="videoContainer" style="position:absolute; width:100%; display:none; background: rgba(0,0,0,.8)">
                        <video id="localVideo" style="height: 200px; width:267px; position:absolute; right:20px; bottom:20px; position:absolute; z-index:1000; border:2px solid #FFFFFF" oncontextmenu="return false;"></video>
                        
                        <!--<div id="nocam" style="height: 200px; width:267px; right:22px; position:absolute; margin-top:22px; position:absolute; z-index:1001; display:none">
                        	<img id="disa1" src="img/disabled.png" class="centrar" style="display:none"/>
                            <img id="cam" src="img/cam.png" style="position:absolute; width:25px; bottom:15px; right:15px; display:none"/>
                            <img id="disa2" src="img/disabled.png" style="position:absolute; width:25px; bottom:15px; right:15px;"/>
                        </div>-->
                        
                        <!--<script>
                        	$('#disa2').click(function(){
								$('#disa1, #cam').fadeIn()
								$('#disa2').fadeOut()
								$('#nocam').css('background', 'rgba(0,0,0,1)')
							})
							
							$('#cam').click(function(){
								$('#disa1, #cam').fadeOut()
								$('#disa2').fadeIn()
								$('#nocam').css('background', 'none')
							})
                        </script>-->
                    </div>
                    <div id="remotes" style="width:100px;"></div>
					
					
				  <div id="maa" class="centrar_h textos_exg" style="top:35px; color:#BA205A; opacity: 0"></div>
				  <img id="camara" src="img/camara.png" style="height: 6%; top: 35px; right: 35px; cursor: pointer; position: absolute"/>
					
				  <div id="salir" class="redondear" style="top: 35px; right: 12%; height: 6%; width: 30%; background:rgba(255,255,255,1.00); position: absolute; display: none">
			  	  	<img src="img/derecha.png" class="centrar_v" style="width: 7px; right: -7px"/> 
					  <div class="centrar_v textos_c" style="width: 30%; text-align: center; color:#868689">END CHAT?</div>
					  <div id="no" class="centrar_v redondear textos_c" style="width: 20%; text-align: center; color:#868689; left: 40%; height:80%; background: url(img/fondo_rosa.png); background-size: 100%; 100%; color: #fff; cursor: pointer"><span class="centrar">NO</span></div>
					   <div class="centrar_v" style="width: 1px; left: 65%; height:80%; background: rgba(160,160,160,1.00)"></div>
					   <div id="si" class="centrar_v redondear textos_c" style="width: 20%; text-align: center; color:#868689; left: 70%; height:80%; color: #868689; cursor: pointer"><span class="centrar">YES</span></div>
				  </div>	
					
				  <div style="position: absolute; width: 12%; height: 48%; background:rgba(255,255,255,.9); bottom:20px; left: 20px;">
						<div style="position: absolute; width: 100%; height: 18%; background: url(img/fondo_rosa.png); background-size:100% 100%">
							<div class="centrar_v textos_m" style="text-align: center; width: 100%">DONATE</div>
						</div>
						<div id="mas1" style="position: absolute; width: 80%; left: 10%; height: 15%; top: 18%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="te1" class="centrar_v textos_g" style="text-align:center; color:#BA205A; width: 100%">+1 USD</div>
						</div>
						<div id="mas2" style="position: absolute; width: 80%; left: 10%; height: 15%; top: 33%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="te2" class="centrar_v textos_g" style="text-align:center; color:#BA205A; width: 100%">+3 USD</div>
						</div>
						<div id="mas3" style="position: absolute; width: 80%; left: 10%; height: 15%; top: 48%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="te3" class="centrar_v textos_g" style="text-align:center; color:#BA205A; width: 100%">+5 USD</div>
						</div>
						
						<div id="add_c" style="position: absolute; width: 80%; left: 10%; height: 17%; top: 63%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="monto_total" class="centrar_v textos_m" style="text-align:center; color:#424242; width: 100%; margin-top: -8%">USD $<?php echo $monto?></div>
							<div class="centrar_v textos_c" style="text-align:center; color:#424242; width: 100%; margin-top: 8%">ADD CREDITS</div>
						</div>
						
						<div style="position: absolute; width: 80%; left: 10%; height: 20%; top: 80%; ">
							<img src="img/reloj.png" class="centrar_v" style="height: 40%; left: 5%"/>
							<div class="centrar_v textos_g" style="text-align:right; color:#424243; width: 95%;"><span id="minu">2</span>:<span id="dec">5</span><span id="seg">9</span></div>
						</div>
					</div>
				</div>

		
				
			
	  		<div class="menu sombra" style="position: absolute; width: 100%; height: 8%; background: rgba(255,255,255,1.00)" onClick="transmitir()">
		  		<img class="centrar" src="img/logo_menu.png" style="height: 80%;"/> 
		  		<img id="bt_menu" src="img/menu.png" style="height: 70%; top: 15%; left: 30px; position: absolute; cursor: pointer"/>
		  		<img src="img/online.png" style="height: 50%; top: 25%; right: 30px; position: absolute"/> 
		  	</div>
		</div><!--fin fotos-->
    
    

	    
	    <div id="oscurese" style="position: absolute; width: 100%; height: 100%; background: rgba(0,0,34,.8); display: none; z-index: 1000"></div>
		
   	
   		<div id="atras" style="position: absolute; width: 100%; height: 100%; display: none; z-index: 1000"></div>
   		<div id="pagos" style="position: absolute; width: 20%; height: 45%; background:rgba(255,255,255,1.00); z-index: 1001; bottom: 10%; left: 17%; display: none">
    	
    		<div style="position: absolute; width: 100%; height: 18%; background: url(img/fondo_rosa.png); background-size:100% 100%">
				<div class="centrar_v textos_m" style="text-align: center; width: 100%">ADD CREDITS</div>
			</div>
   	
						<div id="add1" style="position: absolute; width: 80%; left: 10%; height: 20%; top: 18%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="te1" class="centrar_v textos_m" style="text-align:left; color:#424242; width: 100%">+10 USD</div>
					    	<img class="centrar_v" src="img/cuadro.png" style="height: 35%; right: 10px;"/> 
					    	<img id="palomita1" class="centrar_v" src="img/palomita.png" style="height: 35%; right: 10px;"/> 
					    </div>
   						<div id="add2" style="position: absolute; width: 80%; left: 10%; height: 20%; top: 38%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="te2" class="centrar_v textos_m" style="text-align:left; color:#424242; width: 100%">+20 USD</div>
							<img class="centrar_v" src="img/cuadro.png" style="height: 35%; right: 10px;"/> 
					    	<img id="palomita2" class="centrar_v" src="img/palomita.png" style="height: 35%; right: 10px; display: none"/> 
						</div>
						<div id="add3" style="position: absolute; width: 80%; left: 10%; height: 20%; top: 58%; border-bottom: 1px solid rgba(166,166,166,1.00); cursor: pointer">
							<div id="te3" class="centrar_v textos_m" style="text-align:left; color:#424242; width: 100%">+50 USD</div>
							<img class="centrar_v" src="img/cuadro.png" style="height: 35%; right: 10px;"/> 
					    	<img id="palomita3" class="centrar_v" src="img/palomita.png" style="height: 35%; right: 10px; display: none"/> 
						</div>
						
						<div style="position: absolute; width: 80%; left: 10%; height: 20%; top: 78%;">
							<div style="height: 100%; width: 100%; right: 0px; position: absolute">
								<div class="centrar_h" id="paypal-button-container" style="top:50%; margin-top: -15px"></div>
							</div>
						</div>
						
						<script>
							var addd=1
							$('#add1').click(function(){
								cuanto = '10'
								$('#palomita1').fadeIn()
								$('#palomita2').fadeOut()
								$('#palomita3').fadeOut()
								addd=1
							})
							$('#add2').click(function(){
								cuanto = '20'
								$('#palomita1').fadeOut()
								$('#palomita2').fadeIn()
								$('#palomita3').fadeOut()
								addd=2
							})
							$('#add3').click(function(){
								cuanto = '50'
								$('#palomita1').fadeOut()
								$('#palomita2').fadeOut()
								$('#palomita3').fadeIn()
								addd=3
							})
						</script>
    	
	    	<img src="img/izquierda.png" style="position: absolute; width: 6%; left: -6%; bottom: 10%"/> 
	    </div>	
</div>
	
	
	<script>
		var creditos = '<?php echo $monto?>'
		
							
							$('#add_c').click(function(){
								$('#pagos').fadeIn()
								$('#atras').fadeIn()
							})
							
							$('#atras').click(function(){
								$('#pagos').fadeOut()
								$('#atras').fadeOut()
							})
							
							var donaciones = 0
		
							$('#mas1').click(function(){
									$('#mas1').css('background', 'url(img/fondo_rosa.png)')
									$('#mas1').css('background-size', '100% 100%')
									$('#te1').css('color', '#ffffff')
									setTimeout("$('#mas1').css('background', 'none'); $('#te1').css('color', '#BA205A')", 800)
									
								if(total >= 1){
									$('#donar').load('phps/donar1.php?id1=<?php echo $id?>&id2=<?php echo $canal?>&monto=1')
									total = Math.round(total -.1 - 1 +.1)
									$('#monto_total').html('USD $'+total)
									donaciones = donaciones + 1
									$('#mas_credito').load('phps/mas_credito.php?id=<?php echo $id?>&monto=-1')
								}else{
									$('#pagos').fadeIn()
									$('#atras').fadeIn()
								}
							})
							
							$('#mas2').click(function(){
									$('#mas2').css('background', 'url(img/fondo_rosa.png)')
									$('#mas2').css('background-size', '100% 100%')
									$('#te2').css('color', '#ffffff')
									setTimeout("$('#mas2').css('background', 'none'); $('#te2').css('color', '#BA205A')", 800)
								if(total >= 3){
									$('#donar').load('phps/donar1.php?id1=<?php echo $id?>&id2=<?php echo $canal?>&monto=3')
									total = Math.round(total -.1 - 3 +.1)
									$('#monto_total').html('USD $'+total)
									donaciones = donaciones + 3
									$('#mas_credito').load('phps/mas_credito.php?id=<?php echo $id?>&monto=-3')
								}else{
									$('#pagos').fadeIn()
									$('#atras').fadeIn()
								}
							})
							
							$('#mas3').click(function(){
									$('#mas3').css('background', 'url(img/fondo_rosa.png)')
									$('#mas3').css('background-size', '100% 100%')
									$('#te3').css('color', '#ffffff')
									setTimeout("$('#mas3').css('background', 'none'); $('#te3').css('color', '#BA205A')", 800)
								if(total >= 5){
									$('#donar').load('phps/donar1.php?id1=<?php echo $id?>&id2=<?php echo $canal?>&monto=5')
									total = Math.round(total -.1 - 5 +.1)
									$('#monto_total').html('USD $'+total)
									donaciones = donaciones + 5
									$('#mas_credito').load('phps/mas_credito.php?id=<?php echo $id?>&monto=-5')
								}else{
									$('#pagos').fadeIn()
									$('#atras').fadeIn()
								}
							})
		
		
		
			$('#camara').click(function(){
				$('#salir').fadeIn()
			})
			
			
			$('#no').click(function(){
				$('#salir').fadeOut()
			})
			
			$('#si').click(function(){
				$('#salir').fadeOut()
				window.location.href = 'b_end.php?id=<?php echo $id?>&canal=<?php echo $canal?>&segundos='+total_segundos+'&total='+donaciones;
			})

			var room = "<?php echo $canal?>";
		
			function transmitir(){
			$('.videoContainer').show()
            var webrtc = new SimpleWebRTC({
                localVideoEl: 'localVideo',
                remoteVideosEl: '',
                autoRequestMedia: true,
                debug: false,
                detectSpeakingEvents: true
            });

            webrtc.on('readyToCall', function () {
                if (room) webrtc.joinRoom(room);
            });

           
            webrtc.on('videoAdded', function (video, peer) {
                var remotes = document.getElementById('remotes');
                if (remotes) {
                    var d = document.createElement('div');
                    d.className = 'videoContainer';
                    d.id = 'container_' + webrtc.getDomId(peer);
                    d.appendChild(video);
                    remotes.appendChild(d);
					
                }
				cronometro()
            });
            webrtc.on('videoRemoved', function (video, peer) {
		
				window.location.href = 'b_end.php?id=<?php echo $id?>&canal=<?php echo $canal?>&segundos='+total_segundos+'&total='+donaciones;
                var remotes = document.getElementById('remotes');
                var el = document.getElementById('container_' + webrtc.getDomId(peer));
                if (remotes && el) {
                    remotes.removeChild(el);
                }
            });
			
			}
		
		
		
								var cron=0
								var seg = 9
								var dec = 5
								var minu = 2
								var total_segundos = 0
								
								function cronometro(){
									seg--
									total_segundos++
									if(seg == 0 && dec ==0 && minu==0){
										window.location.href = 'b_end.php?id=<?php echo $id?>&canal=<?php echo $canal?>&segundos='+total_segundos+'&total='+donaciones;
									}else{
										if(cron==0){
											setTimeout('cronometro()', 1000)
										}
									}

									if(seg == 9 && dec ==2 && minu==0){
										//$('#persona_donate').animate({top:'64%'}, 800)
										//$('#persona_tiempo').animate({top:'82%'}, 800)
										//$('#persona_divide').delay(800).fadeIn(800)
									}

									$('#seg').html(seg)
									$('#seg2').html(seg)
									if(seg==0){
										seg=10
									}else if(seg==9){
										dec--
										if(dec==-1){
											dec=5	
											minu--
											$('#minu').html(minu)
											$('#minu2').html(minu)
										}
										$('#dec').html(dec)
										$('#dec2').html(dec)
									}
								}
		
    
        </script>
	
	
	
	
	
	
	
	    <div id="menu" style="position:absolute; width:20%; height:100%; background:rgba(255,255,255,1.00); left: -20%;">
			<div class="textos_g" style="position: absolute; top: 12%; left: 15%; color:#424243; font-family:ariBold">MENU</div>
			<a href="galeria.php?id=<?php echo $id?>"><div class="textos_m" style="position: absolute; top: 24%; left: 15%; color:#424243;">HOME</div></a>
			<a href="b_profile.php?id=<?php echo $id?>"><div class="textos_m" style="position: absolute; top: 31%; left: 15%; color:#424243;">PROFILE</div></a>
			<a href="c_profile.php?id=<?php echo $id?>"><div class="textos_m" style="position: absolute; top: 38%; left: 15%; color:#424243;">CAST</div></a>
			<a href="b_contact.php?id=<?php echo $id?>"><div class="textos_m" style="position: absolute; top: 45%; left: 15%; color:#424243;">CONTACT US</div>
			<a href="index.php"><div class="textos_m" style="position: absolute; top: 52%; left: 15%; color:#424243;">LOG OUT</div></a>
				<a href="b_favorites.php?id=<?php echo $id?>"><div class="textos_C" style="position: absolute; top: 60%; left: 15%; color:#BBBCBE; padding-left:10%; background:url(img/favoritos.png) no-repeat; background-size: auto 100%">FAVORITES</div></a>
				<a href="b_trending.php?id=<?php echo $id?>"><div class="textos_C" style="position: absolute; top: 67%; left: 15%; color:#BBBCBE; padding-left:10%; background:url(img/trending.png) no-repeat; background-size: auto 100%">TRENDING</div></a>
				<a href="galeria.php?id=<?php echo $id?>"><div class="textos_C" style="position: absolute; top: 74%; left: 15%; color:#BBBCBE; padding-left:10%; background:url(img/live.png) no-repeat; background-size: auto 80%; background-position:0% 10%">LIVE NOW</div></a>
			
			<a href="https://www.instagram.com/watch_me_official/" target="_blank"><div style="position: absolute; width: 33%; height: 9%; bottom: 0px; border-top: 1px solid rgba(209,209,209,1.00); border-right: 1px solid rgba(209,209,209,1.00)">
				<img class="centrar" src="img/inst.png" style="height: 35%;"/>
			</div></a>
			<a href="https://twitter.com/" target="_blank"><div style="position: absolute; width: 33%; height: 9%; bottom: 0px; border-top: 1px solid rgba(209,209,209,1.00); border-right: 1px solid rgba(209,209,209,1.00); left: 33%">
				<img class="centrar" src="img/twiter.png" style="height: 35%;"/>
			</div></a>
			<a href="https://www.facebook.com/WatchMEapp/" target="_blank"><div style="position: absolute; width: 34%; height: 9%; bottom: 0px; border-top: 1px solid rgba(209,209,209,1.00); left: 66%">
				<img class="centrar" src="img/facebook.png" style="height: 35%;"/>
			</div></a>
		</div>
	

</body>


<script>
	
		$('#bt_menu').click(function(){
			$('#oscurese').fadeIn(500)
			$('#todo').animate({left:'20%'},500)
			$('#menu').animate({left:'0%'},500)
		})
		
		$('#oscurese').click(function(){
			$('#oscurese').fadeOut(500)
			$('#todo').animate({left:'0%'},500)
			$('#menu').animate({left:'-20%'},500)
		})
	
		function inicio(){
				var $window = $(window);
				width = $window.width();
				height = $window.height();
				
				$('.textos_exg').css('font-size', height/15+'px')
				$('.textos_ex').css('font-size', height/22+'px')
				$('.textos_g').css('font-size', height/32+'px')
				$('.textos_m').css('font-size', height/45+'px')
				$('.textos_c').css('font-size', height/55+'px')	
				$('.textos_cx').css('font-size', height/70+'px')
	  	}
	
					function checar(){
						$('#tiempo').load('phps/mastiempo.php?id=<?php echo $canal?>')
					}
				 
					setInterval(checar, 3000);
	
	
$( window ).resize(function() {
  inicio()
});
	
	
	
		var  cuanto = '10'
		paypal.Button.render({
            env: 'sandbox', // sandbox | production
			style: {
				label: 'pay',
				size:  'small', // small | medium | large | responsive
				shape: 'rect',   // pill | rect
				color: 'gold'   // gold | blue | silver | black
			},
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AaoXK9I-BzCrjGF_YXD-3VEGCIZBizA7NInPaZCeHW09qpUKoCCy_orVvWRzXiTLVcdlF5cDn6N0ivKM',
                production: 'AXbSjbatKJiDSTuLKh_DucwkrVkU9hMQouwyKerAJC-nZS401sj9xlQaXsciQG3zyQqfAU9vhOXAB5l9'
            },
            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,
            // payment() is called when the button is clicked
            payment: function(data, actions) {
            // Make a client-side call to the REST api to create the payment
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: cuanto, currency: 'USD' }
                        }
                    ]
                },
                experience: {
                    input_fields: {
                        no_shipping: 1
                    }
                }
            });
        },
            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
					agregar()
                });
            }

        }, '#paypal-button-container');
	
	
		var total = '<?php echo $monto?>'
		function agregar(){
			if(addd==1){
				total = total -.1 + 10 +.1
				$('#monto_total').html('USD $'+total)
				$('#mas_credito').load('phps/mas_credito.php?id=<?php echo $id?>&monto=10')
			}else if(addd==2){
				total = total -.1 + 20 +.1
				$('#monto_total').html('USD $'+total)
				$('#mas_credito').load('phps/mas_credito.php?id=<?php echo $id?>&monto=20')
			}else if(addd==3){
				total = total -.1 + 50 +.1
				$('#monto_total').html('USD $'+total)
				$('#mas_credito').load('phps/mas_credito.php?id=<?php echo $id?>&monto=50')
			}
			
			
		}
	
	
	
</script>

</html>