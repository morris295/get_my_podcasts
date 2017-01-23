var _baseUrl = "";
var Configuration = function() {
	if (window.location.host.indexOf('localhost') !== -1) {
		var path = window.location.pathname;
		var pathParts =path.split('/');
		_baseUrl = '/' + pathParts[1] + '/' + pathParts[2] + '/';
	} else {
		_baseUrl = "http://" + window.location.hostname + "/";
	}
};


Configuration.prototype.getBaseUrl = function() {
	return _baseUrl;
};