app.factory('ProfileService',  ['$window', '$http' ,function($window, $http) {
	var profileService = {};

    profileService.data = {};

	profileService.getData = function(){
	  $http.get('apis/getProfile.php?userid='+profileId).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				profileService.data = data.user;
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
		return profileService.data;
	};
  	
	return profileService;
	
}]);
