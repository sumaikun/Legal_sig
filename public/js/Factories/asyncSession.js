	var gsd = new get_session_data({resource:SystemServices});

	gsd.execute();

	//$scope.Session = gsd.output();

	async function f1() {
  		var x = await gsd.output(10);
  		$scope.Session = x.user_properties;
  		console.log($scope.Session);
	}

	f1();

	(function () {
    'use strict';

    var SessionService = angular.module("polling", []);

    pollingService
        .factory('$polling', function ($http) {

            var defaultPollingTime = 10000;
            var polls = [];

            return {

                startPolling: function (name, url, pollingTime, callback) {

                    if(!polls[name]) {
                        var poller = function () {
                            return $http.get(url).then(function (response) {
                                callback(response);
                            });
                        }
                    }
                    poller();
                    polls[name] = setInterval(poller, pollingTime || defaultPollingTime);

                }                
            }
        });

}());


angular.module('UserSession', []);


(function() {
    "use strict";

    angular.module("UserSession").factory("SessionData", SessionData);

    SessionData.$inject = ["$http"];

    function SessionData($http,url,data) {
    //return {USU_ID:"729",USU_NOMBRE:"Jesús Alejandro"};
    return $http.post(url,data).then(function (response) {
            if(response.data.status == "OK")
            {
                return response.data;
            }
            else
            {
                alert("No se pudo obtener los datos de sessión");
                return null;
            }
    });
    }

   
})();