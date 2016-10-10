<?php
require_once('config.php');
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours);
?>
<html>
    <title></title>
    <head>
<style type="text/css">
    .panel{ padding: 10px}
.chat_wrapper {
	width: 100%;
	margin-right: auto;
	margin-left: auto;
	background: #CCCCCC;
	border: 1px solid #999999;
	padding: 10px;
	font: 12px 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.chat_wrapper .message_box {
	background: #FFFFFF;
	height: 300px;
	overflow: auto;
	padding: 10px;
	border: 1px solid #999999;
}
.chat_wrapper .panel input{
	padding: 2px 2px 2px 5px;
}
.system_msg{color: #BDBDBD;font-style: italic;}
.user_name{font-weight:bold;}
.user_message{color: #88B6E0;}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script language="javascript" type="text/javascript">  
$(document).ready(function(){
	//create a new WebSocket object.
	var wsUri = "ws://localhost:9000/"; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { // connection is open 
		$('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
	}

	$('#send-btn').click(function(){ //use clicks message send button	
		var mymessage = $('#message').val(); //get message text
		$('#message').val(''); 
var myname = $('#name').val(); //get user name
		var fnamee = $('#fname').val(); //get user name
                var frndid = $('#fid').val(); //get user name
		if(fnamee == ""){ //empty name?
			alert("Please select Friend!");
			return;
		}
		if(mymessage == ""){ //emtpy message?
			alert("Enter Some message Please!");
			return;
		}
		
		//prepare json data
		var msg = {
		message: mymessage,
		name: myname,
                fname: fnamee,
                fid: frndid,
                time: '<?php echo date("d-M-y h:i"); ?>',
		color : '<?php echo $colours[$user_colour]; ?>'
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));
	});
	
	//#### Message received from server?
	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var umsg = msg.message; //message text
		var uname = msg.name; //user name
                var fname = msg.fname; //user name
                var fid = msg.fid; //user name
		var ucolor = msg.color; //color
                var d = new Date();
                var n = d.toLocaleString(); 
		if(type == 'usermsg') 
		{       if(fname == '<?php echo $_SESSION["username"]; ?>' || uname == '<?php echo $_SESSION["username"]; ?>') {
                        if(uname != '<?php echo $_SESSION["username"]; ?>'){
                            if($("#" + fid).length == 0) {
                            $('#message_box').append("<div id='"+fid+"' class=''><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg +"</span><br/>"+n+"<br/></div>");
                            } else {
                                $("#" + fid).append("<span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg +"</span><br/>"+n+"<br/>");
                            }
                        } else {
                            
                            $(".active_chat").append("<span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg + "</span><br/>"+n+"<br/>");
                        }
                        
                        $('#chatAudio')[0].play();
                        $("#message_box").animate({"scrollTop": $('#message_box')[0].scrollHeight}, "fast");
                        }
		}
		if(type == 'system')
		{ 
			//$('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
		}
		
		$('#message').val(''); //reset text
	};
	
	websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; 
	websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");}; 
});
</script>
</head>
<body>
    
<!-- banner-bottom -->
<div>
        <!-- container -->
<div style="float:left; width: 20%; text-align: right; background-color: blanchedalmond; text-align: center">
    <h4>Friend List :</h4>
    <ul style="padding-top: 10px; padding-left: 0px">
        <?php 
        
            $sql="SELECT * FROM user where fid={$_SESSION['id']} ";
            $result=$conn->query($sql);
            while($row = $result->fetch_assoc()) {
        ?>
        <li style="padding-top: 5px" rel="<?php echo $row["id"]?>" class="frnd">
            
                <?php echo $row["username"]; ?>
        </li>
       <?php } ?>
    </ul>
        </div>
        <div class="chat_wrapper" style="float:right; width: 70%">
           <div class="message_box" id="message_box"></div>
           <div class="panel">
               <input type="hidden" name="name" id="name" placeholder="Your Name" maxlength="10" style="width:20%"  value="<?php echo $_SESSION["username"]; ?>"/>
               <input type="hidden" name="fname" id="fname" placeholder="f Name" maxlength="10" style="width:20%"  value=""/>
               <input type="hidden" name="fid" id="fid" placeholder="f id" maxlength="10" style="width:20%"  value=""/>
               <textarea name="message" id="message" placeholder="Message" cols="65"></textarea>
           <button id="send-btn" class="btn btn-success">Send</button>
           </div>
        </div>
        
               
        <!-- //container -->
</div>
<script type="text/javascript">
           $(document).ready(function() {
                $(document).on("click", ".frnd", function(e){
                    var fid=$(this).attr('rel');
                    $.post("ajax/chat.php",{
                            Fid: fid
                    },function(data){
                        var parsedData = JSON.parse(data);
                            $('#fname').val(parsedData.user_name);
                            $('#fid').val('<?php echo $_SESSION["id"]; ?>');
                            
                            if($("#" + parsedData.user_id).length == 0) {
                            $(".active_chat").css('display','none');
                            $('.active_chat').removeClass( "active_chat" );    
                            $('#message_box').append("<div id='"+parsedData.user_id+"' class='active_chat'></div>");}
                            else {
                                $(".active_chat").css('display','none');
                                $('.active_chat').removeClass( "active_chat" );
                                $("#" + parsedData.user_id).addClass( "active_chat" );    
                                $("#" + parsedData.user_id).css('display','block');
                            }
                    });
                });
        });
</script>
</body></html>
