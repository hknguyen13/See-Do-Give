 /*
 * Copyright (c) 2008 John McMullen (http://www.smple.com)
 * This is licensed under GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For a copy of the GNU General Public License, see <http://www.gnu.org/licenses/>.
 *
*/ 
 
 (function($){
	$.fn.videoGallery = function(options){
	
		var defaults = {
            w: 320,
            h: 240,
            holderDiv: '#video-holder',
            src: 'rel',
			showTitle: true,
            title: 'title',
            titleLoc: '#video-title'
		};
		
		var options = $.extend(defaults, options);

		var element = this;
		
		return this.each(function(){
         src = $(options.holderDiv).attr(options.src);
         title = $(options.holderDiv).attr(options.title);
         
         if (options.showTitle === true){
            $(options.titleLoc)
               .text(title);  
         }
         
         $(options.holderDiv)
            .html('<object width="'+options.w+'px" height="'+options.h+'px"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="'+src+'.swf" /><embed src="'+src+'.swf" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'+options.w+'px" height="'+options.h+'px"></embed></object>');
                  
         $(this).
            click(
               function(){
                  src = $(this).attr(options.src);
                  title = $(this).attr(options.title);
                  
                  $(options.holderDiv)
                     .html('<object width="'+options.w+'px" height="'+options.h+'px"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="'+src+'.swf" /><embed src="'+src+'.swf" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'+options.w+'px" height="'+options.h+'px"></embed></object>');
                  
                  if (options.showTitle === true){
                     $(options.titleLoc)
                        .text(title);  
                  }
               }
            )
		}); // end this.each
	
	}; // end fn.videoGallery
	
})(jQuery);