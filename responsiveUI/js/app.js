var app = angular.module('myApp', []);	//'ngSanitize'
var objArray = [];

/*app.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/london', {
		'template' : '<h1>London</h1>' +
				+ '<p>London is the capital city of England. It is the most populous city in the United Kingdom,' +
				+ 'with a metropolitan area of over 13 million inhabitants.</p>' +
				+ '<p>Standing on the River Thames, London has been a major settlement for two millennia,' +
				+ 'its history going back to its founding by the Romans, who named it Londinium.</p>'
	});
}]);*/

app.controller('indexController', ['$scope','$sce',function($scope,$sce){
	$scope.siteTitle = "HTML5 Site";
	
	objArray = [
		{id:1, name:"alok"},
		{id:2, name:"abc"},
		{id:3, name:"xyz"}
	];
	objArray.forEach(function(obj) {
		//var btnElementString = '<button class="edit_btn" id="edit_'+obj.id+'" onclick="editDetails(event)">Edit</button>';
		var btnElementString = '<button class="edit_btn" id="edit_'+obj.id+'">Edit</button>';
		
		/*var wrapper = document.createElement('span');
		var btnElement = document.createElement("button");
		btnElement.innerHTML = "Edit";
		btnElement.onclick = function( e ) {
			editDetails(e, obj);
		}
		wrapper.appendChild(btnElement);
		var btnElementString = wrapper.innerHTML;*/
		
		/*var wrapper = document.createElement('span');
		wrapper.appendChild(btnElement.cloneNode(true));
		var btnElementString = wrapper.innerHTML;*/
		
		//console.log('btnElementString', btnElementString);
		obj.action = $sce.trustAsHtml(btnElementString);
	});
	
	$scope.objArray = objArray;
	
	/*$scope.editDetails = function (obj) {
		console.log('obj',obj);
	};*/
}]);

setTimeout(function(){
	var buttons = document.getElementsByClassName('edit_btn');
	//console.log('buttons',buttons);
	for(var i=0; i<buttons.length; i++){
		//console.log('button'+i, buttons[i]);
		buttons[i].addEventListener('click',function( e ) {
			editDetails(e);
		});
	}
});

function editDetails (e) {
	var objId = e.target.id.split('_')[1];
	//console.log('You clicked..',objId);
	var objClicked = objArray.filter(function(a){ return a.id == objId })[0];
	console.log('Object..',objClicked);
}