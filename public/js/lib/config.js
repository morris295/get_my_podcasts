var _baseUrl = "";
var _preloader = "";
var _miniPreloader = "";
var Configuration = function() {
	if (window.location.host.indexOf('localhost') !== -1) {
		_baseUrl = "/GMP/public/";
	} else {
		_baseUrl = "/";
	}
	
	_preloader = "<div id=\"loader\"><p>Please wait...</p><img src=\""+
	_baseUrl+"image/ajax-loader.gif\" /></div>";
	
	_miniPreloader = "<div id=\"loader-mini\">&nbsp;&nbsp;<img src=\""+_baseUrl+"image/ajax-loader-mini.gif\"/></div>";
};


Configuration.prototype.getBaseUrl = function() {
	return _baseUrl;
};

Configuration.prototype.getPreloader = function() {
	return _preloader;
};

Configuration.prototype.getMiniPreloader = function() {
	return _miniPreloader;
};