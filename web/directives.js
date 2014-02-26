'use strict';

/* Directives */
var lubanlockDirectives = angular.module('lubanlockDirectives', []);

lubanlockDirectives.directive('lubanDropzone', function(){
	return {
		compile: function(tElement, tAttrs, transclude){
			tElement.dropzone({
				paramName: "file", // The name that will be used to transfer the file
				maxFilesize: 10, // MB
				url: 'file/upload',
				addRemoveLinks : true,
				dictDefaultMessage :
				'<span class="bigger-150 bolder"><i class="icon-caret-right red"></i> 上传你的简历</span>  拖放到这里\
				<span class="smaller-80 grey">（或点击选择文件）</span> <br /> \
				<i class="upload-icon icon-cloud-upload blue icon-3x"></i>',
				dictResponseError: 'Error while uploading file!',

				//change the previewTemplate to use Bootstrap progress bars
				previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
			});
		}
	}
});

lubanlockDirectives.directive('lubanEditable', ['Object', function(Object){
	return {
		restrict: 'A',
		templateUrl: 'partials/editable.html',
		transclude: true,
		scope:{
			object: '=',
			value: '=lubanEditable',
			type: '@',
			options: '=',
			name: '@lubanEditable'
		},
		link: function(scope, element, attr){
			
			scope.isEditing = false;
			
			scope.$watch('value', function(newValue){
				if(angular.isArray(newValue)){
					scope.value = newValue.pop();
				}
			});
			
			scope.$watch('object.id', function(newValue){
				if(newValue !== undefined && scope.value === undefined){
					scope.isEditing = true;
				}
			});
			
			scope.edit = function(){
				scope.isEditing = true;
				scope.oldValue = scope.value;
				setTimeout(function(){//解决click事件触发之后不能自动focus
					element.find('input').trigger('focus');
				});
			}
			
			scope.editCompleted = function(){
				scope.isEditing = false;
			}
			
			scope.editCanceled = function(){
				scope.isEditing = false;
				scope.value = scope.oldValue;
				scope.save();
			}
			
			scope.save = function(){
				
				var prop = attr.lubanEditable.match(/\.([^.^\[]*)/)[1];
				
				var data = {};
				
				switch(prop){
					case 'meta':
						var key = attr.lubanEditable.match(/\['(.*?)'\]/)[1];
						data = scope.value;
						Object.updateMeta({id: scope.object.id, key: key}, data);
						break;
					
					case 'status':
						//TODO
						break;
					
					case 'relative':
						//TODO
						break;
					
					case 'tag':
						//TODO
						break;
					
					default:
						data[prop] = scope.value;
						Object.update({id: scope.object.id}, data);
				}
			}
			
		}
	}
}]);

lubanlockDirectives.directive('lubanEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.lubanEnter);
                });

                event.preventDefault();
            }
        });
    };
});

lubanlockDirectives.directive('lubanEsc', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 27) {
                scope.$apply(function (){
                    scope.$eval(attrs.lubanEsc);
                });

                event.preventDefault();
            }
        });
    };
});
