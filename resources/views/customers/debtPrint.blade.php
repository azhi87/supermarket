<!DOCTYPE html>
<!--
//
// StarWebPRNT Sample(Canvas Handwriting)
//
// Version 1.2.1
//
// Copyright (C) 2012-2016 STAR MICRONICS CO., LTD. All Rights Reserved.
//
-->
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="Expires" content="86400">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>پسوڵەی قەرز وەرگرتن</title>

<link href="{{asset('public/print/import.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('public/print/style.css')}}" media="screen">

<link href="{{asset('public/print/style_apireceipt.css')}}" rel="stylesheet" type="text/css">
<style>    
input[type=button] {
    width: 53%;
    height: 40px;
    color:white;
    font-size: 20px;
    background-color: #546b50;
    font-weight: 500;
}
    color: white;</style>
<script type='text/javascript' src="{{asset('public/print/StarWebPrintBuilder.js')}}"></script>
<script type='text/javascript' src="{{asset('public/print/StarWebPrintTrader.js')}}"></script>
<script type='text/javascript'>
<!--
var cursor         = 0;
var lineSpace      = 0;
var leftPosition   = 0;
var centerPosition = 0;
var rightPosition  = 0;

function DrawLeftText(text) {
    var canvas = document.getElementById('canvasPaper');

    if (canvas.getContext) {
        var context = canvas.getContext('2d');

        context.textAlign = 'left';

        context.fillText(text, leftPosition, cursor);

        context.textAlign = 'start';
    }
}

function DrawCenterText(text) {
    var canvas = document.getElementById('canvasPaper');

    if (canvas.getContext) {
        var context = canvas.getContext('2d');

        context.textAlign = 'center';

        context.fillText(text, centerPosition, cursor);

        context.textAlign = 'start';
    }
}

function DrawRightText(text) {
    var canvas = document.getElementById('canvasPaper');

    if (canvas.getContext) {
        var context = canvas.getContext('2d');

        context.textAlign = 'right';

        context.fillText(text, rightPosition, cursor);

        context.textAlign = 'start';
    }
}

function onDrawReceipt() {
    switch (document.getElementById('paperWidth').value) {

        case 'inch3DotImpact' :
            drawReceipt(32, 32, 600, 1.5);
            break;
        default :
            drawReceipt(32, 32, 600, 1.5);
            break;
        
            break;
    }
}

function drawReceipt(fontSize, lineSpace, receiptWidth, logoScale) {
    var canvas = document.getElementById('canvasPaper');

    if (canvas.getContext) {
        var context = canvas.getContext('2d');

        context.clearRect(0, 0, canvas.width, canvas.height);

//      context.textAlign    = 'start';
        context.textBaseline = 'top';

        var font = 'bold ';
        font += (fontSize+10) + 'px ';
        font += ' Cambria ';

        context.font = font;

        leftPosition   =  10;
//      centerPosition =  canvas.width       / 2;
        centerPosition = (canvas.width - 16) / 2;
     //  rightPosition  =  canvas.width;
        rightPosition  = (canvas.width - 16);

   	//	cursor = 0;
        cursor = 100 * logoScale; 
       
        DrawCenterText('کۆمپانیایی فۆرئێڤەر کلین'); cursor += lineSpace*2;
        var font = '';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
        context.font = font;
      
        DrawCenterText(' 0750 122 7194   *   0770 137 6102'); cursor += lineSpace;
        
         var font = 'bold ';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
         context.font = font;
        DrawCenterText('پسوڵەی پارە وەرگرتن');  cursor += lineSpace;
        
        DrawCenterText('___________________________________________'); cursor += 1.5*lineSpace;
        
        
        DrawCenterText('بەڕێز :'+'{{$debt->customer->name}}-{{$debt->customer->id}}'); cursor += 2*lineSpace;
        
        var font = '';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
          context.font = font;

        DrawLeftText('بەروار'+':' + '{{$debt->created_at->format('h:i d/m/Y')}}');       DrawRightText('ژ.وەصل ' + ':'+ {{$debt->id}}+'    '); cursor += 1.5*lineSpace;
       
        DrawLeftText('{{$debt->dinars}}');                                               DrawRightText(':(IQD)'+'بڕی پارەی دراو بە دینار'); cursor += 1.5*lineSpace;
        
        DrawLeftText('{{number_format($debt->dollars,2)}}');                             DrawRightText(':($)'+'بڕی پارەی دراو بە دۆلار'); cursor += 1.5*lineSpace;
        var font = 'bold ';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
         context.font = font;

       DrawRightText(':($)'+'سەرجەمی پارەی دراو  ');                                          DrawLeftText('{{number_format($debt->calculatedPaid,2)}}');       cursor += 1.5*lineSpace;
        
         var font = '';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
          context.font = font;

        DrawLeftText('{{$debt->rate}}');     						                   	DrawRightText(':'+'شکانەوەی دۆلار   '); cursor += 1.5*lineSpace;
        var font = 'bold ';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
          context.font = font;

        DrawLeftText('{{number_format(($debt->customer->customerDebt() - $debt->calculatedPaid),2)}}');    DrawRightText(':($) باقیات   ');  cursor += 1.5*lineSpace;
        
        var font = '';
        font += (fontSize-3) + 'px ';
        font += ' Cambria ';
          context.font = font;

  DrawRightText('ناوی وەرگر: {{$debt->user->name}}-{{$debt->user_sequence}}  ');  cursor += 5*lineSpace;
        DrawLeftText('ئیمزای پێدەر');      DrawRightText('ئیمزای وەرگر');  cursor += lineSpace;

        

//      alert('Cursor:' + cursor + ', ' + 'Canvas:' + canvas.height);

        var image = new Image();

        image.src = "{{asset('/storage/app/public/logoPrint.jpg')}}" + '?' + new Date().getTime();
        //https://forever-clean.net/storage/app/public/logoPrint.jpg' + '?' + new Date().getTime();

        image.onload = function () {
            
            context.drawImage(image, canvas.width - image.width * logoScale*1.75, 0, image.width * logoScale, image.height * logoScale);
            context.strokeStyle = '#000000';  // some color/style
            context.lineWidth = 2;         // thickness
            context.strokeRect(0, 0, context.canvas.width-2, context.canvas.height-2);
        }

        image.onerror = function () {
            alert('Image file was not able to be loaded.');
        }
    }
}

function onResizeCanvas() {
    var canvas = document.getElementById('canvasPaper');

    if (canvas.getContext) {
        var context = canvas.getContext('2d');

        switch (document.getElementById('paperWidth').value) {
            case 'inch2' :
            case 'inch3DotImpact' :
                canvas.width = 576;
                canvas.height = 870;
                break;
            default :
                canvas.width = 576;
                canvas.height = 890;
                break;

                break;
        }
        document.getElementById('canvasPaper').style.width="700px";
        onDrawReceipt();
    }
}

function refocusFontSelectbox() {
    var fontSelectbox = document.getElementById('font');
    fontSelectbox.blur();
    fontSelectbox.focus();
}

function refocusWidthSelectbox() {
    var paperWidthSelectbox = document.getElementById('paperWidth');
    paperWidthSelectbox.blur();
    paperWidthSelectbox.focus();
}

function onSendMessage() {
	showNowPrinting();

    var url              = document.getElementById('url').value;
    var papertype        = document.getElementById('papertype').value;

    var trader = new StarWebPrintTrader({url:url, papertype:papertype});

    trader.onReceive = function (response) {
        hideNowPrinting();

        var msg = '- onReceive -\n\n';

        msg += 'TraderSuccess : [ ' + response.traderSuccess + ' ]\n';

//      msg += 'TraderCode : [ ' + response.traderCode + ' ]\n';

        msg += 'TraderStatus : [ ' + response.traderStatus + ',\n';

        if (trader.isCoverOpen            ({traderStatus:response.traderStatus})) {msg += '\tکەڤەرەکەی کراوەتەوە,\n';}
        if (trader.isOffLine              ({traderStatus:response.traderStatus})) {msg += '\tکۆنێکت نیت بە پرینتەرەکەوە,\n';}
        if (trader.isCompulsionSwitchClose({traderStatus:response.traderStatus})) {msg += '\tCompulsionSwitchClose,\n';}
        if (trader.isEtbCommandExecute    ({traderStatus:response.traderStatus})) {msg += '\tEtbCommandExecute,\n';}
        if (trader.isHighTemperatureStop  ({traderStatus:response.traderStatus})) {msg += '\tپلەی گەرمای پرینتەرەکە بەرزە,\n';}
        if (trader.isNonRecoverableError  ({traderStatus:response.traderStatus})) {msg += '\tNonRecoverableError,\n';}
        if (trader.isAutoCutterError      ({traderStatus:response.traderStatus})) {msg += '\tAutoCutterError,\n';}
        if (trader.isBlackMarkError       ({traderStatus:response.traderStatus})) {msg += '\tBlackMarkError,\n';}
        if (trader.isPaperEnd             ({traderStatus:response.traderStatus})) {msg += '\tPaperEnd,\n';}
        if (trader.isPaperNearEnd         ({traderStatus:response.traderStatus})) {msg += '\tPaperNearEnd,\n';}

        msg += '\tEtbCounter = ' + trader.extractionEtbCounter({traderStatus:response.traderStatus}).toString() + ' ]\n';

//      msg += 'Status : [ ' + response.status + ' ]\n';
//
//      msg += 'ResponseText : [ ' + response.responseText + ' ]\n';

        alert(msg);
    }

    trader.onError = function (response) {
        hideNowPrinting();

        var msg = '- onError -\n\n';

        msg += '\tStatus:' + response.status + '\n';

        msg += '\tResponseText:' + response.responseText;

        alert(msg);
    }

    try {
        var canvas = document.getElementById('canvasPaper');

        if (canvas.getContext) {
            var context = canvas.getContext('2d');

            var builder = new StarWebPrintBuilder();

            var request = '';

            request += builder.createInitializationElement();

            request += builder.createBitImageElement({context:context, x:0, y:0, width:canvas.width, height:canvas.height});

            request += builder.createCutPaperElement({feed:true});

            trader.sendMessage({request:request});
        }
    }
    catch (e) {
        hideNowPrinting();

        alert(e.message);
    }
}
function nowLoading(){
	document.getElementById('form').style.display="block";
	document.getElementById('overlay').style.display="none";
	document.getElementById('nowLoadingWrapper').style.display="none";
}
function showNowPrinting(){
    document.getElementById('overlay').style.display="block";
    document.getElementById('nowPrintingWrapper').style.display="table";
}
function hideNowPrinting(){
    document.getElementById('overlay').style.opacity= 0.0;
    document.getElementById('overlay').style.transition= "all 0.3s";
    intimer = setTimeout(function (){
        document.getElementById('overlay').style.display="none";
    document.getElementById('overlay').style.opacity= 1;
        clearTimeout(intimer);
    }, 300);
    document.getElementById('nowPrintingWrapper').style.display="none";
}
window.onload = function() {
	nowLoading();
	onResizeCanvas();
}
// -->
</script>
<noscript>
    Your browser does not support JavaScript!
</noscript>
</head>

<body>

	<div id="overlay">
		<div id="nowPrintingWrapper">
			<section id="nowPrinting">
				<h1>Now Printing</h1>
				<p><img src="images/icon_loading.gif" /></p>
			</section>
		</div>
		<div id="nowLoadingWrapper">
			<section id="nowLoading">
				<h1>Now Loading</h1>
				<p><img src="images/icon_loading.gif" /></p>
			</section>
		</div>
	</div>

<!--<header id="global-header">-->
<!--<h1><a href="A001.html"><img src="images/logo_01.png" alt="HOME" width="108" height="61"></a></h1>-->
<!--<div id="sub-logo"><a href="http://www.star-m.jp/" target="_blank"><img src="images/logo_02.png" alt="" width="120" height="13"></a></div>-->
<!--</header>-->

<section class="btmMg20">
	<h2 class="h2-tit-01 btmMg20">پرینتکردنی پسوڵەی قەرز وەرگرتن</h2>
</section>

    <form onsubmit='return false;' id="form">
		<div class="container">
			<div class="wrapper">
				<div id="canvasBlock">
					<div id='canvasFrame'>
						<canvas id='canvasPaper' width='576' height='640' style="border:1px solid black;">
							Your browser does not support Canvas!
						</canvas>
                     </div>
				</div>
			</div>
			<div id="optionBlock" style="display:none;">
				<dl>
					<dt>Font</dt>
					<dd>:
						<select id='font' onchange='onDrawReceipt(); refocusFontSelectbox();'>
                            <option selected='selected'>Arial</option>
                            <option>Cambria</option>
                        </select>
                        &nbsp;<input id='italic' type='checkbox' onclick='onDrawReceipt()' />Italic
					</dd>
				</dl>
				<dl>
					<dt>Paper Width</dt>
					<dd>:
						<select id='paperWidth' onchange='onResizeCanvas(); refocusWidthSelectbox();'>
							<option value='inch2' >2 Inch</option>
							<option value='inch3' selected='selected'>3 Inch</option>
							<option value='inch4'>4 Inch</option>
						</select>
					</dd>
				</dl>
			</div>
			<hr>
			<footer  style="display: none;">
				<dl style="display: none;">
				
                    <input id="url" type="hidden" value="http://localhost:8001/StarWebPRNT/SendMessage" /></dd>
				</dl>
                <d1>
                    
                    <dd>:
                        <select id='papertype' style="dislplay:none;">
                            <option value='' selected='selected'>-</option>
                            <option value='normal'>Normal</option>
                            <option value='black_mark'>Black Mark</option>
                            <option value='black_mark_and_detect_at_power_on'>Black Mark and Detect at Power On</option>
                        </select>
                    </dd>
                </dl>
				<input id="sendBtn" type="button" value="پرینت کردن" onclick="onSendMessage()" />
			</footer>
			<input id="sendBtn" type="button" value="Send" onclick="onSendMessage()" />
		</div>
	</form>


</body>
</html>
