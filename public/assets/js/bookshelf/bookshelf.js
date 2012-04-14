Munkirjat.bookshelf = (function() {
	
	return {
		
		
	};
})();

Munkirjat.bookshelf.add = (function() {
    var options = {};
    
	return {
		initialize: function(initOptions)
		{
			options = initOptions;
			
			Jme.selector.initialize(options);
			Jme.selector.create('#author_selections', 'authors', options.findAction);
			
			Jme.selector.create('#genre_selections', 'genres', options.findGenreAction);
			
			Jme.selector.create('#tag_selections', 'tags', options.findTagAction);
		}
	};
    
})();

$(function() {
    Munkirjat.bookshelf.add.initialize({
    
    	authors: {
    		findAction: authorsFindAction
    	},
    	
    	genres: {
    		findAction: genresFindAction
    	},
    	
    	tags: {
    		findAction: tagsFindAction
    	
    	},
    
        findAction: findAction,
        
        findGenreAction: findGenreAction,
        
        findTagAction: findTagAction,
        
        addTagAction: addTagAction,
        
        clearField: true
    });
    
    $('.rating-div').each(function()
    {
	$(this).raty({
		start: $(this).data('rating'),
		path: '/img/',
		click: rate,
		readOnly: $(this).data('read-only')
	});
    });
    
    $('td.control a#delete').bind('click', function()
    {
    	return confirm('Do you really want to remove this book?');
    });    
});