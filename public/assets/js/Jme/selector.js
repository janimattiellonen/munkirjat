var Jme = (function() {
    return {
    	
    };
})();

Jme.selector = (function()
{
	var options = {};
	
	var acElement = null;
	
	return {
		initialize: function(initOptions)
		{
			options = initOptions;
			
			var opt = {
				customActionClass: "customAction",
				customActionFunction: function() {
			    	  
			    	  index = $(this).closest('li').index();
			    	  
			    	  id = $(acElement + ' option:eq(' + index + ')').val();
			    	  
			    	  return false;
			      }
			};
			
			$.extend($.bsmSelect.conf, opt);
		},
		create: function(selectorElement, autocompleteElementId, action)
		{
			autocompleteElement = '#' + autocompleteElementId;
			
			acElement = autocompleteElement;
			
			$(selectorElement).bsmSelect({
				
				addItemTarget: 'bottom',
				animate: true,
				highlight: true,
				plugins: 
				[
					$.bsmSelect.plugins.sortable({ axis : 'y', opacity : 0.5 }, { listSortableClass : 'bsmListSortableCustom' }),
					$.bsmSelect.plugins.compatibility()
				]
			});		
			
			$('.bsmSelect').css('display', 'none');
			
            $(autocompleteElement).autocomplete(
            {
                'source': options[autocompleteElementId].findAction,
                'select': function (event, ui)
                {
            		addItem(ui.item, selectorElement);
            		if(options.clearField == true)
            		{
	            		$('#' + autocompleteElementId).val('');
	            		return false;
            		}
                }
            });			
            
            function addItem(item, element)
            {
            	if(!itemExists(element, item.id) )
            	{	
            		opt = $('<option value="' + item.id+ '" selected="selected">' + item.label + '</option>');
            		$(element).append(opt).change();
            	}
            }
            
            function itemExists(element, value)
            {
            	return $('option[value="' + value + '"]:selected', element).length != 0;
            }	
		}
		
	};
})();