	var gsd = new get_session_data({resource:SystemServices});

	gsd.execute();

	//$scope.Session = gsd.output();

	async function f1() {
  		var x = await gsd.output(10);
  		$scope.Session = x.user_properties;
  		console.log($scope.Session);
	}

	f1();