var Munkirjat = (function() {
    return {
    	
    };
    
})();

Munkirjat.form = (function()
{
	var options = {
		message_class: 'message',
		okClass: 'status_ok',
		errorClass: 'status_error',
		infoClass: 'status_info'
	};
	
	return {
		initialize: function(initOptions)
		{
			options = initOptions;
		},
		addMessage: function(message, type, element)
		{
			$(element).parent().find('.' + options.message_class).remove();
			
			cssClass = getStatusClass(type);
			
			inner = $('<p/>').html('<p class="' + cssClass + ' ' + options.message_class + '">' + message + '</p>');
			
			$(element).after(inner);
			
			$('.' + cssClass).fadeIn("3000");
			
			function getStatusClass(type)
			{
				switch(type)
				{
					case 'error':
					{
						return options.errorClass;
					}
					case 'ok': 
					{
						return options.okClass;
					}
					case 'info':	
					default:
					{
						return options.infoClass; 
					}
				}
			}
		},
		removeMessage: function(element)
		{
			$(element).parent().find('.' + options.message_class).remove();
		}
		
	};

})();