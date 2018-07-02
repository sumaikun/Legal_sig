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

    var SessionService = angular.module("services.Session", []);

    pollingService
        .factory('$session', function ($http) {

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