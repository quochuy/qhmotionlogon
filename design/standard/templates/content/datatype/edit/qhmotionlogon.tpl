{ezscript_require(array('ezjsc::jquery'))}

<div id="mlogon">
        <div id="mc">
            <canvas id="mc-canvas"></canvas>
        </div>
    </div>
{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#mlogon').motionCaptcha();
            
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

<input type="text" size="10"
      name="ContentObjectAttribute_data_text_{$attribute.id}"
      id="unistrokeedit"
      value="{$attribute.data_text}" />