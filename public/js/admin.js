( function() {

  'use strict';

  angular.module('admin',['ngRoute','ngSanitize'])
  .config(['$routeProvider',function($routeProvider){
    $routeProvider
      .when('/',{
        templateUrl:'public/templates/users.html',
        controller:'usersCtrl'
      })
      .when('/links',{
        templateUrl:'public/templates/links.html',
        controller:'linksCtrl'
      })
      .when('/playlists',{
        templateUrl:'public/templates/playlists.html',
        controller:'playlistsCtrl'
      })
      .when('/songs',{
        templateUrl:'public/templates/songs.html',
        controller:'songsCtrl'
      })
      .when('/categories',{
        templateUrl:'public/templates/categories.html',
        controller:'categoriesCtrl'
      })
      .when('/roles',{
        templateUrl:'public/templates/roles.html',
        controller:'rolesCtrl'
      })
      .otherwise({
        templateUrl:'public/templates/users.html',
        controller:'usersCtrl'
      })
  }])

  .controller('rolesCtrl',['$scope','$http',function($scope,$http){
    $http.get('/api/get_all_roles.php').then(function(response){
      $scope.roles = response.data;
    }).catch(function(error){
      alert('Error while getting roles, please try again...');
    });
  }])

  .controller('categoriesCtrl',['$scope','$http',function($scope,$http){
    $scope.newCategoryName = '';

    $scope.editCategory = function(id) {
      const category = $scope.categories.find(x => x.id_category === id);

      const data = {
        id:id,
        category_name:category.category_name
      };

      $http.post('api/edit_category.php',data).then(function(response){
        console.log(response);
        if ( response.data.success === true ) {
          alert('successfully updated...');
        } else {
          alert('Error ocurred, please try again...');
        }
      }).catch(function(error){
        alert('Error while updating, please try again...');
      });
    }

    const getAll = function() {
      $http.get('api/get_all_categories.php').then(function(response){
        $scope.categories = response.data;
        console.log(response);
      }).catch(function(error){
        alert('Error while getting categories, please try again...');
      });
    }

    $scope.addCategory = function() {
      if ( !$scope.newCategoryName ) return;

      $http.post('/api/add_category.php',{ name:$scope.newCategoryName }).then(function(response){
        getAll();

        $scope.newCategoryName = '';
      }).catch(function(error){
        alert('Error ocurred, please try again...');
      })
    }

    $scope.deleteCategory = function(id) {
      $http.post('/api/delete_category.php',{ id:id }).then(function(response){
        if ( response.data.success === true ) {
          const index = $scope.category.findIndex(x => x.id_category === id);

          $scope.categories.splice(index,1)
        } else {
          alert('Error ocurred, please try again...');
        }
      }).catch(function(error){
        console.log(error);
        alert('Error ocurred, please try again...');
      });
    }

    getAll();
  }])

  .controller('songsCtrl',['$scope','$http',function($scope,$http){
    $scope.deleteSong = function(id_song) {
      $http.post('/api/delete_song.php',{ id:id_song }).then(function(response){
        if ( response.data.success === true ) {
          const index = $scope.songs.findIndex(x => x.id_song === id_song);

          $scope.songs.splice(index,1)
        } else {
          alert('Error ocurred, please try again...');
        }
      }).catch(function(error){
        alert('Error ocurred while deleting this song, please try again...');
      });
    }

    $http.get('/api/get_all_songs.php').then(function(response){
      $scope.songs = response.data;
    }).catch(function(error){
      alert('Error while getting songs, please try again...');
    });
  }])

  .controller('playlistsCtrl',['$scope','$http',function($scope,$http){
    $scope.deletePlaylist = function(id_playlist) {
      $http.post('/api/delete_playlist.php',{ id:id_playlist }).then(function(response){
        if ( response.data.success === true ) {
          const index = $scope.playlists.findIndex(x => x.id_playlist === id_playlist);

          $scope.playlists.splice(index,1)
        } else {
          alert('Error ocurred, please try again...');
        }
      }).catch(function(error){
        console.log(error);
      });
    }

    $http.get('/api/get_all_playlists.php').then(function(response){
      $scope.playlists = response.data;
    }).catch(function(error){
      alert('Error while getting playlists, please refresh your browser...');
    })
  }])

  .controller('linksCtrl',['$scope','$http',function($scope,$http){
    $scope.deleteLink = function(id_link) {
      $http.post('/api/delete_link.php',{ id:id_link }).then(function(response){
        if ( response.data.success === true ) {
          const index = $scope.links.findIndex(x => x.id_link === id_link);

          $scope.links.splice(index,1)
        } else {
          alert('Error ocurred, please try again...');
        }
      }).catch(function(error){
        alert('Error ocurred, please try again...');
      });
    }

    $scope.editLink = function(id_link) {
      const link = $scope.links.find(x => x.id_link === id_link);

      const data = {
        id_link:id_link,
        link_name:link.link_name,
        link_order:link.link_order,
        permission:link.permission
      };

      $http.post('/api/edit_link.php',data).then(function(response){
        if ( response.data.success === true ) {
          alert('successfully updated...');
        } else {
          alert('Error ocurred, please try again...');
        }
      }).catch(function(error){
        alert('Error ocurred, please try again...');
      });
    }

    $http.get('/api/get_links.php').then(function(response){
      $scope.links = response.data;
    });
  }])

  .controller('usersCtrl',['$scope','$http',function($scope,$http){
    $scope.deleteUser = function(userID) {
      $http.post('/api/delete_user.php',{ id:userID }).then(function(response){
        if ( response.data.success === true ) {
          const index = $scope.users.findIndex(x => x.id_user === userID);

          $scope.users.splice(index,1)
        } else {
          alert('Error ocurred, please try again. Make sure you are not deleting admin user...');
        }
      });
    }

    $scope.updateUser = function(id) {
      const user = $scope.users.find(x => x.id_user === id);

      const data = {
        userID:user.id_user,
        role_id:user.role_id
      };

      $http.post('/api/update_user.php',data).then(function(response){
        if ( response.data.success === true ) {
          alert('successfully updated...');
        } else {
          alert('Error ocurred, please try again...');
        }
      });
    }

    $http.get('/api/get_all_users.php').then(function(response){
      $scope.users = response.data;
    });
  }])

}());