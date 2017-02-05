/**
 * Created by isasetiawan on 30/01/2017.
 */

var domain = document.location.origin; //gantilah dengan domain sebenarnya

var app = angular.module("mainapp",['ui.router','satellizer','ngFileUpload']);

app.config(function ($stateProvider, $urlRouterProvider, $authProvider) {

    $authProvider.loginUrl = domain+'api/auth';
    $urlRouterProvider.otherwise('/');

    var login = {
        name:'masuk',
        url:'/',
        templateUrl:'templates/login.htm',
        controller:'loginCtrl'
    };

    var dashboard = {
        name:'dashboard',
        url:'/dashboard',
        templateUrl:'templates/dashboard.htm',
        controller:'dashboardCtrl'
    };

    var lantas = {
        name:'dashboard.lantas',
        url:'/lantas',
        templateUrl:'templates/lantas.htm',
        controller:'lantasCtrl'
    };

    var depeo = {
        name:'dashboard.depeo',
        url:'/depeo',
        templateUrl:'templates/depeo.htm',
        controller:'depeoCtrl'
    };

    var oranghilang = {
        name:'dashboard.olang',
        url:'/olang',
        templateUrl:'templates/olang.htm',
        controller:'olangCtrl'
    };

    $stateProvider.state(login);
    $stateProvider.state(dashboard);
    $stateProvider.state(lantas);
    $stateProvider.state(depeo);
    $stateProvider.state(oranghilang);

});

app.controller("dashboardCtrl",function ($auth,$state) {
    if (!$auth.isAuthenticated()){
        $state.go('masuk');
    }
});

app.controller('olangCtrl',function ($scope, $http, Upload, $timeout) {
    //fungsi load data
    var loaddata = function () {
        $http.get(domain+'api/orangHilang/index')
            .then(function (response) {
                $scope.olangs = response.data;
                console.log(response);
            })
    };
    loaddata();
    //fungsi hapus
    $scope.Hapus = function (id) {
        $http.delete(domain+'api/orangHilang/'+id+'/delete')
            .then(function (response) {
                loaddata();
                alert("Terhapus")
            });
    };
    //fungsi validasi
    $scope.validate = function (id) {
        $http.put(domain+'api/orangHilang/'+id+'/validate')
            .then(function (response) {
                console.log(response);
                loaddata();
            })
    };
    //fungsi unggah
    $scope.unggah = function (file, errFiles) {
        $scope.f = file;
        $scope.errfile = errFiles && errFiles[0];
        if (file){
            $scope.selected.file = file;
            file.upload = Upload.upload({
                url:domain+'api/orangHilang/new',
                data:$scope.selected
            });
            console.log($scope.selected);

            file.upload.then(function (response) {
                console.log(response);
                alert(response.data);
                loaddata();
                $timeout(function () {
                    file.result = response.data;
                });
            },function (response) {
                if (response.status > 0){
                    $scope.errorMsg = response.status + ': ' + response.data;
                }
            },function (evt) {
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
    };
});

app.controller('depeoCtrl',function ($scope, $http, Upload, $timeout) {
    //fungsi load data
    var loaddata = function () {
        $http.get(domain+'api/DPO/index')
            .then(function (response) {
                $scope.depeos = response.data;
                console.log(response);
            })
    };
    loaddata();
    //fungsi validasi
    $scope.validate = function (id) {
        $http.put(domain+'api/DPO/'+id+'/validate')
            .then(function (response) {
                console.log(response);
                loaddata();
            })
    };
    //fungsi unggah
    $scope.unggah = function (file, errFiles) {
        $scope.f = file;
        $scope.errfile = errFiles && errFiles[0];
        if (file){
            $scope.selected.file = file;
            file.upload = Upload.upload({
                url:domain+'api/DPO/new',
                data:$scope.selected
            });
            console.log($scope.selected);

            file.upload.then(function (response) {
                console.log(response);
                alert(response.data);
                loaddata();
                $timeout(function () {
                    file.result = response.data;
                });
            },function (response) {
                if (response.status > 0){
                    $scope.errorMsg = response.status + ': ' + response.data;
                }
            },function (evt) {
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
    };
    //fungsi hapus
    $scope.Hapus = function (id) {
        $http.delete(domain+'api/DPO/'+id+'/delete')
            .then(function (response) {
                loaddata();
                alert("Terhapus")
            });
    };
});

app.controller("lantasCtrl",function ($scope, $http, Upload, $timeout) {
    //funsi load data
    var loaddata = function () {
        $http.get(domain+'api/Lantas/index')
            .then(function (response) {
                $scope.infos = response.data;
                console.log(response);
            });
    };
    loaddata();

    //fungsi hapus
    $scope.Hapus = function (id) {
        $http.delete(domain+'api/Lantas/'+id+'/delete')
            .then(function (response) {
                loaddata();
                alert("Terhapus")
            });
    };

    //fungsi unggah
    $scope.unggah = function (file, errFiles) {
        $scope.f = file;
        $scope.errfile = errFiles && errFiles[0]
        if (file){
            file.upload = Upload.upload({
                url:domain+'api/Lantas/new',
                data:{file: file, "judul":$scope.konten}
            });

            file.upload.then(function (response) {
                console.log(response);
                alert(response.data.Message);
                loaddata();
                $timeout(function () {
                    file.result = response.data;
                });
            },function (response) {
                if (response.status > 0){
                    $scope.errorMsg = response.status + ': ' + response.data;
                }
            },function (evt) {
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
    }
});

app.controller("loginCtrl",function ($scope, $state, $auth) {
    $scope.login = function () {
        $auth.login({
            username:$scope.username,
            password:$scope.password
        }).then(function (response) {
            console.log(response)
            $state.go('dashboard')
        }).catch(function (response) {
            console.log(response)
        })
    }
});