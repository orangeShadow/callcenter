$(function(){
    $(function() {
        $( ".datepicker" ).datepicker($.datepicker.regional[ "ru" ]);
    });
});

var app = angular.module('project-property', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('propertyController', function($scope, $http) {

    $scope.properties = [];
    $scope.loading = false;

    $scope.model_initiator = $(".propertyProject").attr('data-model-initiator');
    $scope.model_goal = $(".propertyProject").attr('data-model-goal');
    $scope.link_id = $(".propertyProject").attr('data-link-id');


    $scope.init = function() {
        $scope.loading = true;
        $http.get('/property/?model='+$scope.model_initiator+'&link_id='+$scope.link_id).
            success(function(data, status, headers, config) {
                $scope.properties = data;
                $scope.loading = false;

            });
    }

    $scope.addProperty = function() {
        $scope.loading = true;

        $('.form-inline .form-group').removeClass('has-error');
        if(typeof($scope.property) == "undefined")
        {
            $('.form-inline .form-group').addClass('has-error');
            return false;
        }

        var property = {
            title: $scope.property.title,
            type: $scope.property.type,
            model_initiator :$scope.model_initiator,
            model_goal: $scope.model_goal,
            link_id:$scope.link_id,
            sort:$scope.property.sort,
            _token:$('input[name="_token"]').val()
        }
        $http({
            method:'POST',
            url:'/property',
            data:property,
            'header':{'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.properties.push(data);
            $scope.property = '';
            $scope.loading = false;
        }).error(function(data,status){
            for(k in data.errors)
            {
                console.log($('.form-inline [name="property.'+k+'"]'));
                $('.form-inline [name="property.'+k+'"]').parents('.form-group').addClass('has-error');
            }
        });
    };


    $scope.deleteProperty = function(index) {
        $scope.loading = true;

        var property = $scope.properties[index];
        console.log(property);

        $http.delete('/property/' + property.id)
            .success(function() {
                $scope.properties.splice(index, 1);
                $scope.loading = false;

            });;
    };


    $scope.init();

});