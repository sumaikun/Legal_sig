app.directive('contenteditable', function($timeout) {
    return {
      restrict: "A",
      priority: 1000,
      scope:{ngModel:"="},
      link: function(scope, element) {
        //console.log(scope.ngModel);
        //console.log(element);       
        element.html(scope.ngModel);        
        element.on('focus blur keyup paste input', function() {
          //console.log(scope.ngModel);
          scope.ngModel = element.text();
          if(!scope.$root.$$phase != '$apply' && scope.$root.$$phase != '$digest')
          {
            scope.$apply();
          }     
          return element;
        });        
      }
    };
  });
