 MySIS.controller('contactController', ['$scope', '$http', function($scope, $http)
 {

 	$scope.getSystemParameters= function()
    {
      $http({
        method : 'GET',
        url: 'getSystemParameters',
        responseType:'json'
      }).success(function(data, status, headers, config)
      {
        console.log(data);

        if(data == null)
        {
              console.log("Error obteniendo parametros de control");
        }
        else if(data != "" || data != null)
        {
              $scope.schoolName= data.school_name;
              $scope.schoolPhone= data.school_phone;
              $scope.schoolAddress= data.school_address;
              $scope.schoolEmail= data.school_email;

        }

      }).error(function(){
        console.log("Error obteniendo parametros de control");
      })

    }

    //Getting system Parameters
    $scope.getSystemParameters();


 }]);