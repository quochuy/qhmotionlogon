{ezscript_require(array('ezjsc::jquery'))}

<div id="mlogon">
    <div id="mc">
        <canvas id="mc-canvas"></canvas>
    </div>
</div>
    
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('#mlogon').motionCanvas();
        
        var canvas = $('#mc-canvas')[0];
        var context = canvas.getContext('2d');
        
        var mlogonInput = $('#unistrokeedit').val();
        var mlogonInputArray = mlogonInput.split('&');
        var mlogonImageData = mlogonInputArray[1];
        
        var imageObj = new Image();
	    imageObj.onload = function(){
	        context.drawImage(this, 0, 0);
	    };
	 
	    imageObj.src = mlogonImageData;
    });
</script>
{/literal}

<form action={'mlogon/testprocess'|ezurl()} method="post">
<input type="text" size="10"
      name="UniStroke"
      id="unistroke"
      value="{$attribute.data_text}" />
<input class="button" type="submit" name="LoginButton" value="Log in" tabindex="1" title="Click here to log in using the username/password combination entered in the fields above." />

</form>
