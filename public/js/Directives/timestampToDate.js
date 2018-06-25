app.directive('timestampToDate', function() {
        return {
            require: 'ngModel',
            link: function(scope, ele, attr, ngModel) {
                console.log('here');
                // converts DOM value to ng-model
                ngModel.$parsers.push(function(value) {
                    return Date.parse(value);
                });

                // converts ng-model to DOM value
                ngModel.$formatters.push(function(value) {
                    var date = new Date(value);
                    return date;
                });
            }
        }
    });