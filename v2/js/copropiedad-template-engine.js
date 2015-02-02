$.get('html/primera_columna.htm', function(templates){
			var datum = {};
            var extTemplate = $(templates).filter('#menu_tpl').html();
            var template = Hogan.compile(extTemplate);
            var rendered = template.render(datum);
            $('#primera_columna').append(rendered);
});