jQuery(document).ready(function() {
	var sidebar_news = jQuery('.widget.widget_recent_entries');
	var sidebar_search = jQuery('.widget.widget_search');
	var sidebar_cats = jQuery('.widget.widget_categories');
	if (sidebar_news !== null) {
		sidebar_news.prepend('<i class="fa fa-file-o" aria-hidden="true"></i>');
		sidebar_news.addClass('has_icon');
	}
	if (sidebar_search !== null) {
		sidebar_search.prepend('<i class="fa fa-search" aria-hidden="true"></i>');
		sidebar_search.addClass('has_icon');
	}
	if (sidebar_cats !== null) {
		sidebar_cats.prepend('<i class="categories-icon glyphicon glyphicon-th-list" aria-hidden="true"></i>');
		sidebar_cats.addClass('has_icon');
	}
});