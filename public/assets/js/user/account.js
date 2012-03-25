Munkirjat.account = (function() {
    var options = {};
    var previousState = null;
    var previousValue = null;
    
    return {
        initialize: function(initOptions) {
            options = initOptions;
            
        	$('#username').bind('blur', function()
			{
        		checkAvailability('username', $(this), options.usernameAvailableAction);
			});	      
        	
        	$('#email').bind('blur', function()
			{
        		checkAvailability('email', $(this), options.emailAvailableAction);
			});	          	
        	
        	function checkAvailability(fieldName, element, url)
        	{
        		idStr = null;
        		value = $(element).attr('value');
        		
        		if(value.length == 0)
        		{
            		previousValue = null;
        			Munkirjat.form.removeMessage(element);
        			previousState = null;
        			return;
        		}
        		
        		
				if($('#id').length)
				{
					idStr ='&id=' + $('#id').attr('value');
				}
				
				$.ajax({
					url: url,
					type: 'GET',
					data: fieldName + '=' + value + idStr,
					success: function(data)
					{
						$('#csrf').attr('value', data.hash);
						
						if(data.available != previousState || previousValue != value)
						{
							Munkirjat.form.addMessage(data.message, data.available ? "ok" : "error", $(element) );
							previousState = data.available;
							previousValue = value;
						}
					}
				
				});
        	}
        }
    };
})();

Munkirjat.account.usernameAvailable = (function() {
    var options = {};
    
    return {
        initialize: function(initOptions) {
            options = initOptions;
            
        }
    };
})();