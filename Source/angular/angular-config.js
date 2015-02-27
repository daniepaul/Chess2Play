app.run(['$http', '$rootScope', '$sce', '$location', '$route',
    function($http, $rootScope, $sce, $location, $route) {
        $rootScope.$on('$routeChangeStart', function(event, next, current) {
			if(next.templateUrl =="templates/profile.html")
			{
				var path = "angular/activeUser-controller.js";
				      $http.get(path).then(function(response) {
						 addScript(path, response.data, scope);
					  });
			}
     /*$("#scriptsPanel").html('<script src="angular/activeUser-controller.js"></script><script src="angular/userprofile-controller.js"></script>');*/
        });
    }]);
	
var scriptPromises = {};
  function addScript(file, js, scope) {
    if (!scriptPromises[file]) { //if this controller hasn't already been loaded
      var deferred = $q.defer();
      //cache promise)
      scriptPromises[file] = deferred.promise;

      //inject js into a script tag
      var script = document.createElement('script');
      script.src = 'data:text/javascript,' + encodeURI(js);
      script.onload = function() {
        //now the script is ready for use, resolve promise to add the script's directive element
        scope.$apply(deferred.resolve());
      };
      document.body.appendChild(script);
      return deferred.promise;
    }
    else { //this script has been loaded before
      return scriptPromises[loadFile]; //return the resolved promise from cache
    }
  }