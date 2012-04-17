/*!
 * jQuery MotionCAPTCHA v0.2
 * 
 * Proof of concept only for now, check the roadmap to see when it will be ready for wider use!
 * 
 * http://josscrowcroft.com/projects/motioncaptcha-jquery-plugin/
 * 
 * DEMO: http://josscrowcroft.com/demos/motioncaptcha/
 * CODE: https://github.com/josscrowcroft/MotionCAPTCHA
 * 
 * Copyright (c) 2011 Joss Crowcroft - joss[at]josscrowcroftcom | http://www.josscrowcroft.com
 * 
 * Incoporates other open source projects, attributed below.
 */
jQuery.fn.motionCaptcha || (function($) {
	
	/**
	 * Main plugin function definition
	 */
	$.fn.motionCaptcha = function(options) {
		
		/**
		 * Act on matched form element:
		 * This could be set up to iterate over multiple elements, but tbh would it ever be useful?
		 */
		return this.each(function() {
				
			// Build main options before element iteration:
			var opts = $.extend({}, $.fn.motionCaptcha.defaults, options);
			
			// Ensure option ID params are valid #selectors:
			opts.actionId = '#' + opts.actionId.replace(/\#/g, '');
			opts.canvasId = '#' + opts.canvasId.replace(/\#/g, '');
			opts.divId = '#' + opts.divId.replace(/\#/g, '');
			opts.submitId = ( opts.submitId ) ? '#' + opts.submitId.replace(/\#/g, '') : false;

			// Plugin setup:

			// Set up Harmony vars:
			var brush,
				locked = false;
				
			// Set up MotionCAPTCHA form and jQuery elements:
			var	$form = $(this),
				$canvas = $(opts.canvasId);
			
			// Set up MotionCAPTCHA canvas vars:
			var canvasWidth = $canvas.width(),
				canvasHeight = $canvas.height(),
				borderLeftWidth = 1 * $canvas.css('borderLeftWidth').replace('px', ''),
				borderTopWidth = 1 * $canvas.css('borderTopWidth').replace('px', '');			

			// Canvas setup:
			
			// Set the canvas DOM element's dimensions to match the display width/height (pretty important):
			$canvas[0].width = canvasWidth;
			$canvas[0].height = canvasHeight;
			
			// Get DOM reference to canvas context:
			var ctx = $canvas[0].getContext("2d");
			
			// Add canvasWidth and canvasHeight values to context, for Ribbon brush:
			ctx.canvasWidth = canvasWidth;
			ctx.canvasHeight = canvasHeight;
			
			// Set canvas context font and fillStyle:
			ctx.font = opts.canvasFont;
			ctx.fillStyle = opts.canvasTextColor;
			
			// Set up Dollar Recognizer and drawing vars:
			var _isDown = false,
				_holdStill = false,
				_points = [];

			// Create the Harmony Ribbon brush:
			brush = new Ribbon(ctx, opts.brushColor);

			// Mousedown event
			// Start Harmony brushstroke and begin recording DR points:
			var touchStartEvent = function(event) {
				if ( locked )
					return false;
				
				// Prevent default action:
				event.preventDefault();
				
				// Get mouse position inside the canvas:
				var pos = getPos(event),
					x = pos[0],
					y = pos[1];
				
				// Internal drawing var	
				_isDown = true;
				
				// Prevent jumpy-touch bug on android, no effect on other platforms:
				_holdStill = true;
				
				// Disable text selection:
				$('body').addClass('mc-noselect');
				
				// Clear canvas:
				ctx.clearRect(0, 0, canvasWidth, canvasHeight);
				
				// Start brushstroke:
				brush.strokeStart(x, y);
				
				// Add the first point to the points array:
				_points = [NewPoint(x, y)];

				return false;
			}; // mousedown/touchstart event

			// Mousemove event:
			var touchMoveEvent = function(event) {
				if ( _holdStill ) {
					return _holdStill = 0;
				}
				// If mouse is down and canvas not locked:
				if ( !locked && _isDown ) {
									
					// Prevent default action:
					event.preventDefault();

					// Get mouse position inside the canvas:
					var pos = getPos(event),
						x = pos[0],
						y = pos[1];
					
					// Append point to points array:
					_points[_points.length] = NewPoint(x, y);
					
					// Do brushstroke:
					brush.stroke(x, y);
				}
				return false;
			}; // mousemove/touchmove event
			
			
			// Mouseup event:
			var touchEndEvent = function(event) {
				// If mouse is down and canvas not locked:
				if ( !locked && _isDown ) {
					_isDown = false;
					
					// Allow text-selection again:
					$('body').removeClass('mc-noselect');
					
					// Dollar Recognizer result:
					if (_points.length >= 15) {
                                            
//                                                var resultSelector = $('.php-results ul');
//                                                resultSelector.html('');
                        
                        var r = '';
                        
                        for(var i=0; i<_points.length; i++) {
                        	r += _points[i].X + ',' + _points[i].Y + '/';
                        }			
                        
                        if($('#unistrokeedit').length>0) {
                        	$('#unistrokeedit').val(r + '&' + $canvas[0].toDataURL());
                        } else {
                        	$('#unistroke').val(r);
                        }
                        
                        /*$.post("index.php", {'points' : _points},
                         function(data){
                           $.each(data, function(index, value) { 
                                resultSelector.append('<li><b>'+value['strokeName']+'</b>: '+value['strokeScore']+'</li>');
                            });
                         }, "json");
						// Check result:
						if ( result.Score > 3.1 ) {
							
							
							// Call the onSuccess function to handle the rest of the business:
							// Pass in the form, the canvas, the canvas context:
							opts.onSuccess($form, $canvas, ctx);
							
						}
						*/
					} else { // fewer than 10 points were recorded:

						
						// Write error message into canvas:
						ctx.fillText(opts.errorMsg, 10, 24);

						// Pass off to the error callback to finish up:
						opts.onError($form, $canvas, ctx);
					}
					
					// Clear canvas:
					if(typeof opts.clearAfter != 'undefined')
						window.setTimeout( function() {
												ctx.clearRect(0, 0, canvasWidth, canvasHeight);
										   }, 1000); 
				}
				return false;
			}; // mouseup/touchend event

			// Bind events to canvas:
			$canvas.bind({
				mousedown:  touchStartEvent,
				mousemove: touchMoveEvent,
				mouseup:  touchEndEvent
			});

			// Mobile touch events:
			$canvas[0].addEventListener('touchstart', touchStartEvent, false);
			$canvas[0].addEventListener('touchmove', touchMoveEvent, false);
			$canvas[0].addEventListener('touchend', touchEndEvent, false);



		
			/**
			 * Get X/Y mouse position, relative to (/inside) the canvas
			 * 
			 * Handles cross-browser quirks rather nicely, I feel.
			 * 
			 * @todo For 1.0, if no way to obtain coordinates, don't activate MotionCAPTCHA.
			 */
			function getPos(event) {
				var x, y;
				
				// Check for mobile first to avoid android jumpy-touch bug (iOS / Android):
				if ( event.touches && event.touches.length > 0 ) {
					// iOS/android uses event.touches, relative to entire page:
					x = event.touches[0].pageX - $canvas.offset().left + borderLeftWidth;
					y = event.touches[0].pageY - $canvas.offset().top + borderTopWidth;
				} else if ( event.offsetX ) {
					// Chrome/Safari give the event offset relative to the target event:
					x = event.offsetX - borderLeftWidth;
					y = event.offsetY - borderTopWidth;
				} else {
					// Otherwise, subtract page click from canvas offset (Firefox uses this):
					x = event.pageX - $canvas.offset().left - borderLeftWidth;
					y = event.pageY - $canvas.offset().top - borderTopWidth;
				}
				return [x,y];
			}

		}); // this.each

	} // end main plugin function
	
	
	/**
	 * Exposed default plugin settings, which can be overridden in plugin call.
	 */
	$.fn.motionCaptcha.defaults = {
		actionId: '#mc-action',     // The ID of the input containing the form action
		divId: '#mc',               // If you use an ID other than '#mc' for the placeholder, pass it in here
		canvasId: '#mc-canvas',     // The ID of the MotionCAPTCHA canvas element
		submitId: false,            // If your form has multiple submit buttons, give the ID of the main one here
		cssClass: '.mc-active',     // This CSS class is applied to the form, when the plugin is active
	
		// An array of shape names that you want MotionCAPTCHA to use:
		shapes: ['triangle', 'x', 'rectangle', 'circle', 'check', 'caret', 'zigzag', 'arrow', 'leftbracket', 'rightbracket', 'v', 'delete', 'star', 'pigtail'],
		
		// Canvas vars:
		canvasFont: '15px "Lucida Grande"',
		canvasTextColor: '#111',
		
		// These messages are displayed inside the canvas after a user finishes drawing:
		errorMsg: 'Too few points recorded.',
		successMsg: 'Captcha passed!',
		
		// This message is displayed if the user's browser doesn't support canvas:
		noCanvasMsg: "Your browser doesn't support <canvas> - try Chrome, FF4, Safari or IE9.",
		
		// This could be any HTML string (eg. '<label>Draw this shit yo:</label>'):
		label: '<p>Please draw the shape in the box to submit the form:</p>',
		
		// Callback function to execute when a user successfully draws the shape
		// Passed in the form, the canvas and the canvas context
		// Scope (this) is active plugin options object (opts)
		// NB: The default onSuccess callback function enables the submit button, and adds the form action attribute:
		onSuccess: function($form, $canvas, ctx) {
			var opts = this,
				$submit = opts.submitId ? $form.find(opts.submitId) : $form.find('input[type=submit]:disabled');
						
			// Set the form action:
			$form.attr( 'action', $(opts.actionId).val() );
			
			// Enable the submit button:
			$submit.prop('disabled', false);

			
			return;
		},
		
		// Callback function to execute when a user successfully draws the shape
		// Passed in the form, the canvas and the canvas context
		// Scope (this) is active plugin options object (opts)
		onError: function($form, $canvas, ctx) {
			var opts = this;
			return;
		}
	};
	
	/*!
	 * Harmony | mrdoob | Ribbon Brush class
	 * http://mrdoob.com/projects/harmony/
	 */
	
	function Ribbon( ctx, color ) {
		if(typeof color == 'undefined')
			color = [0, 0, 0];
		this.init( ctx, color );
	}
	
	Ribbon.prototype = {
		ctx: null,
		X: null, 
		Y: null,
		painters: null,
		interval: null,
		init: function( ctx, color ) {
			var scope = this,
				userAgent = navigator.userAgent.toLowerCase(),
				brushSize = ( userAgent.search("android") > -1 || userAgent.search("iphone") > -1 ) ? 2 : 1,
				strokeColor = color;
			
			this.ctx = ctx;
			this.ctx.globalCompositeOperation = 'source-over';
			
			this.X = this.ctx.canvasWidth / 2;
			this.Y = this.ctx.canvasHeight / 2;
	
			this.painters = [];
			
			// Draw each of the lines:
			for ( var i = 0; i < 38; i++ ) {
				this.painters.push({
					dx: this.ctx.canvasWidth / 2, 
					dy: this.ctx.canvasHeight / 2, 
					ax: 0, 
					ay: 0, 
					div: 0.1, 
					ease: Math.random() * 0.18 + 0.60
				});
			}
			
			// Set the ticker:
			this.interval = setInterval( update, 1000/60 );
			
			function update() {
				var i;
				
				scope.ctx.lineWidth = brushSize;			
				scope.ctx.strokeStyle = "rgba(" + strokeColor[0] + ", " + strokeColor[1] + ", " + strokeColor[2] + ", " + 0.06 + ")";
				
				for ( i = 0; i < scope.painters.length; i++ ) {
					scope.ctx.beginPath();
					scope.ctx.moveTo(scope.painters[i].dx, scope.painters[i].dy);
					
					scope.painters[i].dx -= scope.painters[i].ax = (scope.painters[i].ax + (scope.painters[i].dx - scope.X) * scope.painters[i].div) * scope.painters[i].ease;
					scope.painters[i].dy -= scope.painters[i].ay = (scope.painters[i].ay + (scope.painters[i].dy - scope.Y) * scope.painters[i].div) * scope.painters[i].ease;
					scope.ctx.lineTo(scope.painters[i].dx, scope.painters[i].dy);
					scope.ctx.stroke();
				}
			}
		},
		destroy: function() {
			clearInterval(this.interval);
		},
		strokeStart: function( X, Y ) {
			this.X = X;
			this.Y = Y
	
			for (var i = 0; i < this.painters.length; i++) {
				this.painters[i].dx = X;
				this.painters[i].dy = Y;
			}
	
			this.shouldDraw = true;
		},
		stroke: function( X, Y ) {
			this.X = X;
			this.Y = Y;
		}
	};

//
// Point class
//
function Point(x, y)
{
	this.X = x;
	this.Y = y;
}

// Wrapper for Point class (saves mega kb when compressing the template definitions):
function NewPoint(x, y) {
	return new Point(x, y)
}


})(jQuery);
