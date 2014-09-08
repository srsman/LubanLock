'use strict';

/* Services */

var lubanlockServices = angular.module('lubanlockServices', ['ngResource']);

lubanlockServices.service('Object', ['$resource',
	function($resource){
		
		var responseInterceptor = function(response){
			
			// preventing 'null' response from being parsed as string
			// angular did right itself because JSON doesn't actually support single value. 
			// TODO: we need to find a way out to better encode null, empty array and object at backend
			if(response.data === 'null'){
				angular.forEach(response.resource, function(value, key){
					if(!isNaN(key)){
						delete response.resource[key];
					}
				});
			}
			response.resource.$response = response;
			return response.resource;
		}
		
		return $resource('object/:id', {id: '@id'}, {
			get: {method: 'GET', interceptor: {response: responseInterceptor}},
			query: {method: 'GET', isArray: true, interceptor: {response: responseInterceptor}},
			update: {method: 'PUT', interceptor: {response: responseInterceptor}},
			getMeta: {method: 'GET', url: 'object/:object/meta/:key', interceptor: {response: responseInterceptor}},
			saveMeta: {method: 'POST', url: 'object/:object/meta/:key', interceptor: {response: responseInterceptor}},
			updateMeta: {method: 'PUT', url: 'object/:object/meta/:key', interceptor: {response: responseInterceptor}},
			removeMeta: {method: 'DELETE', url: 'object/:object/meta/:key', interceptor: {response: responseInterceptor}},
			getRelative: {method: 'GET', url: 'object/:object/relative/:relation'},
			saveRelative: {method: 'POST', url: 'object/:object/relative/:relation', interceptor: {response: responseInterceptor}},
			removeRelative: {method: 'DELETE', url: 'object/:object/relative/:relation', interceptor: {response: responseInterceptor}},
			getStatus: {method: 'GET', url: 'object/:object/status/:name', isArray: true},
			saveStatus: {method: 'POST', url: 'object/:object/status/:name', isArray: true},
			updateStatus: {method: 'PUT', url: 'object/:object/status/:name', isArray: true},
			removeStatus: {method: 'DELETE', url: 'object/:object/status/:name', isArray: true},
			getTag: {method: 'GET', url: 'object/:object/tag/:taxonomy'},
			saveTag: {method: 'POST', url: 'object/:object/tag/:taxonomy', interceptor: {response: responseInterceptor}},
			removeTag: {method: 'DELETE', url: 'object/:object/tag/:taxonomy', interceptor: {response: responseInterceptor}},
			authorize: {method: 'POST', url: 'object/:object/authorize/:permission'},
			prohibit: {method: 'POST', url: 'object/:object/prohibit/:permission'}
		});
	}
]);

lubanlockServices.service('User', ['$resource',
	function($resource){
		return $resource('user/:id', {id: '@id'}, {
			update: {method: 'PUT'},
			getConfig: {method: 'GET', url:'user/config/:item'},
			saveConfig: {method: 'POST', url:'user/config/:item'}
		});
	}
]);

lubanlockServices.service('Company', ['$resource',
	function($resource){
		return $resource('company/:id', {id: '@id'}, {
			update: {method: 'PUT'},
			getConfig: {method: 'GET', url:'company/config/:item'},
			saveConfig: {method: 'POST', url:'company/config/:item'}
		});
	}
]);

// register the interceptor as a service
lubanlockServices.service('HttpInterceptor', ['$q', '$timeout', 'Alert', function($q, $timeout, Alert) {
	
	return {
		request: function(config) {

			if(config && config.cache === undefined){
				
				config.alert = {normal: {}, slow: {}};

				config.alert.normal.timeout = $timeout(function(){
					config.alert.normal.id = Alert.add('正在加载...');
				}, 200);

				config.alert.slow.timeout = $timeout(function(){
					Alert.close(config.alert.normal.id);
					config.alert.slow.id = Alert.add('仍在继续...');
				}, 5000);
				
				return config;
			}
			
			return config || $q.when(config);
		},
		requestError: function(rejection) {
			return $q.reject(rejection);
		},
		response: function(response) {

			if(response && response.config.cache === undefined){
				$timeout.cancel(response.config.alert.normal.timeout);
				$timeout.cancel(response.config.alert.slow.timeout);
				Alert.close(response.config.alert.normal.id);
				Alert.close(response.config.alert.slow.id);
			}
			
			return response || $q.when(response);
		},
		responseError: function(rejection) {
			
			$timeout.cancel(rejection.config.alert.normal.timeout);
			$timeout.cancel(rejection.config.alert.slow.timeout);
			Alert.close(rejection.config.alert.normal.id);
			Alert.close(rejection.config.alert.slow.id);
			
			rejection.statusText = angular.fromJson('"' + rejection.statusText + '"');
			Alert.add(rejection.statusText, 'danger', true);
			
			return $q.reject(rejection);
		}
	};
}]);

lubanlockServices.service('Alert', [function(){
	
	var items = [];
		
	this.get = function(){
		return items;
	},

	this.add = function(message, type) {
		var id = new Date().getTime();
		items.push({id: id, msg: message, type: type === undefined ? 'warning' : type});
		return id;
	},

	this.close = function(id) {
		if(id === undefined){
			return;
		}
		for(var index in items){
			if (items[index].id === id){
				break;
			}
		}
		items.splice(index, 1);
	}
		
}]);

lubanlockServices.service('Nav', ['$resource',
	function($resource){
		
		var Resource = $resource('object/:id', {id: '@id'}, {query: {method: 'GET', isArray: true, params: {type:'nav', has_relative_like: 'MY_GROUPS', with: ['meta']}}});
		var items = Resource.query();
		
		return {
			query: function(){
				return items;
			},
			save: function(data, success){
				
				angular.forEach(data.params, function(item){
					if(angular.isObject(item) || angular.isArray(item)){
						item = angular.toJson(item);
					}
				});
				
				var params = angular.toJson(data.params);
				
				var item = new Resource({
					name: data.name,
					type: 'nav',
					meta: {
						params: params,
						template: data.template
					},
					relative: {
						user: user.id
					},
					permission: 'private'
				});
				
				item.$save({}, function(){
					items.push(item);
					angular.isFunction(success) && success();
				});
				
			},
			remove: function(item, success){
				
				for(var index in items){
					if(items[index].id === item.id){
						items.splice(index, 1);
					}
				}
				
				item.$remove({}, function(){
					angular.isFunction(success) && success();
				});
			}
		};
		
	}
]);
