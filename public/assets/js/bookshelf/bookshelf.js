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