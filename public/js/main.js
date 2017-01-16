;(function(){
    $(function(){
        $(".datepicker").datepicker($.datepicker.regional[ "ru" ]);
    });


    $('button.btn-danger').click(function(e){
        e.preventDefault();
        if(confirm('Вы уверены что хотите удалить этот объект?'))
        {
            $(this).parents('form').submit();
        }
        else
        {
            return false;
        }
    })

    jQuery.fn.extend({
        insertAtCaret: function(myValue){
            return this.each(function(i) {
                if (document.selection) {
                    // Для браузеров типа Internet Explorer
                    this.focus();
                    var sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                }
                else if (this.selectionStart || this.selectionStart == '0') {
                    // Для браузеров типа Firefox и других Webkit-ов
                    var startPos = this.selectionStart;
                    var endPos = this.selectionEnd;
                    var scrollTop = this.scrollTop;
                    this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                    this.focus();
                    this.selectionStart = startPos + myValue.length;
                    this.selectionEnd = startPos + myValue.length;
                    this.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }
            })
        }
    });

    $('a.addTypicalDescription').click(function(){
        $("#text").insertAtCaret($('#typicalDescriptionSelect').find('option:selected').html());
    })

})();

var app = angular.module('project', [], function($interpolateProvider) {
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
        $http.get('/property/?model=' + $scope.model_initiator + '&link_id=' + $scope.link_id).success(function (data, status, headers, config) {
            $scope.properties = data;
            $scope.loading = false;

        });


    };

    $scope.addProperty = function() {
        $scope.loading = true;

        $('form.property .form-group').removeClass('has-error');
        if(typeof($scope.property) == "undefined")
        {
            $('form.property .form-group').addClass('has-error');
            return false;
        }

        var property = {
            title: $scope.property.title,
            code: $scope.property.code,
            type: $scope.property.type,
            model_initiator :$scope.model_initiator,
            model_goal: $scope.model_goal,
            link_id:$scope.link_id,
            sort:$scope.property.sort,
            values:[],
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
                $('form.property [name="property.'+k+'"]').parents('.form-group').addClass('has-error');
            }
        });
    };


    $scope.deleteProperty = function(index) {
        $scope.loading = true;

        var property = $scope.properties[index];

        $http.delete('/property/' + property.id)
            .success(function() {
                $scope.properties.splice(index, 1);
                $scope.loading = false;

            });
    };


    $scope.addValues = function(index) {
        $scope.properties[index].values.push('');
    };


    $scope.saveValues = function(index) {
        $http.put('/property/' + $scope.properties[index].id,$scope.properties[index])
            .success(function() {
                $('#modal-'+index).hide();
            });
    };

    $scope.removePropertyValue = function(index,propertyIndex) {
        $scope.properties[propertyIndex].values.splice(index,1);
    };

    $scope.init();

});


app.controller('destinationController', function($scope, $http) {

    $scope.destinations = [];
    $scope.loading = false;


    $scope.project_id = $(".destinationProject").data('project-id');


    $scope.init = function() {
        $scope.loading = true;
        $http.get('/destination/?project_id='+$scope.project_id).
            success(function(data, status, headers, config) {
                $scope.destinations = data;
                $scope.loading = false;

            });
    }

    $scope.addDestination = function() {
        $scope.loading = true;

        $('form.destination .form-group').removeClass('has-error');
        if(typeof($scope.destination) == "undefined")
        {
            $('form.destination .form-group').addClass('has-error');
            return false;
        }

        var destination = {
            title: $scope.destination.title,
            email:  $scope.destination.email,
            project_id: $scope.project_id,
            sort:$scope.destination.sort,
            _token:$('input[name="_token"]').val()
        }

        $http({
            method:'POST',
            url:'/destination',
            data:destination,
            'header':{'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.destinations.push(data);
            $scope.destination= '';
            $scope.loading = false;
        }).error(function(data,status){
            for(k in data)
            {
                $('form.destination [name="destination.'+k+'"]').parents('.form-group').addClass('has-error');
            }
        });
    };


    $scope.deleteDestination = function(index) {
        $scope.loading = true;

        var destination = $scope.destinations[index];


        $http.delete('/destination/' + destination.id)
            .success(function() {
                $scope.destinations.splice(index, 1);
                $scope.loading = false;

            });;
    };


    $scope.init();

});


app.controller('typicalDescriptionController', function($scope, $http) {

    $scope.typicalDescriptions = [];
    $scope.loading = false;


    $scope.project_id = $(".typicalDescriptionProject").data('project-id');


    $scope.init = function() {
        $scope.loading = true;
        $http.get('/typicalDescription/?project_id='+$scope.project_id).
            success(function(data, status, headers, config) {
                $scope.typicalDescriptions = data;
                $scope.loading = false;

            });
    }

    $scope.addDestination = function() {
        $scope.loading = true;

        $('form.typicalDescription .form-group').removeClass('has-error');
        if(typeof($scope.typicalDescription) == "undefined")
        {
            $('form.typicalDescription .form-group').addClass('has-error');
            return false;
        }

        var typicalDescription = {
            description:  $scope.typicalDescription.description,
            project_id: $scope.project_id,
            sort:$scope.typicalDescription.sort,
            _token:$('input[name="_token"]').val()
        }

        $http({
            method:'POST',
            url:'/typicalDescription',
            data:typicalDescription,
            'header':{'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.typicalDescriptions.push(data);
            $scope.typicalDescription= '';
            $scope.loading = false;
        }).error(function(data,status){
            for(k in data)
            {
                $('form.typicalDescription [name="typicalDescription.'+k+'"]').parents('.form-group').addClass('has-error');
            }
        });
    };


    $scope.deleteTypicalDescription = function(index) {
        $scope.loading = true;

        var typicalDescription = $scope.typicalDescriptions[index];

        console.log(typicalDescription);

        $http.delete('/typicalDescription/' + typicalDescription.id)
            .success(function() {
                $scope.typicalDescriptions.splice(index, 1);
                $scope.loading = false;

            });;
    };


    $scope.init();

});


app.controller('claimTypeController', function($scope, $http) {

    $scope.claimTypes = [];
    $scope.loading = false;


    $scope.project_id = $(".claimTypeProject").data('project-id');


    $scope.init = function() {
        $scope.loading = true;
        $http.get('/claimType/?project_id='+$scope.project_id).
            success(function(data, status, headers, config) {
                $scope.claimTypes = data;
                $scope.loading = false;

            });
    }

    $scope.addClaimType = function() {
        $scope.loading = true;

        $('form.claimType .form-group').removeClass('has-error');
        if(typeof($scope.claimType) == "undefined")
        {
            $('form.claimType .form-group').addClass('has-error');
            return false;
        }

        var claimType = {
            title:  $scope.claimType.title,
            project_id: $scope.project_id,
            price:  $scope.claimType.price,
            sort: $scope.claimType.sort,
            send_mail: (typeof $scope.claimType.send_mail == "undefined" || $scope.claimType.send_mail==false) ? 0:1,
            _token:$('input[name="_token"]').val()
        }

        console.log(claimType);
        $http({
            method:'POST',
            url:'/claimType',
            data:claimType,
            'header':{'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.claimTypes.push(data);
            $scope.claimType= '';
            $('[name="claimType.send_mail"]').val(0).removeAttr('checked');
            $scope.loading = false;
        }).error(function(data,status){
            for(k in data)
            {
                $('form.claimType [name="claimType.'+k+'"]').parents('.form-group').addClass('has-error');
            }
        });
    };


    $scope.deleteClaimType = function(index) {
        $scope.loading = true;

        var claimType = $scope.claimTypes[index];


        $http.delete('/claimType/' + claimType.id)
            .success(function() {
                $scope.claimTypes.splice(index, 1);
                $scope.loading = false;

            });;
    };



    $scope.init();

});